<?php

namespace Database\Seeders;

use App\Models\PackagingType;
use Illuminate\Database\Seeder;

class PackagingSeeder extends Seeder
{
    public function run(): void
    {
        $packagingTypes = [
            [
                'name' => 'Botol Pump',
                'description' => 'Botol dengan pompa dispenser, cocok untuk serum, lotion, dan sabun',
                'options' => [
                    ['name' => 'Botol Pump 30ml - Clear', 'volume_ml' => 30, 'price' => 3500],
                    ['name' => 'Botol Pump 50ml - Clear', 'volume_ml' => 50, 'price' => 4200],
                    ['name' => 'Botol Pump 100ml - Clear', 'volume_ml' => 100, 'price' => 5500],
                    ['name' => 'Botol Pump 150ml - Frosted', 'volume_ml' => 150, 'price' => 6800],
                    ['name' => 'Botol Pump 200ml - Frosted', 'volume_ml' => 200, 'price' => 7500],
                ],
            ],
            [
                'name' => 'Botol Fliptop',
                'description' => 'Botol dengan tutup flip, cocok untuk toner, body wash, shampoo',
                'options' => [
                    ['name' => 'Botol Fliptop 100ml', 'volume_ml' => 100, 'price' => 3200],
                    ['name' => 'Botol Fliptop 200ml', 'volume_ml' => 200, 'price' => 4500],
                    ['name' => 'Botol Fliptop 500ml', 'volume_ml' => 500, 'price' => 6000],
                ],
            ],
            [
                'name' => 'Spray Normal',
                'description' => 'Botol spray standar untuk toner, setting spray',
                'options' => [
                    ['name' => 'Spray Normal 50ml', 'volume_ml' => 50, 'price' => 4000],
                    ['name' => 'Spray Normal 100ml', 'volume_ml' => 100, 'price' => 5200],
                    ['name' => 'Spray Normal 150ml', 'volume_ml' => 150, 'price' => 6100],
                ],
            ],
            [
                'name' => 'Spray Mist',
                'description' => 'Botol spray mist ultra-fine untuk face mist',
                'options' => [
                    ['name' => 'Spray Mist 50ml - Glass', 'volume_ml' => 50, 'price' => 6500],
                    ['name' => 'Spray Mist 100ml - Glass', 'volume_ml' => 100, 'price' => 8200],
                    ['name' => 'Spray Mist 100ml - Plastic', 'volume_ml' => 100, 'price' => 5500],
                ],
            ],
            [
                'name' => 'Spray Trigger',
                'description' => 'Botol spray trigger untuk home care dan pembersih',
                'options' => [
                    ['name' => 'Spray Trigger 500ml', 'volume_ml' => 500, 'price' => 5500],
                    ['name' => 'Spray Trigger 750ml', 'volume_ml' => 750, 'price' => 6800],
                    ['name' => 'Spray Trigger 1000ml', 'volume_ml' => 1000, 'price' => 8500],
                ],
            ],
            [
                'name' => 'Jar',
                'description' => 'Wadah jar untuk cream, butter, scrub, mask',
                'options' => [
                    ['name' => 'Jar 15ml - Clear', 'volume_ml' => 15, 'price' => 2800],
                    ['name' => 'Jar 30ml - Clear', 'volume_ml' => 30, 'price' => 3500],
                    ['name' => 'Jar 50ml - White', 'volume_ml' => 50, 'price' => 4200],
                    ['name' => 'Jar 100ml - White', 'volume_ml' => 100, 'price' => 5500],
                    ['name' => 'Jar 200ml - Frosted', 'volume_ml' => 200, 'price' => 7000],
                ],
            ],
            [
                'name' => 'Case Cushion',
                'description' => 'Case cushion untuk makeup cushion foundation',
                'options' => [
                    ['name' => 'Case Cushion Standard 15g', 'volume_ml' => 15, 'price' => 18000],
                    ['name' => 'Case Cushion Premium 15g', 'volume_ml' => 15, 'price' => 25000],
                    ['name' => 'Case Cushion dengan Refill 15g', 'volume_ml' => 15, 'price' => 15000],
                ],
            ],
            [
                'name' => 'Botol Roll On',
                'description' => 'Botol roll on untuk deodorant, parfum, essential oil',
                'options' => [
                    ['name' => 'Roll On 10ml - Glass', 'volume_ml' => 10, 'price' => 3500],
                    ['name' => 'Roll On 10ml - Plastic', 'volume_ml' => 10, 'price' => 2500],
                    ['name' => 'Roll On 50ml', 'volume_ml' => 50, 'price' => 5200],
                ],
            ],
            [
                'name' => 'Lipstick / Lip Balm',
                'description' => 'Case untuk lipstick, lipbalm, lip color',
                'options' => [
                    ['name' => 'Lipstick Case Standard', 'volume_ml' => null, 'price' => 8500],
                    ['name' => 'Lip Balm Tube Round', 'volume_ml' => null, 'price' => 3500],
                    ['name' => 'Lip Balm Stick Oval', 'volume_ml' => null, 'price' => 4200],
                ],
            ],
            [
                'name' => 'Liptint',
                'description' => 'Kemasan liptint dengan applicator',
                'options' => [
                    ['name' => 'Liptint 8ml dengan Doe Foot', 'volume_ml' => 8, 'price' => 5500],
                    ['name' => 'Liptint 10ml dengan Brush', 'volume_ml' => 10, 'price' => 6200],
                ],
            ],
        ];

        foreach ($packagingTypes as $sort => $type) {
            $packagingType = PackagingType::create([
                'name' => $type['name'],
                'description' => $type['description'],
                'is_active' => true,
                'sort_order' => $sort,
            ]);

            foreach ($type['options'] as $optSort => $option) {
                $packagingType->options()->create([
                    'name' => $option['name'],
                    'volume_ml' => $option['volume_ml'],
                    'price' => $option['price'],
                    'is_active' => true,
                    'sort_order' => $optSort,
                ]);
            }
        }
    }
}
