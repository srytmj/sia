<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->string('no_transaksi');

            $table->foreignId('id_pelanggan')->nullable();
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');

            $table->date('tgl_transaksi');
            $table->integer('total');
            $table->string('status');
            
            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->timestamps();

            // Foreign key relationships
        });

        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_penjualan');
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');

            $table->integer('id_produk');
            $table->string('keterangan_produk'); // barang atau jasa
            $table->integer('harga');
            $table->integer('kuantitas');
            $table->timestamps();

            // Virtual total column
            $table->integer('total')->virtualAs('harga * kuantitas');

            // Foreign key relationships
        });

        DB::table('penjualan')->insertGetId([
            'no_transaksi' => 'PNJ-001',
            'tgl_transaksi' => now(),
            'total' => 500000, // Replace with actual total
            'status' => 'Selesai',
            'id_perusahaan' => 2, // Replace with actual company ID
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Insert data into penjualan_detail
        DB::table('penjualan_detail')->insert([
            [
                'id_penjualan' => '1',
                'id_produk' => 1, // Replace with actual product ID
                'keterangan_produk' => 'barang',
                'harga' => 100000,
                'kuantitas' => 3,
            ],
            [
                'id_penjualan' => '1',
                'id_produk' => 1, // Replace with actual product ID
                'keterangan_produk' => 'jasa',
                'harga' => 200000,
                'kuantitas' => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('penjualan_detail');
    }
};
