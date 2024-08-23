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
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaksi');
            $table->string('jenis_transaksi'); // pembelian atau penjualan
            $table->string('kode_akun');
            $table->date('tanggal_jurnal');
            $table->string('posisi_d_c'); // D (Debit) or C (Credit)
            $table->decimal('nominal', 15, 2);
            $table->string('kelompok');
            $table->foreignId('id_perusahaan');
            $table->timestamps();

            // Foreign key relationships
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

        // insert data
        DB::table('jurnal')->insert([
            [
                'id_transaksi' => 1, // Use the ID from the inserted penjualan
                'jenis_transaksi' => 'pembelian',
                'kode_akun' => '11101', // Replace with actual account code
                'tanggal_jurnal' => now(),
                'posisi_d_c' => 'd', // Debit entry
                'nominal' => 500000, // Replace with actual nominal
                'kelompok' => 'Pendapatan', // Replace with actual group
                'id_perusahaan' => 2, // Replace with actual company ID
            ],
            [
                'id_transaksi' => 1, // Use the ID from the inserted penjualan
                'jenis_transaksi' => 'pembelian',
                'kode_akun' => '11101', // Replace with actual account code
                'tanggal_jurnal' => now(),
                'posisi_d_c' => 'c', // Credit entry
                'nominal' => 500000, // Replace with actual nominal
                'kelompok' => 'Kas', // Replace with actual group
                'id_perusahaan' => 2, // Replace with actual company ID
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};
