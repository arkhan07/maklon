<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->truncate();

        $now = now();

        // ---------------------------------------------------------------
        // LEVEL 1 – Root categories
        // ---------------------------------------------------------------
        $level1 = [
            ['name' => 'Baby Care',     'icon' => '👶', 'sort_order' => 1],
            ['name' => 'Personal Care', 'icon' => '🧴', 'sort_order' => 2],
            ['name' => 'Makeup',        'icon' => '💄', 'sort_order' => 3],
            ['name' => "Mom's Care",    'icon' => '🤱', 'sort_order' => 4],
            ['name' => "Men's Care",    'icon' => '👨', 'sort_order' => 5],
            ['name' => 'Perfume',       'icon' => '🌸', 'sort_order' => 6],
            ['name' => 'Home Care',     'icon' => '🏠', 'sort_order' => 7],
        ];

        $l1Ids = [];
        foreach ($level1 as $cat) {
            $id = DB::table('product_categories')->insertGetId([
                'name'       => $cat['name'],
                'slug'       => Str::slug($cat['name']),
                'icon'       => $cat['icon'],
                'parent_id'  => null,
                'level'      => 1,
                'sort_order' => $cat['sort_order'],
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $l1Ids[$cat['name']] = $id;
        }

        // ---------------------------------------------------------------
        // LEVEL 2 – Sub-categories per Level 1
        // ---------------------------------------------------------------
        $level2Map = [
            'Baby Care'     => ['Cleanser', 'Body Care', 'Face Care', 'Hair & Tooth'],
            'Personal Care' => ['Cleanser', 'Moisturizer', 'Treatment', 'Masker', 'Body Care', 'Hair Care', 'Face Care'],
            'Makeup'        => ['Face Decoration', 'Lip Decoration', 'Eye Decoration'],
            "Mom's Care"    => ['Cleanser', 'Body Care', 'Face Care', 'Body Treatment', 'Underarm & Feminine'],
            "Men's Care"    => ['Cleanser', 'Face Care', 'Styling & Color', 'Others', 'Masculine Care'],
            'Perfume'       => ['Perfume'],
            'Home Care'     => ['Kitchen', 'House Care', 'Laundry', 'Shoes Care'],
        ];

        $l2Ids = []; // key: "ParentName|SubName"
        foreach ($level2Map as $parentName => $subs) {
            $parentId = $l1Ids[$parentName];
            foreach ($subs as $order => $subName) {
                $id = DB::table('product_categories')->insertGetId([
                    'name'       => $subName,
                    'slug'       => Str::slug($parentName . '-' . $subName),
                    'icon'       => null,
                    'parent_id'  => $parentId,
                    'level'      => 2,
                    'sort_order' => $order + 1,
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $l2Ids["{$parentName}|{$subName}"] = $id;
            }
        }

        // ---------------------------------------------------------------
        // LEVEL 3 – Sub-sub-categories (2–3 per Level 2)
        // ---------------------------------------------------------------
        // Format: [ "L1Name|L2Name" => [ ['name'=>..., 'slug_suffix'=>...], ... ] ]
        $level3Map = [
            // Baby Care
            'Baby Care|Cleanser'        => [['name' => 'Baby Body Wash'], ['name' => 'Baby Shampoo']],
            'Baby Care|Body Care'       => [['name' => 'Baby Lotion'], ['name' => 'Baby Cream'], ['name' => 'Baby Oil']],
            'Baby Care|Face Care'       => [['name' => 'Baby Sunscreen'], ['name' => 'Baby Lip Balm']],
            'Baby Care|Hair & Tooth'    => [['name' => 'Baby Hair Wash'], ['name' => 'Baby Powder']],

            // Personal Care
            'Personal Care|Cleanser'    => [['name' => 'Facial Wash'], ['name' => 'Micellar Water'], ['name' => 'Cleansing Oil']],
            'Personal Care|Moisturizer' => [['name' => 'Moisturizer Cream'], ['name' => 'Moisturizer Gel'], ['name' => 'Moisturizer Lotion']],
            'Personal Care|Treatment'   => [['name' => 'Toner'], ['name' => 'Serum'], ['name' => 'Ampoule']],
            'Personal Care|Masker'      => [['name' => 'Sheet Mask'], ['name' => 'Clay Mask'], ['name' => 'Sleeping Mask']],
            'Personal Care|Body Care'   => [['name' => 'Body Lotion'], ['name' => 'Body Scrub'], ['name' => 'Body Mist']],
            'Personal Care|Hair Care'   => [['name' => 'Shampoo'], ['name' => 'Conditioner'], ['name' => 'Hair Mask']],
            'Personal Care|Face Care'   => [['name' => 'Serum Wajah'], ['name' => 'Day & Night Cream'], ['name' => 'Sunscreen']],

            // Makeup
            'Makeup|Face Decoration'    => [['name' => 'Foundation'], ['name' => 'Cushion'], ['name' => 'Blush On']],
            'Makeup|Lip Decoration'     => [['name' => 'Lip Matte'], ['name' => 'Lip Gloss'], ['name' => 'Lipstick']],
            'Makeup|Eye Decoration'     => [['name' => 'Mascara'], ['name' => 'Eye Shadow'], ['name' => 'Eye Liner']],

            // Mom's Care
            "Mom's Care|Cleanser"           => [['name' => 'Body Wash Ibu Hamil'], ['name' => 'Shampoo Ibu Hamil']],
            "Mom's Care|Body Care"          => [['name' => 'Body Lotion Ibu Hamil'], ['name' => 'Body Oil Ibu Hamil'], ['name' => 'Stretch Marks Cream']],
            "Mom's Care|Face Care"          => [['name' => 'Serum Ibu Hamil'], ['name' => 'Moisturizer Ibu Hamil'], ['name' => 'Sunscreen Ibu Hamil']],
            "Mom's Care|Body Treatment"     => [['name' => 'Breast Cream'], ['name' => 'Nipple Cream'], ['name' => 'Belly Butter']],
            "Mom's Care|Underarm & Feminine"=> [['name' => 'Feminine Wash Ibu'], ['name' => 'Deodorant Ibu Hamil']],

            // Men's Care
            "Men's Care|Cleanser"       => [['name' => "Men's Body Wash"], ['name' => "Men's Face Wash"], ['name' => "Men's Shampoo"]],
            "Men's Care|Face Care"      => [['name' => "Men's Serum"], ['name' => "Men's Moisturizer"], ['name' => "Men's Sunscreen"]],
            "Men's Care|Styling & Color"=> [['name' => 'Pomade'], ['name' => 'Hair Gel'], ['name' => 'Hair Clay']],
            "Men's Care|Others"         => [['name' => 'Shaving Cream'], ['name' => 'After Shave Lotion'], ['name' => 'Beard Oil']],
            "Men's Care|Masculine Care" => [['name' => 'Masculine Wash'], ['name' => 'Intimate Spray'], ['name' => "Men's Deodorant"]],

            // Perfume
            'Perfume|Perfume'           => [['name' => 'Eau De Parfum'], ['name' => 'Eau De Toilette'], ['name' => 'Body Mist']],

            // Home Care
            'Home Care|Kitchen'         => [['name' => 'Kitchen Cleaner'], ['name' => 'Dishwash'], ['name' => 'Baby Bottle Wash']],
            'Home Care|House Care'      => [['name' => 'Floor Cleaner'], ['name' => 'Glass Cleaner'], ['name' => 'Multi-Purpose Cleaner']],
            'Home Care|Laundry'         => [['name' => 'Liquid Detergent'], ['name' => 'Fabric Softener']],
            'Home Care|Shoes Care'      => [['name' => 'Shoes Cleaner'], ['name' => 'Shoes Spray']],
        ];

        foreach ($level3Map as $key => $children) {
            $parentId = $l2Ids[$key] ?? null;
            if (! $parentId) {
                continue;
            }
            foreach ($children as $order => $child) {
                DB::table('product_categories')->insert([
                    'name'       => $child['name'],
                    'slug'       => Str::slug($key . '-' . $child['name']),
                    'icon'       => null,
                    'parent_id'  => $parentId,
                    'level'      => 3,
                    'sort_order' => $order + 1,
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
