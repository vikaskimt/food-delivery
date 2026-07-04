<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Coupon;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    private const STATUS_FLOW = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];

    public function run(): void
    {
        $users = User::with('addresses')->has('addresses')->get();
        $foodItems = FoodItem::all();
        $coupons = Coupon::all();
        $orderManagerAdmin = Admin::role('order_manager')->first() ?? Admin::first();

        if ($users->isEmpty() || $foodItems->isEmpty()) {
            $this->command?->warn('Skipping OrderSeeder: run CustomerSeeder and MenuSeeder first.');
            return;
        }

        foreach (range(1, 25) as $i) {
            $user = $users->random();
            $address = $user->addresses->first();
            $itemsForOrder = $foodItems->random(rand(1, 4));

            $subtotal = 0;
            $orderItemsData = [];
            foreach ($itemsForOrder as $item) {
                $qty = rand(1, 3);
                $lineTotal = $item->price * $qty;
                $subtotal += $lineTotal;

                $orderItemsData[] = [
                    'food_item_id' => $item->id,
                    'name_snapshot' => $item->name,
                    'price_snapshot' => $item->price,
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                ];
            }

            // Randomly apply a coupon to ~30% of orders.
            $coupon = ($coupons->isNotEmpty() && fake()->boolean(30)) ? $coupons->random() : null;
            $discount = 0;
            if ($coupon && $subtotal >= $coupon->min_order_amount) {
                $discount = $coupon->type === 'flat'
                    ? (float) $coupon->value
                    : min($subtotal * ($coupon->value / 100), $coupon->max_discount ?? PHP_FLOAT_MAX);
            } else {
                $coupon = null;
            }

            $deliveryFee = $subtotal > 500 ? 0 : 40;
            $total = max($subtotal - $discount, 0) + $deliveryFee;

            // Weight toward "delivered" so history looks realistic, but keep some in-flight.
            $status = fake()->randomElement([
                'delivered', 'delivered', 'delivered', 'delivered',
                'out_for_delivery', 'preparing', 'confirmed', 'pending', 'cancelled',
            ]);

            $createdAt = fake()->dateTimeBetween('-30 days', 'now');

            $order = Order::create([
                'order_number' => 'ORD' . strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'address_id' => $address->id,
                'coupon_id' => $coupon?->id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => $status,
                'status_updated_by' => $orderManagerAdmin?->id,
                'notes' => fake()->boolean(20) ? fake()->sentence() : null,
                'delivered_at' => $status === 'delivered' ? $createdAt : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            foreach ($orderItemsData as $itemData) {
                OrderItem::create(array_merge(['order_id' => $order->id], $itemData));
            }

            // Build a status history trail up to the order's current status.
            $flowUpTo = $status === 'cancelled'
                ? ['pending', 'confirmed']
                : array_slice(self::STATUS_FLOW, 0, array_search($status, self::STATUS_FLOW) + 1);

            $stepTime = $createdAt;
            foreach ($flowUpTo as $step) {
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $step,
                    'changed_by' => $orderManagerAdmin?->id,
                    'remark' => null,
                    'created_at' => $stepTime,
                    'updated_at' => $stepTime,
                ]);
                $stepTime = (clone $stepTime)->modify('+' . rand(5, 20) . ' minutes');
            }
            if ($status === 'cancelled') {
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => 'cancelled',
                    'changed_by' => $orderManagerAdmin?->id,
                    'remark' => fake()->randomElement(['Customer requested cancellation', 'Item out of stock', 'Payment failed']),
                    'created_at' => $stepTime,
                    'updated_at' => $stepTime,
                ]);
            }
        }

        $this->command?->info('Seeded 25 orders with items and status history.');
    }
}
