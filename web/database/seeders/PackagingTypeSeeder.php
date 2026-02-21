<?php

namespace Database\Seeders;

use App\Models\PackagingType;
use Illuminate\Database\Seeder;

class PackagingTypeSeeder extends Seeder
{
    public function run(): void
    {
        $packagings = [
            ['name' => 'Botol Pump 30ml', 'type' => 'pump', 'price' => 3500, 'description' => 'Botol kaca/plastik dengan pompa, 30ml', 'sort_order' => 1],
            ['name' => 'Botol Pump 50ml', 'type' => 'pump', 'price' => 4500, 'description' => 'Botol kaca/plastik dengan pompa, 50ml', 'sort_order' => 2],
            ['name' => 'Botol Pump 100ml', 'type' => 'pump', 'price' => 5500, 'description' => 'Botol kaca/plastik dengan pompa, 100ml', 'sort_order' => 3],
            ['name' => 'Tube 50ml', 'type' => 'tube', 'price' => 3000, 'description' => 'Tube plastik flip cap, 50ml', 'sort_order' => 4],
            ['name' => 'Tube 100ml', 'type' => 'tube', 'price' => 3800, 'description' => 'Tube plastik flip cap, 100ml', 'sort_order' => 5],
            ['name' => 'Jar 30g', 'type' => 'jar', 'price' => 2800, 'description' => 'Jar plastik/kaca bulat, 30g', 'sort_order' => 6],
            ['name' => 'Jar 50g', 'type' => 'jar', 'price' => 3200, 'description' => 'Jar plastik/kaca bulat, 50g', 'sort_order' => 7],
            ['name' => 'Jar 100g', 'type' => 'jar', 'price' => 4000, 'description' => 'Jar plastik/kaca bulat, 100g', 'sort_order' => 8],
            ['name' => 'Botol Spray 50ml', 'type' => 'spray', 'price' => 4200, 'description' => 'Botol dengan spray head, 50ml', 'sort_order' => 9],
            ['name' => 'Botol Spray 100ml', 'type' => 'spray', 'price' => 5000, 'description' => 'Botol dengan spray head, 100ml', 'sort_order' => 10],
            ['name' => 'Dropper 15ml', 'type' => 'dropper', 'price' => 5500, 'description' => 'Botol kaca dengan dropper, 15ml', 'sort_order' => 11],
            ['name' => 'Dropper 30ml', 'type' => 'dropper', 'price' => 6500, 'description' => 'Botol kaca dengan dropper, 30ml', 'sort_order' => 12],
            ['name' => 'Sachet 5ml', 'type' => 'sachet', 'price' => 800, 'description' => 'Sachet aluminium foil, 5ml', 'sort_order' => 13],
            ['name' => 'Sachet 10ml', 'type' => 'sachet', 'price' => 1000, 'description' => 'Sachet aluminium foil, 10ml', 'sort_order' => 14],
            ['name' => 'Pouch Refill 100ml', 'type' => 'pouch', 'price' => 2000, 'description' => 'Pouch refill dengan spout, 100ml', 'sort_order' => 15],
        ];

        foreach ($packagings as $data) {
            PackagingType::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['is_active' => true])
            );
        }

        $this->command->info('Packaging types seeded: ' . count($packagings));
    }
}
