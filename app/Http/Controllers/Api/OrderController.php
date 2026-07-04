<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // GET /api/orders
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with('items')
            ->latest()
            ->paginate(15);

        return response()->json($orders);
    }

    // GET /api/orders/{order}
    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()
            ->with(['items', 'address', 'statusHistory'])
            ->findOrFail($id);

        return response()->json($order);
    }

    // POST /api/orders  { address_id, notes? }
    public function store(Request $request)
    {
        $data = $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $user = $request->user();

        // Make sure the address belongs to the user
        $address = $user->addresses()->findOrFail($data['address_id']);

        $cart = $user->cart()->with(['items.foodItem', 'items.variant', 'coupon'])->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty'], 422);
        }

        $order = DB::transaction(function () use ($cart, $user, $address, $data) {
            $subtotal = $cart->subtotal();
            $discount = $cart->coupon ? $cart->coupon->calculateDiscount($subtotal) : 0;
            $deliveryFee = 0; // set your delivery fee logic here later

            $order = Order::create([
                'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'address_id' => $address->id,
                'coupon_id' => $cart->coupon_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => round($subtotal - $discount + $deliveryFee, 2),
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'food_item_id' => $item->food_item_id,
                    'name_snapshot' => $item->foodItem->name.($item->variant ? " ({$item->variant->name})" : ''),
                    'price_snapshot' => $item->price_snapshot,
                    'quantity' => $item->quantity,
                    'line_total' => $item->price_snapshot * $item->quantity,
                ]);
            }

            $order->statusHistory()->create(['status' => 'pending']);

            if ($cart->coupon) {
                $cart->coupon->increment('used_count');
            }

            // Clear the cart
            $cart->items()->delete();
            $cart->update(['coupon_id' => null]);

            return $order;
        });

        return response()->json($order->load('items'), 201);
    }
}
