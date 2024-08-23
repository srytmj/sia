<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {

        Schema::create('coa_kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('kelompok_akun');
            $table->string('nama_kelompok_akun');
            $table->string('header_akun') -> nullable();
        });

        Schema::create('coa', function (Blueprint $table) {
            $table->id('id_coa');
            $table->string('kode');
            $table->string('nama_akun');
            $table->string('kelompok_akun');
            $table->string('posisi_d_c');
            $table->boolean('saldo_awal')->default(0); // 0 = Not Initial Balance, 1 = Initial Balance
            $table->unsignedBigInteger('id_perusahaan');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

        // Insert data into coa_kelompok
        DB::table('coa_kelompok')->insert([
            [
                'kelompok_akun' => '11',
                'nama_kelompok_akun' => 'Aktiva',
                'header_akun' => null,
            ],
            [
                'kelompok_akun' => '111',
                'nama_kelompok_akun' => 'Aktiva Lancar',
                'header_akun' => '11',
            ],
            [
                'kelompok_akun' => '112',
                'nama_kelompok_akun' => 'Aktiva Tetap',
                'header_akun' => '11',
            ],
            [
                'kelompok_akun' => '210',
                'nama_kelompok_akun' => 'Kewajiban',
                'header_akun' => null,
            ],
            [
                'kelompok_akun' => '310',
                'nama_kelompok_akun' => 'Modal',
                'header_akun' => null,
            ],            
            [
                'kelompok_akun' => '410',
                'nama_kelompok_akun' => 'Penjualan',
                'header_akun' => null,
            ],
            [
                'kelompok_akun' => '510',
                'nama_kelompok_akun' => 'Pembelian',
                'header_akun' => null,
            ],
        ]);

        // Insert data into coa
        DB::table('coa')->insert([
            [
                'kode' => '01',
                'nama_akun' => 'Kas',
                'kelompok_akun' => 'Aktiva Lancar',
                'posisi_d_c' => 'Debit',
                'saldo_awal' => 1,
                'id_perusahaan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => '01',
                'nama_akun' => 'Peralatan Salon',
                'kelompok_akun' => 'Aktiva Tetap',
                'posisi_d_c' => 'Debit',
                'saldo_awal' => 1,
                'id_perusahaan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => '01',
                'nama_akun' => 'Utang Usaha',
                'kelompok_akun' => 'Kewajiban',
                'posisi_d_c' => 'Kredit',
                'saldo_awal' => 1,
                'id_perusahaan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => '01',
                'nama_akun' => 'Modal Pemilik',
                'kelompok_akun' => 'Modal',
                'posisi_d_c' => 'Kredit',
                'saldo_awal' => 1,
                'id_perusahaan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => '01',
                'nama_akun' => 'Penjualan',
                'kelompok_akun' => 'Penjualan',
                'posisi_d_c' => 'Kredit',
                'saldo_awal' => 1,
                'id_perusahaan' => 1,
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
        Schema::dropIfExists('coa');
    }
};
