<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Nonaktifkan pengecekan relasi foreign key
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel produk & kategori lama (agar teks Latin hilang)
        Product::truncate();
        Category::truncate();

        // 3. Buat 3 Kategori Utama
        $p3k = Category::create(['name' => 'P3K']);
        $vitamin = Category::create(['name' => 'Vitamin']);
        $herbal = Category::create(['name' => 'Obat Herbal']);

        // 4. Masukkan Produk Asli Bahasa Indonesia
        Product::create([
            'sku' => 'SKU-1001',
            'name' => 'Plester Hansaplas Steril',
            'category_id' => $p3k->id,
            'price' => 5000,
            'stock' => 50
        ]);

        Product::create([
            'sku' => 'SKU-1002',
            'name' => 'Minyak Kayu Putih Cap Lang 60ml',
            'category_id' => $p3k->id,
            'price' => 22000,
            'stock' => 25
        ]);

        Product::create([
            'sku' => 'SKU-2001',
            'name' => 'Enervon-C Multivitamin 30 Tablet',
            'category_id' => $vitamin->id,
            'price' => 45000,
            'stock' => 30
        ]);

        Product::create([
            'sku' => 'SKU-2002',
            'name' => 'Vitacimin Sweetlets Lemon 1 Strip',
            'category_id' => $vitamin->id,
            'price' => 3500,
            'stock' => 100
        ]);

        Product::create([
            'sku' => 'SKU-3001',
            'name' => 'Madu TJ Murni 150g',
            'category_id' => $herbal->id,
            'price' => 28000,
            'stock' => 15
        ]);

        Product::create([
            'sku' => 'SKU-3002',
            'name' => 'Tolak Angin Cair Herbal 1 Box',
            'category_id' => $herbal->id,
            'price' => 24000,
            'stock' => 40
        ]);

        // 5. Aktifkan kembali pengecekan relasi
        Schema::enableForeignKeyConstraints();
    }
}