import { PrismaClient } from '@prisma/client';
import { CartService } from './modules/cart/cart.service';

const prisma = new PrismaClient();
const cartService = new CartService(prisma);

async function runTests() {
  console.log('====================================================');
  console.log('🚀 RUNNING COMPREHENSIVE CART & PAYMENT USE CASE TESTS');
  console.log('====================================================\n');

  const testSession = `test-sess-${Date.now()}`;
  let passedCount = 0;
  let failedCount = 0;

  function assert(condition: boolean, testName: string, detail?: string) {
    if (condition) {
      console.log(`✅ [PASS] ${testName}`);
      passedCount++;
    } else {
      console.error(`❌ [FAIL] ${testName} - ${detail || 'Assertion failed'}`);
      failedCount++;
    }
  }

  try {
    // ----------------------------------------------------------------
    // TEST 1: Add High Price / Comma Formatted Item (£1,500.00)
    // ----------------------------------------------------------------
    console.log('--- TEST 1: Add £1,500 Cosmelan Treatment to Cart ---');
    const item1 = await cartService.add(testSession, '127.0.0.1', {
      product_id: 'cosmelan-1',
      product_name: 'Cosmelan - Cosmelan Treatment (1x Course)',
      price: 1500.00,
      qty: 1,
      type: 'treatment',
      image: 'https://example.com/cosmelan.jpg'
    });
    assert(Number(item1.price) === 1500, 'Cosmelan item price should be 1500', `Got: ${item1.price}`);
    assert(item1.qty === 1, 'Quantity should be 1', `Got: ${item1.qty}`);

    // ----------------------------------------------------------------
    // TEST 2: List Cart Contents
    // ----------------------------------------------------------------
    console.log('\n--- TEST 2: List Cart Contents & Subtotal ---');
    const cartList1 = await cartService.list(testSession);
    assert(cartList1.items.length === 1, 'Cart items count should be 1', `Got: ${cartList1.items.length}`);
    assert(cartList1.total === 1500, 'Cart total should be 1500.00', `Got: ${cartList1.total}`);

    // ----------------------------------------------------------------
    // TEST 3: Add Second Product (£45.00 Skincare)
    // ----------------------------------------------------------------
    console.log('\n--- TEST 3: Add Second Product (£45.00 Cleanser) ---');
    const item2 = await cartService.add(testSession, '127.0.0.1', {
      product_id: 'product-45',
      product_name: 'Skin Cleanser 200ml',
      price: 45.00,
      qty: 1,
      type: 'product',
      image: 'https://example.com/cleanser.jpg'
    });
    assert(Number(item2.price) === 45, 'Product price should be 45', `Got: ${item2.price}`);

    const cartList2 = await cartService.list(testSession);
    assert(cartList2.items.length === 2, 'Cart items count should be 2', `Got: ${cartList2.items.length}`);
    assert(cartList2.total === 1545, 'Combined cart total should be 1545', `Got: ${cartList2.total}`);
    assert(cartList2.count === 2, 'Total quantity count should be 2', `Got: ${cartList2.count}`);

    // ----------------------------------------------------------------
    // TEST 4: Update Item Quantity (Increment Cleanser to 2)
    // ----------------------------------------------------------------
    console.log('\n--- TEST 4: Update Item Quantity (Cleanser qty: 2) ---');
    await cartService.updateQty(item2.id, 2);
    const cartList3 = await cartService.list(testSession);
    assert(cartList3.total === 1590, 'Cart total should be 1590 (1500 + 45*2)', `Got: ${cartList3.total}`);
    assert(cartList3.count === 3, 'Total items count should be 3', `Got: ${cartList3.count}`);

    // ----------------------------------------------------------------
    // TEST 5: Complete Checkout with Active Session Items
    // ----------------------------------------------------------------
    console.log('\n--- TEST 5: Process Order Checkout with DB Session Items ---');
    const order1 = await cartService.checkout(testSession, {
      first_name: 'Akash',
      last_name: 'Chauhan',
      email: 'chauhan.akash1220@gmail.com',
      phone: '07428815117',
      address: 'Gaur City Center',
      city: 'GAUTAM BUDDHA NAGAR',
      postcode: '201318',
      country: 'UK',
      payment_method: 'card',
      appointment_date: '2026-08-08',
      appointment_slot: '11:30 AM - 12:30 PM'
    });
    assert(!!order1.id, 'Order ID should be created', `Got: ${order1?.id}`);
    assert(Number(order1.order_amount) === 1590, 'Order amount should be 1590', `Got: ${order1.order_amount}`);
    assert(order1.billing_first_name === 'Akash', 'Billing first name matches', `Got: ${order1.billing_first_name}`);

    // Verify DB cart was cleared after checkout
    const cartListAfterCheckout = await cartService.list(testSession);
    assert(cartListAfterCheckout.items.length === 0, 'Cart should be empty after checkout', `Got: ${cartListAfterCheckout.items.length}`);

    // ----------------------------------------------------------------
    // TEST 6: Fallback Checkout Payload (when DB cart empty but items sent in body)
    // ----------------------------------------------------------------
    console.log('\n--- TEST 6: Fallback Payload Checkout (Client localStorage items fallback) ---');
    const fallbackSession = `fallback-sess-${Date.now()}`;
    const order2 = await cartService.checkout(fallbackSession, {
      first_name: 'Test',
      last_name: 'User',
      email: 'test@example.com',
      phone: '07000000000',
      address: '123 Test St',
      city: 'London',
      postcode: 'W11 1AA',
      payment_method: 'card',
      appointment_date: '2026-08-09',
      appointment_slot: '02:00 PM - 03:00 PM',
      items: [
        {
          id: 'cosmelan-1',
          product_id: 'cosmelan-1',
          name: 'Cosmelan - Cosmelan Treatment (1x Course)',
          price: 1500,
          quantity: 1,
          type: 'treatment'
        }
      ]
    });
    assert(!!order2.id, 'Fallback order ID should be created', `Got: ${order2?.id}`);
    assert(Number(order2.order_amount) === 1500, 'Fallback order amount should be 1500', `Got: ${order2.order_amount}`);

    // ----------------------------------------------------------------
    // TEST 7: Empty Cart Exception Handling
    // ----------------------------------------------------------------
    console.log('\n--- TEST 7: Empty Cart Checkout Exception ---');
    const emptySession = `empty-sess-${Date.now()}`;
    let threwError = false;
    try {
      await cartService.checkout(emptySession, {
        first_name: 'Empty',
        email: 'empty@example.com'
      });
    } catch (e: any) {
      threwError = true;
      assert(e.message === 'Cart is empty', 'Should throw "Cart is empty" error', `Got: ${e.message}`);
    }
    assert(threwError, 'Empty checkout must throw error');

    // Clean up created test orders from DB
    if (order1?.id) await prisma.order.delete({ where: { id: order1.id } }).catch(() => {});
    if (order2?.id) await prisma.order.delete({ where: { id: order2.id } }).catch(() => {});

  } catch (error: any) {
    console.error('Unhandled test failure:', error);
    failedCount++;
  } finally {
    await prisma.$disconnect();
  }

  console.log('\n====================================================');
  console.log(`SUMMARY: ${passedCount} PASSED | ${failedCount} FAILED`);
  console.log('====================================================\n');
}

runTests();
