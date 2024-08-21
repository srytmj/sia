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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->string('keterangan');
            $table->string('jenis_transaksi');
            $table->string('status');
            $table->date('tanggal_transaksi');
            $table->date('tanggal_pelunasan')->nullable();
            $table->timestamps();

            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->foreignId('id_supplier');
            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('cascade');
        });

        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->id('id_pembelian_detail');
            $table->integer('kuantitas');
            $table->integer('harga');
            $table->integer('subtotal')->virtualAs('kuantitas * harga');
            $table->timestamps();

            $table->foreignId('id_pembelian');
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');

            $table->foreignId('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        });

        DB::table('pembelian')->insert([
            [
                'keterangan' => 'masuk',
                'jenis_transaksi' => 'tunai',
                'status' => 'lunas',
                'tanggal_transaksi' => Carbon::parse('2024-08-01'),
                'tanggal_pelunasan' => Carbon::parse('2024-08-05'),
                'id_perusahaan' => 2,
                'id_supplier' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keterangan' => 'masuk',
                'jenis_transaksi' => 'kredit',
                'status' => 'belum lunas',
                'tanggal_transaksi' => Carbon::parse('2024-08-03'),
                'tanggal_pelunasan' => null,
                'id_perusahaan' => 2,
                'id_supplier' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        DB::table('pembelian_detail')->insert([
            [
                'id_pembelian' => 1,
                'id_barang' => 1,
                'kuantitas' => 5,
                'harga' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 2,
                'id_barang' => 2,
                'kuantitas' => 3,
                'harga' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 2,
                'id_barang' => 3,
                'kuantitas' => 4,
                'harga' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
