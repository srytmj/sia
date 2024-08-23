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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama');
            $table->string('email')->unique()->nullable();
            $table->string('no_telp');
            $table->string('alamat');
            $table->string('status')->default('Aktif');

            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->timestamps();
        });

        DB::table('pelanggan')->insert([
            [
                'nama' => 'John Doe',
                'email' => 'johndoe@mail.com',
                'no_telp' => '08123456789',
                'alamat' => 'Jakarta',
                'id_perusahaan' => 2,
                'created_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'janesmith@mail.com',
                'no_telp' => '08112345678',
                'alamat' => 'Bandung',
                'id_perusahaan' => 2,
                'created_at' => now(),
            ],
            [
                'nama' => 'Michael Johnson',
                'email' => 'michaelj@mail.com',
                'no_telp' => '08112234567',
                'alamat' => 'Surabaya',
                'id_perusahaan' => 2,
                'created_at' => now(),
            ]
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
