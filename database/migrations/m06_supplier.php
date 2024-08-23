<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id('id_supplier');
            $table->string('nama', 50);
            $table->string('alamat', 50);
            $table->string('no_telp', 50);
            $table->timestamps();
            
            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

        DB::table('supplier')->insert([
            [
                'id_supplier' => 1,
                'nama' => 'PT. Kecantikan Sejati',
                'alamat' => 'Jl. Melati No. 10, Jakarta',
                'no_telp' => '081234567890',
                'id_perusahaan' => 2,
            ],
            [
                'id_supplier' => 2,
                'nama' => 'CV. Produk Cantik',
                'alamat' => 'Jl. Mawar No. 15, Bandung',
                'no_telp' => '081234567891',
                'id_perusahaan' => 2,
            ],
            [
                'id_supplier' => 3,
                'nama' => 'PT. Wajah Indah',
                'alamat' => 'Jl. Kenanga No. 22, Surabaya',
                'no_telp' => '081234567892',
                'id_perusahaan' => 2,
            ],
            [
                'id_supplier' => 4,
                'nama' => 'UD. Salon Terbaik',
                'alamat' => 'Jl. Tulip No. 8, Yogyakarta',
                'no_telp' => '081234567893',
                'id_perusahaan' => 2,
            ],
            [
                'id_supplier' => 5,
                'nama' => 'CV. Cantik Berseri',
                'alamat' => 'Jl. Anggrek No. 3, Bali',
                'no_telp' => '081234567894',
                'id_perusahaan' => 2,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
