<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materials')->truncate();

        $now = now();

        // ------------------------------------------------------------------
        // Data: [name, category, price_per_ml]
        // ------------------------------------------------------------------

        // EXTRACT (27)
        $extracts = [
            ['Aloe Vera Extract',            'Extract',  280],
            ['Green Tea Extract',            'Extract',  420],
            ['Chamomile Extract',            'Extract',  380],
            ['Rosehip Extract',              'Extract',  650],
            ['Centella Asiatica Extract',    'Extract',  520],
            ['Licorice Root Extract',        'Extract',  480],
            ['Hyaluronic Acid Extract',      'Extract',  890],
            ['Niacinamide Extract',          'Extract',  350],
            ['Vitamin C Extract',            'Extract',  620],
            ['Retinol Extract',              'Extract', 1200],
            ['Kojic Acid Extract',           'Extract',  580],
            ['Alpha Arbutin Extract',        'Extract',  760],
            ['Mugwort Extract',              'Extract',  430],
            ['Snail Secretion Extract',      'Extract',  950],
            ['Propolis Extract',             'Extract',  720],
            ['Ceramide Extract',             'Extract', 1402],
            ['Peptide Extract',              'Extract', 1850],
            ['Collagen Extract',             'Extract',  980],
            ['Turmeric Extract',             'Extract',  290],
            ['Ginseng Extract',              'Extract',  880],
            ['Bakuchiol Extract',            'Extract', 1100],
            ['Tranexamic Acid',              'Extract',  680],
            ['Azelaic Acid',                 'Extract',  540],
            ['Salicylic Acid Extract',       'Extract',  460],
            ['Lactic Acid Extract',          'Extract',  320],
            ['Glycolic Acid Extract',        'Extract',  390],
            ['Mandelic Acid Extract',        'Extract',  420],
        ];

        // OIL (23)
        $oils = [
            ['Argan Oil',                    'Oil',  850],
            ['Jojoba Oil',                   'Oil',  420],
            ['Rosehip Oil',                  'Oil',  680],
            ['Marula Oil',                   'Oil',  920],
            ['Tea Tree Oil',                 'Oil',  380],
            ['Lavender Oil',                 'Oil',  320],
            ['Vitamin E Oil',                'Oil',  280],
            ['Sea Buckthorn Oil',            'Oil',  750],
            ['Black Seed Oil (Habbatus Sauda)', 'Oil', 490],
            ['Sweet Almond Oil',             'Oil',  240],
            ['Castor Oil',                   'Oil',  180],
            ['Coconut Fractionated Oil',     'Oil',  160],
            ['Hemp Seed Oil',                'Oil',  620],
            ['Squalane Oil',                 'Oil',  780],
            ['Emu Oil',                      'Oil', 1100],
            ['Macadamia Oil',                'Oil',  560],
            ['Pomegranate Seed Oil',         'Oil',  890],
            ['Bakuchiol Oil',                'Oil',  970],
            ['Camellia Oil',                 'Oil',  480],
            ['Avocado Oil',                  'Oil',  290],
            ['Grapeseed Oil',                'Oil',  210],
            ['Tamanu Oil',                   'Oil',  650],
            ['Prickly Pear Seed Oil',        'Oil', 1350],
        ];

        // ACTIVE (35)
        $actives = [
            ['Niacinamide',                  'Active',  350],
            ['Vitamin C (L-Ascorbic)',        'Active',  580],
            ['Retinol 0.1%',                 'Active',  980],
            ['Retinol 0.3%',                 'Active', 1450],
            ['Hyaluronic Acid',              'Active',  760],
            ['Ceramide NP',                  'Active', 1402],
            ['Peptide (Matrixyl)',            'Active', 1750],
            ['Collagen',                     'Active',  890],
            ['Alpha Arbutin',                'Active',  720],
            ['Kojic Acid',                   'Active',  540],
            ['Azelaic Acid',                 'Active',  480],
            ['Salicylic Acid',               'Active',  420],
            ['Lactic Acid',                  'Active',  310],
            ['Glycolic Acid',                'Active',  350],
            ['Mandelic Acid',                'Active',  390],
            ['Tranexamic Acid',              'Active',  650],
            ['Glutathione',                  'Active', 1100],
            ['Centella Asiatica',            'Active',  460],
            ['Bakuchiol',                    'Active', 1050],
            ['EGF (Epidermal Growth Factor)', 'Active', 2800],
            ['Stem Cell',                    'Active', 3200],
            ['Exosome',                      'Active', 4500],
            ['Coenzyme Q10',                 'Active', 1200],
            ['Resveratrol',                  'Active', 1600],
            ['Ferulic Acid',                 'Active',  680],
            ['Phytosphingosine',             'Active',  890],
            ['Beta-Glucan',                  'Active',  560],
            ['Allantoin',                    'Active',  290],
            ['Panthenol (B5)',               'Active',  240],
            ['Zinc',                         'Active',  180],
            ['Copper Peptide',               'Active', 2100],
            ['Adenosine',                    'Active',  580],
            ['Argireline',                   'Active', 1850],
            ['Leuphasyl',                    'Active', 1650],
            ['DMAE',                         'Active',  780],
        ];

        // PARFUM (57)
        $parfums = [
            ['Rose',              'Parfum',  380],
            ['Jasmine',           'Parfum',  420],
            ['Lavender',          'Parfum',  290],
            ['Vanilla',           'Parfum',  350],
            ['Sandalwood',        'Parfum',  680],
            ['Oud',               'Parfum', 1200],
            ['Bergamot',          'Parfum',  450],
            ['Ylang Ylang',       'Parfum',  520],
            ['Patchouli',         'Parfum',  380],
            ['Vetiver',           'Parfum',  490],
            ['Cedarwood',         'Parfum',  340],
            ['Musk White',        'Parfum',  580],
            ['Musk Black',        'Parfum',  620],
            ['Amber',             'Parfum',  560],
            ['Frankincense',      'Parfum',  750],
            ['Myrrh',             'Parfum',  680],
            ['Neroli',            'Parfum',  890],
            ['Geranium',          'Parfum',  360],
            ['Eucalyptus',        'Parfum',  280],
            ['Peppermint',        'Parfum',  310],
            ['Lemon',             'Parfum',  260],
            ['Orange',            'Parfum',  240],
            ['Grapefruit',        'Parfum',  270],
            ['Lime',              'Parfum',  250],
            ['Mandarin',          'Parfum',  280],
            ['Peach',             'Parfum',  390],
            ['Cherry',            'Parfum',  370],
            ['Strawberry',        'Parfum',  350],
            ['Apple',             'Parfum',  320],
            ['Pear',              'Parfum',  340],
            ['Coconut',           'Parfum',  290],
            ['Tropical',          'Parfum',  310],
            ['Fresh Marine',      'Parfum',  380],
            ['Cotton',            'Parfum',  420],
            ['Baby Powder Scent', 'Parfum',  360],
            ['Floral Bouquet',    'Parfum',  480],
            ['Green Tea Scent',   'Parfum',  390],
            ['Sakura',            'Parfum',  520],
            ['Magnolia',          'Parfum',  490],
            ['Lily',              'Parfum',  460],
            ['Tuberose',          'Parfum',  550],
            ['Gardenia',          'Parfum',  470],
            ['Freesia',           'Parfum',  410],
            ['Iris',              'Parfum',  530],
            ['Violet',            'Parfum',  440],
            ['Aquatic Fresh',     'Parfum',  360],
            ['Woody Cedar',       'Parfum',  480],
            ['Spicy Oriental',    'Parfum',  590],
            ['Sweet Gourmand',    'Parfum',  420],
            ['Citrus Fresh',      'Parfum',  280],
            ['Mint Cool',         'Parfum',  310],
            ['Herbal Green',      'Parfum',  350],
            ['Powdery Soft',      'Parfum',  390],
            ['Smoke Leather',     'Parfum',  680],
            ['Coffee Mocha',      'Parfum',  440],
            ['Sea Breeze',        'Parfum',  320],
            ['Incense Sacred',    'Parfum',  590],
        ];

        $all = array_merge($extracts, $oils, $actives, $parfums);

        $rows = [];
        foreach ($all as $order => [$name, $category, $price]) {
            $rows[] = [
                'name'         => $name,
                'category'     => $category,
                'price_per_ml' => $price,
                'description'  => null,
                'is_available' => true,
                'sort_order'   => $order + 1,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('materials')->insertOrIgnore($chunk);
        }

        $this->command->info('Materials seeded: ' . count($rows));
    }
}
