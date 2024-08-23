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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama', 50);
            $table->string('detail', 255);
            $table->string('satuan', 50);
            $table->string('kategori', 50);
            $table->timestamps();
            
            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

        DB::table('barang')->insert([
            // Existing data for id_perusahaan 2
            [
                'id_barang' => 1,
                'nama' => 'Shampoo',
                'detail' => 'Shampo Anti Ketombe (Merek A) 250ml',
                'satuan' => 'ml',
                'kategori' => 'Perlengkapan',
                'id_perusahaan' => 2,
            ],
            [
                'id_barang' => 2,
                'nama' => 'Hair Dryer',
                'detail' => 'Hair Dryer Profesional (Merek B)',
                'satuan' => 'unit',
                'kategori' => 'Peralatan',
                'id_perusahaan' => 2,
            ],
            [
                'id_barang' => 3,
                'nama' => 'Masker Wajah',
                'detail' => 'Masker Wajah Herbal (Merek C) 100 gr',
                'satuan' => 'gr',
                'kategori' => 'Perlengkapan',
                'id_perusahaan' => 2,
            ],
            [
                'id_barang' => 4,
                'nama' => 'Cream Smoothing',
                'detail' => 'Cream Smoothing Rambut (Merek D) 250 ml',
                'satuan' => 'ml',
                'kategori' => 'Perlengkapan',
                'id_perusahaan' => 2,
            ],
            [
                'id_barang' => 5,
                'nama' => 'Gunting Rambut',
                'detail' => 'Gunting Rambut Stainless (Merek E)',
                'satuan' => 'unit',
                'kategori' => 'Peralatan',
                'id_perusahaan' => 2,
            ],
        
            // Additional data for id_perusahaan 3 (Barang Dagang)
            [
                'id_barang' => 6,
                'nama' => 'Hair Oil',
                'detail' => 'Hair Oil 100ml (Merek F)',
                'satuan' => 'ml',
                'kategori' => 'Perlengkapan',
                'id_perusahaan' => 3,
            ],
            [
                'id_barang' => 7,
                'nama' => 'Face Wash',
                'detail' => 'Face Wash Herbal (Merek G) 150ml',
                'satuan' => 'ml',
                'kategori' => 'Perlengkapan',
                'id_perusahaan' => 3,
            ],
            [
                'id_barang' => 8,
                'nama' => 'Shaving Kit',
                'detail' => 'Shaving Kit Complete (Merek H)',
                'satuan' => 'unit',
                'kategori' => 'Peralatan',
                'id_perusahaan' => 3,
            ],
            [
                'id_barang' => 9,
                'nama' => 'Perfume',
                'detail' => 'Perfume 50ml (Merek I)',
                'satuan' => 'ml',
                'kategori' => 'Perlengkapan',
                'id_perusahaan' => 3,
            ],
            [
                'id_barang' => 10,
                'nama' => 'Nail Cutter',
                'detail' => 'Nail Cutter Stainless (Merek J)',
                'satuan' => 'unit',
                'kategori' => 'Peralatan',
                'id_perusahaan' => 3,
            ],
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
