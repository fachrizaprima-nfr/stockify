<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Pengguna untuk Tiap Role
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@stockify.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manajer Gudang',
            'email' => 'manajer@stockify.test',
            'password' => Hash::make('password'),
            'role' => 'manajer_gudang',
        ]);

        User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@stockify.test',
            'password' => Hash::make('password'),
            'role' => 'staff_gudang',
        ]);

        // 2. Buat Contoh Kategori Barang
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Peralatan dan suku cadang elektronik',
        ]);

        Category::create([
            'name' => 'Pakaian',
            'description' => 'Produk tekstil dan pakaian jadi',
        ]);

        // 3. Buat Contoh Data Supplier
        Supplier::create([
            'name' => 'PT Sumber Makmur',
            'address' => 'Jl. Industri No. 12, Jakarta',
            'phone' => '081234567890',
            'email' => 'contact@sumbermakmur.com',
        ]);
    }
}