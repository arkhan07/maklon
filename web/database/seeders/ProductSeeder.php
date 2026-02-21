<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        $now       = now();
        $basePrice = 10000;
        $minQty    = 100;

        // ------------------------------------------------------------------
        // Helper: resolve a level-1 category slug to its ID
        // ------------------------------------------------------------------
        $catCache = [];
        $resolveCategory = function (string $l1Name, ?string $l2Name = null) use (&$catCache): int {
            $key = $l1Name . '|' . ($l2Name ?? '');
            if (isset($catCache[$key])) {
                return $catCache[$key];
            }

            $l1Slug = Str::slug($l1Name);
            $l1     = DB::table('product_categories')->where('slug', $l1Slug)->where('level', 1)->first();
            if (! $l1) {
                throw new \RuntimeException("Level-1 category not found: {$l1Name}");
            }

            if ($l2Name) {
                $l2Slug = Str::slug($l1Name . '-' . $l2Name);
                $l2     = DB::table('product_categories')->where('slug', $l2Slug)->where('level', 2)->first();
                if ($l2) {
                    $catCache[$key] = $l2->id;
                    return $l2->id;
                }
            }

            $catCache[$key] = $l1->id;
            return $l1->id;
        };

        // ------------------------------------------------------------------
        // Product list: [name, l1, l2 (optional)]
        // ------------------------------------------------------------------
        $products = [
            // ── Baby Care (13) ────────────────────────────────────────────
            ['Body Wash',                'Baby Care', 'Cleanser'],
            ['Hair Wash / Shampoo',      'Baby Care', 'Cleanser'],
            ['Baby Lotion',              'Baby Care', 'Body Care'],
            ['Baby Cream',               'Baby Care', 'Body Care'],
            ['Baby Oil',                 'Baby Care', 'Body Care'],
            ['Sunscreen',                'Baby Care', 'Face Care'],
            ['Bedak Bayi',               'Baby Care', 'Face Care'],
            ['Lip Balm',                 'Baby Care', 'Face Care'],
            ['Baby Powder',              'Baby Care', 'Hair & Tooth'],
            ['Baby Cologne',             'Baby Care', 'Hair & Tooth'],
            ['Diaper Cream',             'Baby Care', 'Body Care'],
            ['Baby Massage Oil',         'Baby Care', 'Body Care'],
            ['Baby Hand Sanitizer',      'Baby Care', 'Cleanser'],

            // ── Personal Care – Face Care (18) ────────────────────────────
            ['Serum Anti Acne',          'Personal Care', 'Face Care'],
            ['Serum Anti Aging',         'Personal Care', 'Face Care'],
            ['Serum Vit C',              'Personal Care', 'Face Care'],
            ['Serum Brightening',        'Personal Care', 'Face Care'],
            ['Serum Hydrating',          'Personal Care', 'Face Care'],
            ['Day Cream',                'Personal Care', 'Face Care'],
            ['Night Cream',              'Personal Care', 'Face Care'],
            ['Eye Cream',                'Personal Care', 'Face Care'],
            ['BB Cream',                 'Personal Care', 'Face Care'],
            ['CC Cream',                 'Personal Care', 'Face Care'],
            ['Sunscreen SPF 30',         'Personal Care', 'Face Care'],
            ['Sunscreen SPF 50',         'Personal Care', 'Face Care'],
            ['Face Mist',                'Personal Care', 'Face Care'],
            ['Face Oil',                 'Personal Care', 'Face Care'],
            ['Facial Serum Niacinamide', 'Personal Care', 'Face Care'],
            ['Serum Retinol',            'Personal Care', 'Face Care'],
            ['Face Primer',              'Personal Care', 'Face Care'],
            ['Face Essence',             'Personal Care', 'Face Care'],

            // ── Personal Care – Cleanser (7) ──────────────────────────────
            ['Facial Wash',              'Personal Care', 'Cleanser'],
            ['Micellar Water',           'Personal Care', 'Cleanser'],
            ['Cleansing Balm',           'Personal Care', 'Cleanser'],
            ['Cleansing Oil',            'Personal Care', 'Cleanser'],
            ['Foam Cleanser',            'Personal Care', 'Cleanser'],
            ['Gel Cleanser',             'Personal Care', 'Cleanser'],
            ['Scrub Wajah',              'Personal Care', 'Cleanser'],

            // ── Personal Care – Moisturizer (4) ───────────────────────────
            ['Moisturizer Gel',          'Personal Care', 'Moisturizer'],
            ['Moisturizer Cream',        'Personal Care', 'Moisturizer'],
            ['Moisturizer Lotion',       'Personal Care', 'Moisturizer'],
            ['Face Gel Cream',           'Personal Care', 'Moisturizer'],

            // ── Personal Care – Treatment (5) ─────────────────────────────
            ['Toner',                    'Personal Care', 'Treatment'],
            ['Essence',                  'Personal Care', 'Treatment'],
            ['Ampoule',                  'Personal Care', 'Treatment'],
            ['Serum Exfoliant',          'Personal Care', 'Treatment'],
            ['AHA BHA Toner',            'Personal Care', 'Treatment'],

            // ── Personal Care – Masker (5) ────────────────────────────────
            ['Sheet Mask',               'Personal Care', 'Masker'],
            ['Clay Mask',                'Personal Care', 'Masker'],
            ['Peel Off Mask',            'Personal Care', 'Masker'],
            ['Sleeping Mask',            'Personal Care', 'Masker'],
            ['Wash Off Mask',            'Personal Care', 'Masker'],

            // ── Personal Care – Body Care (10) ────────────────────────────
            ['Body Lotion',              'Personal Care', 'Body Care'],
            ['Body Butter',              'Personal Care', 'Body Care'],
            ['Body Serum',               'Personal Care', 'Body Care'],
            ['Body Oil',                 'Personal Care', 'Body Care'],
            ['Body Scrub',               'Personal Care', 'Body Care'],
            ['Body Mist',                'Personal Care', 'Body Care'],
            ['Hand Cream',               'Personal Care', 'Body Care'],
            ['Hand Sanitizer',           'Personal Care', 'Body Care'],
            ['Foot Cream',               'Personal Care', 'Body Care'],
            ['Stretch Marks Oil',        'Personal Care', 'Body Care'],

            // ── Personal Care – Hair Care (8) ─────────────────────────────
            ['Shampoo',                  'Personal Care', 'Hair Care'],
            ['Conditioner',              'Personal Care', 'Hair Care'],
            ['Hair Mask',                'Personal Care', 'Hair Care'],
            ['Hair Serum',               'Personal Care', 'Hair Care'],
            ['Hair Oil',                 'Personal Care', 'Hair Care'],
            ['Hair Tonic',               'Personal Care', 'Hair Care'],
            ['Hair Mist',                'Personal Care', 'Hair Care'],
            ['Leave In Conditioner',     'Personal Care', 'Hair Care'],

            // ── Personal Care – Others (4, under Body Care / Cleanser) ────
            ['Deodorant Roll On',        'Personal Care', 'Body Care'],
            ['Deodorant Spray',          'Personal Care', 'Body Care'],
            ['Feminine Wash',            'Personal Care', 'Cleanser'],
            ['Intimate Wash',            'Personal Care', 'Cleanser'],

            // ── Makeup (11) ───────────────────────────────────────────────
            ['Foundation',               'Makeup', 'Face Decoration'],
            ['Cushion Foundation',       'Makeup', 'Face Decoration'],
            ['Setting Spray',            'Makeup', 'Face Decoration'],
            ['Blush On',                 'Makeup', 'Face Decoration'],
            ['Lip Matte',                'Makeup', 'Lip Decoration'],
            ['Lip Gloss',                'Makeup', 'Lip Decoration'],
            ['Lipstick',                 'Makeup', 'Lip Decoration'],
            ['Mascara',                  'Makeup', 'Eye Decoration'],
            ['Eye Brow Pencil',          'Makeup', 'Eye Decoration'],
            ['Eye Shadow',               'Makeup', 'Eye Decoration'],
            ['Eye Liner',                'Makeup', 'Eye Decoration'],

            // ── Mom's Care (30) ───────────────────────────────────────────
            ['Body Wash Ibu Hamil',             "Mom's Care", 'Cleanser'],
            ['Shampoo Ibu Hamil',               "Mom's Care", 'Cleanser'],
            ['Body Lotion Ibu Hamil',           "Mom's Care", 'Body Care'],
            ['Body Cream Ibu Hamil',            "Mom's Care", 'Body Care'],
            ['Body Oil Ibu Hamil',              "Mom's Care", 'Body Care'],
            ['Sunscreen Ibu Hamil',             "Mom's Care", 'Face Care'],
            ['Serum Ibu Hamil',                 "Mom's Care", 'Face Care'],
            ['Moisturizer Ibu Hamil',           "Mom's Care", 'Face Care'],
            ['Stretch Marks Cream',             "Mom's Care", 'Body Care'],
            ['Stretch Marks Oil',               "Mom's Care", 'Body Care'],
            ['Breast Cream',                    "Mom's Care", 'Body Treatment'],
            ['Nipple Cream',                    "Mom's Care", 'Body Treatment'],
            ['Feminine Wash Ibu',               "Mom's Care", 'Underarm & Feminine'],
            ['Deodorant Ibu Hamil',             "Mom's Care", 'Underarm & Feminine'],
            ['Belly Butter',                    "Mom's Care", 'Body Treatment'],
            ['Perineal Wash',                   "Mom's Care", 'Underarm & Feminine'],
            ['Baby Blues Aromatherapy Roll On', "Mom's Care", 'Body Treatment'],
            ['Pregnancy Safe Toner',            "Mom's Care", 'Face Care'],
            ['Pregnancy Safe Serum',            "Mom's Care", 'Face Care'],
            ['Post-partum Body Oil',            "Mom's Care", 'Body Care'],
            ['Colostrum Serum',                 "Mom's Care", 'Face Care'],
            ['Lactation Tea Topical',           "Mom's Care", 'Body Treatment'],
            ['Mom Deodorant Spray',             "Mom's Care", 'Underarm & Feminine'],
            ['Mom Foot Cream',                  "Mom's Care", 'Body Care'],
            ['Perineal Spray',                  "Mom's Care", 'Underarm & Feminine'],
            ['Sitz Bath Powder',                "Mom's Care", 'Body Treatment'],
            ['Mom Eye Cream',                   "Mom's Care", 'Face Care'],
            ['Mom Lip Care',                    "Mom's Care", 'Face Care'],
            ['Mom Body Scrub',                  "Mom's Care", 'Body Care'],
            ['Mom Hair Mask',                   "Mom's Care", 'Cleanser'],

            // ── Men's Care (23) ───────────────────────────────────────────
            ["Men's Body Wash",          "Men's Care", 'Cleanser'],
            ["Men's Shampoo",            "Men's Care", 'Cleanser'],
            ["Men's Face Wash",          "Men's Care", 'Cleanser'],
            ["Men's Serum",              "Men's Care", 'Face Care'],
            ["Men's Moisturizer",        "Men's Care", 'Face Care'],
            ["Men's Sunscreen",          "Men's Care", 'Face Care'],
            ['Pomade',                   "Men's Care", 'Styling & Color'],
            ['Hair Gel',                 "Men's Care", 'Styling & Color'],
            ['Hair Clay',                "Men's Care", 'Styling & Color'],
            ['Hair Wax',                 "Men's Care", 'Styling & Color'],
            ['Shaving Cream',            "Men's Care", 'Others'],
            ['After Shave Lotion',       "Men's Care", 'Others'],
            ["Men's Toner",              "Men's Care", 'Face Care'],
            ["Men's Eye Cream",          "Men's Care", 'Face Care'],
            ["Men's Lip Balm",           "Men's Care", 'Face Care'],
            ['Masculine Wash',           "Men's Care", 'Masculine Care'],
            ['Intimate Spray',           "Men's Care", 'Masculine Care'],
            ["Men's Body Scrub",         "Men's Care", 'Cleanser'],
            ["Men's Deodorant Roll On",  "Men's Care", 'Masculine Care'],
            ["Men's Deodorant Spray",    "Men's Care", 'Masculine Care'],
            ['Beard Oil',                "Men's Care", 'Others'],
            ['Beard Balm',               "Men's Care", 'Others'],
            ["Men's Hair Serum",         "Men's Care", 'Styling & Color'],

            // ── Perfume (5) ───────────────────────────────────────────────
            ['Eau De Parfum',            'Perfume', 'Perfume'],
            ['Eau De Toilette',          'Perfume', 'Perfume'],
            ['Eau De Cologne',           'Perfume', 'Perfume'],
            ['Body Mist Perfume',        'Perfume', 'Perfume'],
            ['Extraits Parfum',          'Perfume', 'Perfume'],

            // ── Home Care (19) ────────────────────────────────────────────
            ['Kitchen Cleaner',          'Home Care', 'Kitchen'],
            ['Dishwash',                 'Home Care', 'Kitchen'],
            ['Hand Wash',                'Home Care', 'Kitchen'],
            ['Floor Cleaner',            'Home Care', 'House Care'],
            ['Glass Cleaner',            'Home Care', 'House Care'],
            ['Disinfectant',             'Home Care', 'House Care'],
            ['Room Spray',               'Home Care', 'House Care'],
            ['Room Diffuser',            'Home Care', 'House Care'],
            ['Liquid Detergent',         'Home Care', 'Laundry'],
            ['Fabric Softener',          'Home Care', 'Laundry'],
            ['Shoes Cleaner',            'Home Care', 'Shoes Care'],
            ['Shoes Spray',              'Home Care', 'Shoes Care'],
            ['Toilet Cleaner',           'Home Care', 'House Care'],
            ['Drain Cleaner',            'Home Care', 'House Care'],
            ['Multi-Purpose Cleaner',    'Home Care', 'House Care'],
            ['Car Interior Cleaner',     'Home Care', 'House Care'],
            ['Fridge Deodorizer',        'Home Care', 'House Care'],
            ['Pet Area Cleaner',         'Home Care', 'House Care'],
            ['Baby Bottle Wash',         'Home Care', 'Kitchen'],
        ];

        $slugCount = [];
        $rows      = [];

        foreach ($products as $order => [$name, $l1, $l2]) {
            $categoryId = $resolveCategory($l1, $l2);
            $baseSlug   = Str::slug($name);

            // Deduplicate slugs across the whole seeder
            if (isset($slugCount[$baseSlug])) {
                $slugCount[$baseSlug]++;
                $slug = $baseSlug . '-' . $slugCount[$baseSlug];
            } else {
                $slugCount[$baseSlug] = 1;
                $slug = $baseSlug;
            }

            $rows[] = [
                'category_id' => $categoryId,
                'name'        => $name,
                'slug'        => $slug,
                'description' => null,
                'base_price'  => $basePrice,
                'min_qty'     => $minQty,
                'is_active'   => true,
                'sort_order'  => $order + 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        // Chunk inserts for performance
        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('products')->insertOrIgnore($chunk);
        }

        $this->command->info('Products seeded: ' . count($rows));
    }
}
