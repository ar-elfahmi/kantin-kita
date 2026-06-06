<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menus')->whereNull('id_barang')->lazyById()->each(function ($menu) {
            do {
                $idBarang = strtoupper(Str::random(8));
            } while (DB::table('menus')->where('id_barang', $idBarang)->exists());

            DB::table('menus')->where('id', $menu->id)->update(['id_barang' => $idBarang]);
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->string('id_barang', 20)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('id_barang', 20)->nullable()->change();
        });
    }
};
