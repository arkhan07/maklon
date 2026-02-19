<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Baby Care', 'icon' => '👶', 'sort_order' => 1, 'children' => [
                ['name' => 'Cleanser', 'children' => [
                    ['name' => 'Body Wash'],
                    ['name' => 'Hair Wash / Shampoo'],
                ]],
                ['name' => 'Body Care', 'children' => [
                    ['name' => 'Baby Lotion'],
                    ['name' => 'Baby Cream'],
                    ['name' => 'Baby Oil'],
                ]],
                ['name' => 'Face Care', 'children' => [
                    ['name' => 'Sunscreen'],
                    ['name' => 'Bedak Bayi'],
                    ['name' => 'Lip Balm'],
                ]],
                ['name' => 'Hair & Tooth', 'children' => [
                    ['name' => 'Baby Hair Tonic'],
                    ['name' => 'Baby Toothpaste'],
                    ['name' => 'Baby Cologne'],
                ]],
            ]],
            ['name' => 'Personal Care', 'icon' => '🧴', 'sort_order' => 2, 'children' => [
                ['name' => 'Face Care', 'children' => [
                    ['name' => 'Serum Anti Acne'],
                    ['name' => 'Serum Anti Aging'],
                    ['name' => 'Serum Vitamin C'],
                    ['name' => 'Facial Wash'],
                    ['name' => 'Micellar Water'],
                    ['name' => 'Day Cream'],
                    ['name' => 'Night Cream'],
                    ['name' => 'Sunscreen'],
                    ['name' => 'Eye Cream'],
                    ['name' => 'Lip Serum'],
                ]],
                ['name' => 'Treatment', 'children' => [
                    ['name' => 'Toner'],
                    ['name' => 'Essence'],
                    ['name' => 'Ampoule'],
                    ['name' => 'Sheet Mask'],
                    ['name' => 'Clay Mask'],
                    ['name' => 'Sleeping Mask'],
                ]],
                ['name' => 'Body Care', 'children' => [
                    ['name' => 'Body Lotion'],
                    ['name' => 'Body Butter'],
                    ['name' => 'Body Serum'],
                    ['name' => 'Body Scrub'],
                    ['name' => 'Hand Cream'],
                    ['name' => 'Hand Sanitizer'],
                    ['name' => 'Deodorant'],
                    ['name' => 'Feminine Wash'],
                ]],
                ['name' => 'Hair Care', 'children' => [
                    ['name' => 'Shampoo'],
                    ['name' => 'Conditioner'],
                    ['name' => 'Hair Serum'],
                    ['name' => 'Hair Mask'],
                    ['name' => 'Hair Tonic'],
                    ['name' => 'Hair Oil'],
                    ['name' => 'Hair Growth Serum'],
                ]],
                ['name' => 'Cleanser', 'children' => [
                    ['name' => 'Body Wash'],
                    ['name' => 'Exfoliating Scrub'],
                    ['name' => 'Cleansing Oil'],
                    ['name' => 'Cleansing Balm'],
                ]],
            ]],
            ['name' => 'Makeup', 'icon' => '💄', 'sort_order' => 3, 'children' => [
                ['name' => 'Face Decoration', 'children' => [
                    ['name' => 'Foundation'],
                    ['name' => 'Cushion'],
                    ['name' => 'Setting Spray'],
                    ['name' => 'Blush On'],
                    ['name' => 'Contour'],
                ]],
                ['name' => 'Lip Decoration', 'children' => [
                    ['name' => 'Lip Matte'],
                    ['name' => 'Lip Gloss'],
                    ['name' => 'Lipstick'],
                    ['name' => 'Lip Tint'],
                ]],
                ['name' => 'Eye Decoration', 'children' => [
                    ['name' => 'Mascara'],
                    ['name' => 'Eye Brow'],
                    ['name' => 'Eye Shadow'],
                    ['name' => 'Eye Liner'],
                ]],
            ]],
            ['name' => "Mom's Care", 'icon' => '🤱', 'sort_order' => 4, 'children' => [
                ['name' => 'Cleanser', 'children' => [
                    ['name' => 'Body Wash'],
                    ['name' => 'Shampoo'],
                ]],
                ['name' => 'Body Care', 'children' => [
                    ['name' => 'Body Lotion'],
                    ['name' => 'Body Cream'],
                    ['name' => 'Body Oil'],
                    ['name' => 'Stretch Marks Cream'],
                    ['name' => 'Breast Cream'],
                    ['name' => 'Belly Butter'],
                ]],
                ['name' => 'Face Care', 'children' => [
                    ['name' => 'Sunscreen'],
                    ['name' => 'Serum'],
                    ['name' => 'Moisturizer'],
                    ['name' => 'Facial Wash'],
                ]],
                ['name' => 'Underarm & Feminine', 'children' => [
                    ['name' => 'Feminine Wash'],
                    ['name' => 'Deodorant'],
                    ['name' => 'Intimate Serum'],
                ]],
            ]],
            ['name' => "Men's Care", 'icon' => '👨', 'sort_order' => 5, 'children' => [
                ['name' => 'Cleanser', 'children' => [
                    ['name' => 'Body Wash'],
                    ['name' => 'Shampoo'],
                    ['name' => 'Face Wash'],
                ]],
                ['name' => 'Face Care', 'children' => [
                    ['name' => 'Serum'],
                    ['name' => 'Moisturizer'],
                    ['name' => 'Sunscreen'],
                    ['name' => 'After Shave'],
                ]],
                ['name' => 'Styling & Color', 'children' => [
                    ['name' => 'Pomade'],
                    ['name' => 'Hair Gel'],
                    ['name' => 'Hair Color'],
                    ['name' => 'Hair Wax'],
                ]],
                ['name' => 'Masculine Care', 'children' => [
                    ['name' => 'Masculine Wash'],
                    ['name' => 'Masculine Spray'],
                    ['name' => 'Shaving Cream'],
                ]],
            ]],
            ['name' => 'Perfume', 'icon' => '🌸', 'sort_order' => 6, 'children' => [
                ['name' => 'Perfume', 'children' => [
                    ['name' => 'Eau De Parfum'],
                    ['name' => 'Eau De Toilette'],
                    ['name' => 'Eau De Cologne'],
                    ['name' => 'Body Mist'],
                    ['name' => 'Extraits Parfum'],
                ]],
            ]],
            ['name' => 'Home Care', 'icon' => '🏠', 'sort_order' => 7, 'children' => [
                ['name' => 'Kitchen', 'children' => [
                    ['name' => 'Kitchen Cleaner'],
                    ['name' => 'Dishwash Liquid'],
                    ['name' => 'Hand Wash'],
                ]],
                ['name' => 'House Care', 'children' => [
                    ['name' => 'Floor Cleaner'],
                    ['name' => 'Glass Cleaner'],
                    ['name' => 'Desinfectant'],
                    ['name' => 'Room Spray'],
                    ['name' => 'Room Diffuser'],
                    ['name' => 'Bathroom Cleaner'],
                ]],
                ['name' => 'Laundry', 'children' => [
                    ['name' => 'Liquid Detergent'],
                    ['name' => 'Fabric Softener'],
                    ['name' => 'Laundry Perfume'],
                ]],
                ['name' => 'Shoes Care', 'children' => [
                    ['name' => 'Shoes Cleaner'],
                    ['name' => 'Shoes Spray'],
                ]],
            ]],
        ];

        foreach ($categories as $sort => $cat) {
            $parent = ProductCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'icon' => $cat['icon'] ?? null,
                'level' => 1,
                'sort_order' => $cat['sort_order'] ?? $sort,
                'is_active' => true,
            ]);

            foreach ($cat['children'] ?? [] as $s2i => $sub) {
                $l2 = ProductCategory::create([
                    'parent_id' => $parent->id,
                    'name' => $sub['name'],
                    'slug' => Str::slug($cat['name'] . '-' . $sub['name']),
                    'level' => 2,
                    'sort_order' => $s2i,
                    'is_active' => true,
                ]);

                foreach ($sub['children'] ?? [] as $s3i => $leaf) {
                    $l3 = ProductCategory::create([
                        'parent_id' => $l2->id,
                        'name' => $leaf['name'],
                        'slug' => Str::slug($cat['name'] . '-' . $sub['name'] . '-' . $leaf['name']),
                        'level' => 3,
                        'sort_order' => $s3i,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
