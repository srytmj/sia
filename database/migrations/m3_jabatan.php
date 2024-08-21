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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama');
            $table->integer('asuransi')->nullable();
            $table->integer('tarif_tetap')->nullable();
            $table->integer('tarif_tidak_tetap')->nullable();   

            $table->foreignId('id_perusahaan'); // Foreign key column
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
            
            $table->timestamps();
        });

        DB::table('jabatan')->insert([
            [
                'id_jabatan' => 1,
                'nama' => 'CEO',
                'asuransi' => rand(1000000, 5000000), // Random value between 1,000,000 and 5,000,000
                'tarif_tetap' => rand(15000000, 30000000), // Random value between 15,000,000 and 30,000,000
                'tarif_tidak_tetap' => rand(2000000, 10000000), // Random value between 2,000,000 and 10,000,000
                'id_perusahaan' => 2,
            ],
            [
                'id_jabatan' => 2,
                'nama' => 'Supervisor',
                'asuransi' => rand(500000, 2000000), // Random value between 500,000 and 2,000,000
                'tarif_tetap' => rand(8000000, 15000000), // Random value between 8,000,000 and 15,000,000
                'tarif_tidak_tetap' => rand(1000000, 5000000), // Random value between 1,000,000 and 5,000,000
                'id_perusahaan' => 2,
            ],
            [
                'id_jabatan' => 3,
                'nama' => 'Kasir',
                'asuransi' => rand(300000, 1000000), // Random value between 300,000 and 1,000,000
                'tarif_tetap' => rand(3000000, 7000000), // Random value between 3,000,000 and 7,000,000
                'tarif_tidak_tetap' => rand(500000, 2000000), // Random value between 500,000 and 2,000,000
                'id_perusahaan' => 2,
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
