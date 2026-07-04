<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = [
            'Thali' => [
                ['name' => 'Rajasthani Thali', 'price' => 249, 'is_veg' => true, 'description' => 'Dal baati churma, ker sangri, bajre ki roti with ghee', 'variants' => []],
                ['name' => 'Gujarati Thali', 'price' => 219, 'is_veg' => true, 'description' => 'Dal dhokli, undhiyu, shrikhand, puris and 6 sabzis', 'variants' => []],
                ['name' => 'Punjabi Thali', 'price' => 269, 'is_veg' => true, 'description' => 'Dal makhani, paneer butter masala, 4 rotis, rice, raita & gulab jamun', 'variants' => []],
            ],
            'Roti & Paratha' => [
                ['name' => 'Butter Roti (4 pcs)', 'price' => 49, 'is_veg' => true, 'description' => 'Soft whole wheat rotis with butter', 'variants' => []],
                ['name' => 'Aloo Paratha', 'price' => 89, 'is_veg' => true, 'description' => 'Crispy stuffed paratha served with curd and pickle', 'variants' => []],
            ],
            'Rice' => [
                ['name' => 'Veg Biryani', 'price' => 149, 'is_veg' => true, 'description' => 'Dum cooked biryani with seasonal vegetables & saffron', 'variants' => [
                    ['name' => 'Half', 'price_delta' => -60], ['name' => 'Full', 'price_delta' => 0],
                ]],
                ['name' => 'Chicken Biryani', 'price' => 219, 'is_veg' => false, 'description' => 'Hyderabadi-style dum biryani with tender chicken', 'variants' => [
                    ['name' => 'Half', 'price_delta' => -80], ['name' => 'Full', 'price_delta' => 0],
                ]],
                ['name' => 'Jeera Rice', 'price' => 89, 'is_veg' => true, 'description' => 'Basmati rice tempered with cumin and ghee', 'variants' => []],
            ],
            'Sabzi & Curry' => [
                ['name' => 'Dal Makhani', 'price' => 129, 'is_veg' => true, 'description' => 'Slow-cooked black lentils in rich tomato cream sauce', 'variants' => []],
                ['name' => 'Paneer Butter Masala', 'price' => 159, 'is_veg' => true, 'description' => 'Cottage cheese cubes in velvety butter tomato gravy', 'variants' => []],
                ['name' => 'Butter Chicken', 'price' => 229, 'is_veg' => false, 'description' => 'Classic tandoori chicken simmered in creamy tomato gravy', 'variants' => []],
            ],
            'Drinks' => [
                ['name' => 'Masala Chaas', 'price' => 39, 'is_veg' => true, 'description' => 'Spiced buttermilk with jeera and mint', 'variants' => []],
                ['name' => 'Sweet Lassi', 'price' => 59, 'is_veg' => true, 'description' => 'Thick creamy yogurt drink with rose water', 'variants' => []],
                ['name' => 'Nimbu Pani', 'price' => 29, 'is_veg' => true, 'description' => 'Fresh lime water with black salt and mint', 'variants' => []],
            ],
        ];

        $catOrder = 0;
        foreach ($menu as $categoryName => $items) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['sort_order' => $catOrder++, 'is_active' => true]
            );

            $itemOrder = 0;
            foreach ($items as $itemData) {
                $variants = $itemData['variants'];
                unset($itemData['variants']);

                $foodItem = FoodItem::firstOrCreate(
                    ['category_id' => $category->id, 'name' => $itemData['name']],
                    array_merge($itemData, [
                        'is_available' => true,
                        'sort_order' => $itemOrder++,
                    ])
                );

                foreach ($variants as $variant) {
                    $foodItem->variants()->firstOrCreate([
                        'name' => $variant['name'],
                    ], [
                        'price_delta' => $variant['price_delta'],
                    ]);
                }
            }
        }

        $this->command?->info('Seeded ' . count($menu) . ' categories with menu items.');
    }
}
