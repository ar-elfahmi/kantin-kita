<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->text('alamat');
            $table->string('provinsi', 100);
            $table->string('kota', 100);
            $table->string('kecamatan', 100);
            $table->string('kelurahan', 100);
            $table->string('kodepos', 10);
            $table->binary('foto_blob')->nullable();
            $table->string('foto_path')->nullable();
            $table->timestamps();

            $table->index('vendor_id');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE customers MODIFY foto_blob LONGBLOB NULL');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
