"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.checkoutSchema = exports.updateQtySchema = exports.addToCartSchema = void 0;
const zod_1 = require("zod");
exports.addToCartSchema = zod_1.z.object({
    product_id: zod_1.z.number().int().positive('Product ID is required'),
    product_name: zod_1.z.string().min(1, 'Product name is required'),
    price: zod_1.z.number().nonnegative().optional(),
    qty: zod_1.z.number().int().positive().optional(),
    image: zod_1.z.string().optional(),
    type: zod_1.z.string().optional(),
    session: zod_1.z.string().optional(),
});
exports.updateQtySchema = zod_1.z.object({
    qty: zod_1.z.number().int(),
});
exports.checkoutSchema = zod_1.z.object({
    first_name: zod_1.z.string().min(1, 'First name is required'),
    last_name: zod_1.z.string().optional(),
    email: zod_1.z.string().email('A valid email is required'),
    phone: zod_1.z.string().min(1, 'Phone is required'),
    address: zod_1.z.string().optional(),
    city: zod_1.z.string().optional(),
    postcode: zod_1.z.string().optional(),
    country: zod_1.z.string().optional(),
    payment_method: zod_1.z.string().optional(),
    user_id: zod_1.z.number().int().optional(),
    session: zod_1.z.string().optional(),
    appointment_date: zod_1.z.string().optional(),
    appointment_slot: zod_1.z.string().optional(),
    // Cart items array — used as fallback when DB session cart is empty
    items: zod_1.z.array(zod_1.z.object({
        id: zod_1.z.union([zod_1.z.string(), zod_1.z.number()]).optional(),
        product_id: zod_1.z.union([zod_1.z.string(), zod_1.z.number()]).optional(),
        name: zod_1.z.string().optional(),
        product_name: zod_1.z.string().optional(),
        price: zod_1.z.number().optional(),
        priceNum: zod_1.z.number().optional(),
        quantity: zod_1.z.number().optional(),
        qty: zod_1.z.number().optional(),
        type: zod_1.z.string().optional(),
        image: zod_1.z.string().optional().nullable(),
    })).optional(),
});
//# sourceMappingURL=cart.schema.js.map