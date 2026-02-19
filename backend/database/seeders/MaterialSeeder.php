<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            // Extract (27)
            ['name' => 'Albae Extract', 'category' => 'Extract', 'price_per_ml' => 520, 'description' => 'Extract dari rumput laut, kaya antioksidan'],
            ['name' => 'Aloe Vera Extract', 'category' => 'Extract', 'price_per_ml' => 160.95, 'description' => 'Gel lidah buaya, menenangkan & melembabkan kulit sensitif'],
            ['name' => 'Arrowroot', 'category' => 'Extract', 'price_per_ml' => 52, 'description' => 'Bubuk tanaman untuk tekstur halus dan matte'],
            ['name' => 'Gingseng Extract', 'category' => 'Extract', 'price_per_ml' => 444, 'description' => 'Extract ginseng untuk revitalisasi kulit'],
            ['name' => 'Goat Milk Extract', 'category' => 'Extract', 'price_per_ml' => 410, 'description' => 'Extract susu kambing untuk kulit lembut'],
            ['name' => 'Honey Extract', 'category' => 'Extract', 'price_per_ml' => 377.4, 'description' => 'Extract madu untuk moisturizer alami'],
            ['name' => 'Hydrolyzed Soy', 'category' => 'Extract', 'price_per_ml' => 1075, 'description' => 'Protein kedelai untuk firming'],
            ['name' => 'Licorice Extract', 'category' => 'Extract', 'price_per_ml' => 271.95, 'description' => 'Extract licorice untuk brightening alami'],
            ['name' => 'Spirulina Powder', 'category' => 'Extract', 'price_per_ml' => 146.3, 'description' => 'Bubuk spirulina antioksidan tinggi'],
            ['name' => 'Gotukola Extract', 'category' => 'Extract', 'price_per_ml' => 455.1, 'description' => 'Pegagan untuk wound healing & firming'],
            ['name' => 'Moringa Extract', 'category' => 'Extract', 'price_per_ml' => 440, 'description' => 'Extract kelor antioksidan super'],
            ['name' => 'Grapeseed Extract', 'category' => 'Extract', 'price_per_ml' => 670, 'description' => 'Extract biji anggur anti-aging'],
            ['name' => 'Green Tea Extract', 'category' => 'Extract', 'price_per_ml' => 385, 'description' => 'Extract teh hijau antioksidan kuat'],
            ['name' => 'Centella Asiatica Extract', 'category' => 'Extract', 'price_per_ml' => 520, 'description' => 'Cica extract untuk healing dan soothing'],
            ['name' => 'Niacinamide', 'category' => 'Extract', 'price_per_ml' => 280, 'description' => 'Vitamin B3 untuk brightening dan pore minimizer'],
            ['name' => 'Rice Extract', 'category' => 'Extract', 'price_per_ml' => 195, 'description' => 'Extract beras untuk brightening alami'],
            ['name' => 'Snail Mucin Extract', 'category' => 'Extract', 'price_per_ml' => 890, 'description' => 'Mucin siput untuk hidrasi intens'],
            ['name' => 'Turmeric Extract', 'category' => 'Extract', 'price_per_ml' => 310, 'description' => 'Extract kunyit anti-inflamasi'],
            ['name' => 'Coffee Extract', 'category' => 'Extract', 'price_per_ml' => 265, 'description' => 'Extract kopi untuk energize dan anti-cellulite'],
            ['name' => 'Papaya Extract', 'category' => 'Extract', 'price_per_ml' => 230, 'description' => 'Extract pepaya mengandung papain untuk exfoliasi'],
            ['name' => 'Sea Buckthorn Extract', 'category' => 'Extract', 'price_per_ml' => 980, 'description' => 'Extract sea buckthorn kaya vitamin C'],
            ['name' => 'Pomegranate Extract', 'category' => 'Extract', 'price_per_ml' => 720, 'description' => 'Extract delima untuk anti-aging'],
            ['name' => 'Chamomile Extract', 'category' => 'Extract', 'price_per_ml' => 415, 'description' => 'Extract chamomile menenangkan kulit sensitif'],
            ['name' => 'Rose Extract', 'category' => 'Extract', 'price_per_ml' => 560, 'description' => 'Extract mawar untuk hidrasi dan aroma'],
            ['name' => 'Mulberry Extract', 'category' => 'Extract', 'price_per_ml' => 495, 'description' => 'Extract murbei untuk brightening'],
            ['name' => 'Propolis Extract', 'category' => 'Extract', 'price_per_ml' => 830, 'description' => 'Extract propolis antibakteri alami'],
            ['name' => 'Cucumber Extract', 'category' => 'Extract', 'price_per_ml' => 175, 'description' => 'Extract mentimun menyegarkan dan menenangkan'],

            // Oil (23)
            ['name' => 'Almond Oil', 'category' => 'Oil', 'price_per_ml' => 210, 'description' => 'Minyak almond untuk melembabkan dan melembutkan kulit'],
            ['name' => 'Anise Oil', 'category' => 'Oil', 'price_per_ml' => 830.64, 'description' => 'Minyak adas untuk aromaterapi'],
            ['name' => 'Cajuput Oil', 'category' => 'Oil', 'price_per_ml' => 230, 'description' => 'Minyak kayu putih antiseptik'],
            ['name' => 'Coconut Oil', 'category' => 'Oil', 'price_per_ml' => 57.72, 'description' => 'Minyak kelapa murni, melembabkan rambut & kulit'],
            ['name' => 'Castor Oil', 'category' => 'Oil', 'price_per_ml' => 59.1, 'description' => 'Minyak jarak untuk rambut dan alis'],
            ['name' => 'Eucalyptus Essential Oil', 'category' => 'Oil', 'price_per_ml' => 610, 'description' => 'Minyak esensial untuk pernapasan'],
            ['name' => 'Grapefruit Essential Oil', 'category' => 'Oil', 'price_per_ml' => 1441.24, 'description' => 'Minyak esensial citrus segar'],
            ['name' => 'Habbatusauda Oil', 'category' => 'Oil', 'price_per_ml' => 262.6, 'description' => 'Minyak jintan hitam untuk kesehatan kulit'],
            ['name' => 'Lavender Essential Oil', 'category' => 'Oil', 'price_per_ml' => 1140, 'description' => 'Minyak lavender menenangkan dan aromaterapi'],
            ['name' => 'Lemon Essential Oil', 'category' => 'Oil', 'price_per_ml' => 1335, 'description' => 'Minyak lemon untuk brightening'],
            ['name' => 'Lemongrass Essential Oil', 'category' => 'Oil', 'price_per_ml' => 380, 'description' => 'Minyak sereh untuk aromaterapi fresh'],
            ['name' => 'Neem Oil', 'category' => 'Oil', 'price_per_ml' => 240, 'description' => 'Minyak nimba anti-bacterial'],
            ['name' => 'Olive Oil', 'category' => 'Oil', 'price_per_ml' => 100, 'description' => 'Minyak zaitun extra virgin untuk nutrisi'],
            ['name' => 'Peppermint Oil', 'category' => 'Oil', 'price_per_ml' => 456.73, 'description' => 'Minyak peppermint cooling effect'],
            ['name' => 'Rosemary Essential Oil', 'category' => 'Oil', 'price_per_ml' => 1520, 'description' => 'Minyak rosemary untuk rambut rontok'],
            ['name' => 'Tamanu Oil', 'category' => 'Oil', 'price_per_ml' => 943.5, 'description' => 'Minyak tamanu untuk scar dan healing'],
            ['name' => 'Tea Tree Oil', 'category' => 'Oil', 'price_per_ml' => 1276.5, 'description' => 'Minyak pohon teh anti-bacterial untuk acne'],
            ['name' => 'Argan Oil', 'category' => 'Oil', 'price_per_ml' => 850, 'description' => 'Minyak argan untuk rambut dan kulit berkilau'],
            ['name' => 'Jojoba Oil', 'category' => 'Oil', 'price_per_ml' => 320, 'description' => 'Minyak jojoba sebagai moisturizer non-greasy'],
            ['name' => 'Rosehip Oil', 'category' => 'Oil', 'price_per_ml' => 760, 'description' => 'Minyak rosehip untuk anti-aging dan scar'],
            ['name' => 'Marula Oil', 'category' => 'Oil', 'price_per_ml' => 1150, 'description' => 'Minyak marula mewah untuk nutrisi kulit'],
            ['name' => 'Sweet Almond Oil', 'category' => 'Oil', 'price_per_ml' => 185, 'description' => 'Minyak almond manis untuk baby products'],
            ['name' => 'Sunflower Oil', 'category' => 'Oil', 'price_per_ml' => 75, 'description' => 'Minyak bunga matahari ringan untuk kulit'],

            // Active (35)
            ['name' => 'Biotin', 'category' => 'Active', 'price_per_ml' => 15689.95, 'description' => 'Vitamin B7 untuk pertumbuhan rambut dan kuku'],
            ['name' => 'Calamine Bubuk', 'category' => 'Active', 'price_per_ml' => 122.88, 'description' => 'Bubuk mineral untuk menenangkan iritasi kulit'],
            ['name' => 'Ceramide', 'category' => 'Active', 'price_per_ml' => 1402.68, 'description' => 'Lipid barrier untuk skin hydration & anti-aging'],
            ['name' => 'Enzyme Protease', 'category' => 'Active', 'price_per_ml' => 1000, 'description' => 'Enzim untuk exfoliasi lembut'],
            ['name' => 'Ethylhexy Methoxy', 'category' => 'Active', 'price_per_ml' => 325, 'description' => 'UV filter untuk sunscreen'],
            ['name' => 'Fish Collagen', 'category' => 'Active', 'price_per_ml' => 430, 'description' => 'Kolagen ikan untuk elastisitas kulit'],
            ['name' => 'Glycolic Acid', 'category' => 'Active', 'price_per_ml' => 156.1, 'description' => 'AHA untuk exfoliasi dan brightening'],
            ['name' => 'Kojic Acid', 'category' => 'Active', 'price_per_ml' => 454.4, 'description' => 'Whitening agent untuk flek hitam'],
            ['name' => 'Kojic Acid Dipalmitate', 'category' => 'Active', 'price_per_ml' => 1300, 'description' => 'Bentuk stable kojic acid untuk brightening'],
            ['name' => 'Lactic Acid', 'category' => 'Active', 'price_per_ml' => 62.3, 'description' => 'AHA gentle untuk exfoliasi kulit sensitif'],
            ['name' => 'OAT COM', 'category' => 'Active', 'price_per_ml' => 933.23, 'description' => 'Oat complex untuk soothing kulit'],
            ['name' => 'Panthenol', 'category' => 'Active', 'price_per_ml' => 313, 'description' => 'Pro-vitamin B5 untuk hidrasi dan healing'],
            ['name' => 'Salicylic Acid', 'category' => 'Active', 'price_per_ml' => 355.4, 'description' => 'BHA untuk acne dan exfoliasi pori'],
            ['name' => 'Vitamin E', 'category' => 'Active', 'price_per_ml' => 900, 'description' => 'Tocopherol antioksidan untuk anti-aging'],
            ['name' => 'Zinc Oxide', 'category' => 'Active', 'price_per_ml' => 337.79, 'description' => 'Mineral sunscreen SPF booster'],
            ['name' => 'Allantoin', 'category' => 'Active', 'price_per_ml' => 190, 'description' => 'Soothing agent untuk kulit sensitif'],
            ['name' => 'Hyaluronic Acid', 'category' => 'Active', 'price_per_ml' => 1250, 'description' => 'Asam hialuronat untuk hidrasi intensif'],
            ['name' => 'Retinol', 'category' => 'Active', 'price_per_ml' => 2100, 'description' => 'Vitamin A untuk anti-aging dan sel turnover'],
            ['name' => 'Vitamin C (Ascorbic Acid)', 'category' => 'Active', 'price_per_ml' => 480, 'description' => 'Antioksidan brightening dan kolagen booster'],
            ['name' => 'AHA BHA Complex', 'category' => 'Active', 'price_per_ml' => 890, 'description' => 'Kombinasi acid untuk exfoliasi optimal'],
            ['name' => 'Alpha Arbutin', 'category' => 'Active', 'price_per_ml' => 1680, 'description' => 'Whitening aman untuk kulit sensitif'],
            ['name' => 'Tranexamic Acid', 'category' => 'Active', 'price_per_ml' => 1450, 'description' => 'Brightening agent untuk pigmentasi'],
            ['name' => 'Azelaic Acid', 'category' => 'Active', 'price_per_ml' => 620, 'description' => 'Anti-acne dan anti-inflamasi'],
            ['name' => 'Mandelic Acid', 'category' => 'Active', 'price_per_ml' => 780, 'description' => 'AHA gentle dari almond bitter'],
            ['name' => 'Niacinamide 10%', 'category' => 'Active', 'price_per_ml' => 350, 'description' => 'Vitamin B3 dosis tinggi untuk pori dan brightening'],
            ['name' => 'Peptide Complex', 'category' => 'Active', 'price_per_ml' => 2500, 'description' => 'Peptida untuk firming dan anti-wrinkle'],
            ['name' => 'EGF (Epidermal Growth Factor)', 'category' => 'Active', 'price_per_ml' => 3200, 'description' => 'Growth factor untuk regenerasi sel kulit'],
            ['name' => 'Stem Cell Extract', 'category' => 'Active', 'price_per_ml' => 4500, 'description' => 'Stem cell untuk anti-aging premium'],
            ['name' => 'Adenosine', 'category' => 'Active', 'price_per_ml' => 980, 'description' => 'Anti-wrinkle ingredient KFDA approved'],
            ['name' => 'Bakuchiol', 'category' => 'Active', 'price_per_ml' => 1890, 'description' => 'Retinol alternatif alami dari tanaman'],
            ['name' => 'Ferulic Acid', 'category' => 'Active', 'price_per_ml' => 720, 'description' => 'Antioksidan yang memperkuat vitamin C & E'],
            ['name' => 'Resveratrol', 'category' => 'Active', 'price_per_ml' => 2200, 'description' => 'Antioksidan kuat dari anggur merah'],
            ['name' => 'Glutathione', 'category' => 'Active', 'price_per_ml' => 3800, 'description' => 'Master antioksidan untuk brightening sistemik'],
            ['name' => 'Collagen Tripeptide', 'category' => 'Active', 'price_per_ml' => 2700, 'description' => 'Kolagen tripeptida bioavailabilitas tinggi'],
            ['name' => 'Squalane', 'category' => 'Active', 'price_per_ml' => 580, 'description' => 'Pelembab ringan dari zaitun atau tebu'],

            // Perfume (sample - 57 total, showing 15 here)
            ['name' => 'Floral Bouquet', 'category' => 'Perfume', 'price_per_ml' => 450, 'description' => 'Aroma bunga segar campuran mawar dan melati'],
            ['name' => 'Citrus Fresh', 'category' => 'Perfume', 'price_per_ml' => 380, 'description' => 'Aroma citrus segar jeruk dan lemon'],
            ['name' => 'Woody Masculine', 'category' => 'Perfume', 'price_per_ml' => 520, 'description' => 'Aroma kayu maskulin cedar dan sandalwood'],
            ['name' => 'Oriental Musk', 'category' => 'Perfume', 'price_per_ml' => 680, 'description' => 'Aroma oriental musk hangat dan sensual'],
            ['name' => 'Aqua Marine', 'category' => 'Perfume', 'price_per_ml' => 420, 'description' => 'Aroma segar seperti hembusan angin laut'],
            ['name' => 'Sweet Vanilla', 'category' => 'Perfume', 'price_per_ml' => 390, 'description' => 'Aroma manis vanilla lembut'],
            ['name' => 'Oud Premium', 'category' => 'Perfume', 'price_per_ml' => 1250, 'description' => 'Aroma oud Arab mewah dan tahan lama'],
            ['name' => 'Rose Oud', 'category' => 'Perfume', 'price_per_ml' => 950, 'description' => 'Kombinasi mawar dan oud yang memesona'],
            ['name' => 'Green Forest', 'category' => 'Perfume', 'price_per_ml' => 410, 'description' => 'Aroma segar dedaunan dan hutan pinus'],
            ['name' => 'Baby Powder', 'category' => 'Perfume', 'price_per_ml' => 320, 'description' => 'Aroma bedak bayi lembut dan nyaman'],
            ['name' => 'Lavender Dream', 'category' => 'Perfume', 'price_per_ml' => 480, 'description' => 'Aroma lavender menenangkan untuk relaksasi'],
            ['name' => 'Jasmine Night', 'category' => 'Perfume', 'price_per_ml' => 540, 'description' => 'Aroma melati malam yang harum'],
            ['name' => 'Sport Active', 'category' => 'Perfume', 'price_per_ml' => 360, 'description' => 'Aroma segar sporty untuk pria aktif'],
            ['name' => 'Tropical Paradise', 'category' => 'Perfume', 'price_per_ml' => 430, 'description' => 'Aroma buah tropis yang ceria'],
            ['name' => 'Amber Spice', 'category' => 'Perfume', 'price_per_ml' => 610, 'description' => 'Aroma amber hangat dengan sentuhan rempah'],
        ];

        foreach ($materials as $material) {
            Material::create([
                'name' => $material['name'],
                'category' => $material['category'],
                'price_per_ml' => $material['price_per_ml'],
                'description' => $material['description'],
                'is_available' => true,
            ]);
        }
    }
}
