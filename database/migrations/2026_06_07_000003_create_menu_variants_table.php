<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->string('nama');
            $table->unsignedInteger('harga_tambahan')->default(0);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['menu_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_variants');
    }
};
