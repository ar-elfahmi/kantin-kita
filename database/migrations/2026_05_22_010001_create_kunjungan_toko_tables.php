<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_toko', function (Blueprint $table) {
            $table->string('barcode', 8)->primary();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('nama_toko', 50);
            $table->double('latitude');
            $table->double('longitude');
            $table->double('accuracy');
            $table->timestamps();

            $table->index('vendor_id');
        });

        Schema::create('kunjungan_toko', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('lokasi_toko_barcode', 8);
            $table->double('sales_latitude');
            $table->double('sales_longitude');
            $table->double('sales_accuracy');
            $table->double('jarak_meter');
            $table->double('threshold_efektif');
            $table->enum('status', ['accepted', 'rejected']);
            $table->timestamps();

            $table->index('vendor_id');
            $table->index('lokasi_toko_barcode');
            $table->foreign('lokasi_toko_barcode')
                ->references('barcode')->on('lokasi_toko')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_toko');
        Schema::dropIfExists('lokasi_toko');
    }
};
