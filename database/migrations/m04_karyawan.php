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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->string('nama');
            $table->string('no_telp');
            $table->string('jenis_kelamin');
            $table->string('email')->unique();
            $table->string('alamat');
            $table->string('status');
            $table->foreignId('id_jabatan');
            $table->foreignId('id_perusahaan');
            $table->foreignId('id_user');
            $table->timestamps();

            // Add foreign key constraints if needed
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan')->onDelete('cascade');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        // Insert data into users
        DB::table('users')->insert([
            [
                'username' => 'maja',
                'email' => 'maja@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'ceo pt tajir',
                'id_role' => 2,
                'id_perusahaan' => 2,
            ],
            [
                'username' => 'faiz',
                'email' => 'faiz@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'ceo pt tajir',
                'id_role' => 2,
                'id_perusahaan' => 2,
            ],
            [
                'username' => 'adit',
                'email' => 'adit@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'karyawan pt tajir',
                'id_role' => 3,
                'id_perusahaan' => 2,
            ],
            [
                'username' => 'kiki',
                'email' => 'kiki@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'karyawan pt tajir',
                'id_role' => 4,
                'id_perusahaan' => 2,
            ],
            [
                'username' => 'nana',
                'email' => 'nana@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'karyawan pt tajir',
                'id_role' => 4,
                'id_perusahaan' => 2,
            ],
        ]);

        DB::table('karyawan')->insert([
            [
                'nama' => 'Maja',
                'no_telp' => '08123456789',
                'jenis_kelamin' => 'Laki-laki',
                'email' => 'maja@mail.com',
                'alamat' => 'Bandung',
                'status' => 'Aktif',
                'id_jabatan' => 1,
                'id_perusahaan' => 2,
                'id_user' => 5,
            ],
            [
                'nama' => 'Faiz',
                'no_telp' => '08112345678',
                'jenis_kelamin' => 'Laki-laki',
                'email' => 'faiz@mail.com',
                'alamat' => 'Bandung',
                'status' => 'Aktif',
                'id_jabatan' => 1,
                'id_perusahaan' => 2,
                'id_user' => 6,
            ],
            [
                'nama' => 'Adit',
                'no_telp' => '08112234567',
                'jenis_kelamin' => 'Laki-laki',
                'email' => 'adit@mail.com',
                'alamat' => 'Bandung',
                'status' => 'Aktif',
                'id_jabatan' => 2,
                'id_perusahaan' => 2,
                'id_user' => 7,
            ],
            [
                'nama' => 'Kiki',
                'no_telp' => '08112233456',
                'jenis_kelamin' => 'Laki-laki',
                'email' => 'kiki@mail.com',
                'alamat' => 'Bandung',
                'status' => 'Aktif',
                'id_jabatan' => 2,
                'id_perusahaan' => 2,
                'id_user' => 8,
            ],
            [
                'nama' => 'Nana',
                'no_telp' => '08112233445',
                'jenis_kelamin' => 'Perempuan',
                'email' => 'nana@mail.com',
                'alamat' => 'Bandung',
                'status' => 'Aktif',
                'id_jabatan' => 3,
                'id_perusahaan' => 2,
                'id_user' => 9,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
