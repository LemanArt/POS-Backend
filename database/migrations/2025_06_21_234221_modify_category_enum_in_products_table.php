<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah semua 'snack' jadi 'others' dulu agar tidak error saat alter enum
        DB::table('products')->where('category', 'snack')->update(['category' => 'others']);

        // Ubah struktur enum-nya
        DB::statement("ALTER TABLE products MODIFY category ENUM('food', 'drink', 'others') NOT NULL");
    }

    public function down(): void
    {
        // Ubah kembali 'others' jadi 'snack'
        DB::table('products')->where('category', 'others')->update(['category' => 'snack']);

        // Ubah enum kembali ke semula
        DB::statement("ALTER TABLE products MODIFY category ENUM('food', 'drink', 'snack') NOT NULL");
    }
};
