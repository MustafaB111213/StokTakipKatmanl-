<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();

        $products = [
            ['name' => 'Laptop Pro 15',       'sku' => 'ELK-001'],
            ['name' => 'Kablosuz Mouse',       'sku' => 'ELK-002'],
            ['name' => 'Mekanik Klavye',       'sku' => 'ELK-003'],
            ['name' => 'USB-C Hub',            'sku' => 'ELK-004'],
            ['name' => 'Monitör 27"',          'sku' => 'ELK-005'],
            ['name' => 'Erkek T-Shirt L',      'sku' => 'GIY-001'],
            ['name' => 'Kadın Elbise M',       'sku' => 'GIY-002'],
            ['name' => 'Spor Ayakkabı 42',     'sku' => 'GIY-003'],
            ['name' => 'Kaban Siyah XL',       'sku' => 'GIY-004'],
            ['name' => 'Kot Pantolon 32',      'sku' => 'GIY-005'],
            ['name' => 'Zeytinyağı 5L',        'sku' => 'GDA-001'],
            ['name' => 'Makarna 500g',         'sku' => 'GDA-002'],
            ['name' => 'Domates Salçası 700g', 'sku' => 'GDA-003'],
            ['name' => 'Pirinç 2.5kg',         'sku' => 'GDA-004'],
            ['name' => 'Çay 500g',             'sku' => 'GDA-005'],
            ['name' => 'A4 Kağıt 500 Yaprak',  'sku' => 'KRT-001'],
            ['name' => 'Tükenmez Kalem Seti',  'sku' => 'KRT-002'],
            ['name' => 'Defter A5',            'sku' => 'KRT-003'],
            ['name' => 'Yapışkanlı Not Kağıdı','sku' => 'KRT-004'],
            ['name' => 'Dosya Karton',         'sku' => 'KRT-005'],
        ];

        $categoryMap = [
            'ELK' => 1,
            'GIY' => 2,
            'GDA' => 3,
            'KRT' => 4,
        ];

        $allCategories = Category::orderBy('id')->pluck('id')->toArray();

        foreach ($products as $i => $data) {
            $prefix = substr($data['sku'], 0, 3);
            $catIndex = $categoryMap[$prefix] - 1;
            $categoryId = $allCategories[$catIndex] ?? $allCategories[0];

            Product::create([
                'category_id'   => $categoryId,
                'name'          => $data['name'],
                'sku'           => $data['sku'],
                'current_stock' => 0,
            ]);
        }
    }
}
