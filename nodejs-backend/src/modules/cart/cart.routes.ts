import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { addToCartSchema, updateQtySchema, checkoutSchema } from './cart.schema';
import {
  getCart,
  addToCart,
  updateCartQty,
  removeCartItem,
  clearCart,
  checkoutCart,
} from './cart.controller';

const router = Router();

// Public storefront cart endpoints (guest sessions)
router.get('/', getCart);
router.post('/add', validate(addToCartSchema), addToCart);
router.patch('/:id/qty', validate(updateQtySchema), updateCartQty);
router.delete('/:id', removeCartItem);
router.delete('/', clearCart);
router.post('/checkout', validate(checkoutSchema), checkoutCart);

export default router;
