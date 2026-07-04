<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\FoodItem;
use App\Models\FoodVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /api/cart
    public function show(Request $request)
    {
        $cart = $this->cartFor($request);

        return response()->json($this->formatCart($cart));
    }

    // POST /api/cart/items  { food_item_id, food_variant_id?, quantity }
    public function addItem(Request $request)
    {
        $data = $request->validate([
            'food_item_id' => ['required', 'exists:food_items,id'],
            'food_variant_id' => ['nullable', 'exists:food_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cartFor($request);
        $foodItem = FoodItem::findOrFail($data['food_item_id']);
        $price = (float) $foodItem->price;

        if (! empty($data['food_variant_id'])) {
            $variant = FoodVariant::findOrFail($data['food_variant_id']);
            $price += (float) $variant->price_delta;
        }

        $existing = $cart->items()
            ->where('food_item_id', $data['food_item_id'])
            ->where('food_variant_id', $data['food_variant_id'] ?? null)
            ->first();

        if ($existing) {
            $existing->update(['quantity' => $existing->quantity + $data['quantity']]);
        } else {
            $cart->items()->create([
                'food_item_id' => $data['food_item_id'],
                'food_variant_id' => $data['food_variant_id'] ?? null,
                'quantity' => $data['quantity'],
                'price_snapshot' => $price,
            ]);
        }

        return response()->json($this->formatCart($cart->fresh('items')));
    }

    // PUT /api/cart/items/{item}  { quantity }
    public function updateItem(Request $request, $itemId)
    {
        $cart = $this->cartFor($request);
        $item = $cart->items()->findOrFail($itemId);

        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $item->update($data);

        return response()->json($this->formatCart($cart->fresh('items')));
    }

    // DELETE /api/cart/items/{item}
    public function removeItem(Request $request, $itemId)
    {
        $cart = $this->cartFor($request);
        $cart->items()->where('id', $itemId)->delete();

        return response()->json($this->formatCart($cart->fresh('items')));
    }

    // POST /api/cart/apply-coupon  { code }
    public function applyCoupon(Request $request)
    {
        $data = $request->validate(['code' => ['required', 'string']]);
        $cart = $this->cartFor($request);

        $coupon = Coupon::where('code', $data['code'])->first();

        if (! $coupon || ! $coupon->isValidNow()) {
            return response()->json(['message' => 'Invalid or expired coupon'], 422);
        }

        $subtotal = $cart->subtotal();

        if ($subtotal < $coupon->min_order_amount) {
            return response()->json([
                'message' => "Minimum order amount for this coupon is {$coupon->min_order_amount}",
            ], 422);
        }

        // Per-user usage limit check against past orders
        $usedByUser = \App\Models\Order::where('user_id', $request->user()->id)
            ->where('coupon_id', $coupon->id)
            ->count();

        if ($usedByUser >= $coupon->per_user_limit) {
            return response()->json(['message' => 'Coupon usage limit reached for your account'], 422);
        }

        $cart->update(['coupon_id' => $coupon->id]);

        return response()->json($this->formatCart($cart->fresh('items')));
    }

    // DELETE /api/cart/coupon
    public function removeCoupon(Request $request)
    {
        $cart = $this->cartFor($request);
        $cart->update(['coupon_id' => null]);

        return response()->json($this->formatCart($cart->fresh('items')));
    }

    protected function cartFor(Request $request)
    {
        return $request->user()->cart()->firstOrCreate([]);
    }

    protected function formatCart($cart): array
    {
        $cart->load(['items.foodItem', 'items.variant', 'coupon']);
        $subtotal = $cart->subtotal();
        $discount = $cart->coupon ? $cart->coupon->calculateDiscount($subtotal) : 0;

        return [
            'items' => $cart->items,
            'coupon' => $cart->coupon,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => round($subtotal - $discount, 2),
        ];
    }
}
