<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jasa', function (Blueprint $table) {
            $table->id('id_jasa');
            $table->string('nama', 50);
            $table->text('detail');
            $table->integer('harga');
            $table->timestamps();

            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('jasa_detail', function (Blueprint $table) {
            $table->id('id_jasa_detail');
            $table->integer('kuantitas');

            $table->foreignId('id_jasa');
            $table->foreignId('id_barang');

            // Foreign key constraints
            $table->foreign('id_jasa')->references('id_jasa')->on('jasa')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');

            $table->timestamps();
        });

        DB::table('jasa')->insert([
            [
                'id_jasa' => 1,
                'nama' => 'Potong Rambut',
                'detail' => 'Potong rambut pria dan wanita',
                'harga' => 50000,
                'id_perusahaan' => 2,
            ],
            [
                'id_jasa' => 2,
                'nama' => 'Facial Wajah',
                'detail' => 'Perawatan wajah untuk semua jenis kulit',
                'harga' => 120000,
                'id_perusahaan' => 2,
            ],
            [
                'id_jasa' => 3,
                'nama' => 'Manicure & Pedicure',
                'detail' => 'Perawatan kuku tangan dan kaki lengkap',
                'harga' => 100000,
                'id_perusahaan' => 2,
            ],
            [
                'id_jasa' => 4,
                'nama' => 'Creambath',
                'detail' => 'Creambath dengan pilihan aroma terapi',
                'harga' => 75000,
                'id_perusahaan' => 2,
            ],
            [
                'id_jasa' => 5,
                'nama' => 'Smoothing Rambut',
                'detail' => 'Pelurusan rambut tahan lama',
                'harga' => 200000,
                'id_perusahaan' => 2,
            ],
        ]);

        DB::table('jasa_detail')->insert([
            [
                'id_jasa_detail' => 1,
                'id_jasa' => 5,
                'id_barang' => 1,
                'kuantitas' => 1,
            ],
            [
                'id_jasa_detail' => 2,
                'id_jasa' => 5,
                'id_barang' => 4,
                'kuantitas' => 2,
            ],
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasa');
    }
};
