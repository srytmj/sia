<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Tabel user_menu
        Schema::create('user_menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('nama_menu', 50);
            $table->string('url_menu', 50);
            $table->string('icon_menu', 50)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // Tabel user_menu_sub
        Schema::create('user_menu_sub', function (Blueprint $table) {
            $table->id('id_menu_sub');
            $table->string('nama_menu_sub', 50);
            $table->string('url_menu', 50);
            $table->integer('urutan_menu');
            $table->boolean('is_active')->default(1);

            $table->foreignId('id_menu'); // Foreign key column
            $table->foreign('id_menu')->references('id_menu')->on('user_menu')->onDelete('cascade');
            
            $table->timestamps();
        });

        // Tabel user_access_menu
        Schema::create('user_access_menu', function (Blueprint $table) {
            $table->id('id_access_menu');
            $table->integer('urutan_menu');

            $table->foreignId('id_role'); // Foreign key column
            $table->foreign('id_role')->references('id_role')->on('user_role')->onDelete('cascade');

            $table->foreignId('id_menu'); // Foreign key column
            $table->foreign('id_menu')->references('id_menu')->on('user_menu')->onDelete('cascade');

            $table->foreignId('id_perusahaan'); // Foreign key column
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->timestamps();
        });

        // Insert data into user_menu first
        DB::table('user_menu')->insert([
            ['id_menu' => 1, 'nama_menu' => 'Data Admin', 'url_menu' => 'masterdata', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 2, 'nama_menu' => 'Data Client', 'url_menu' => 'masterdata', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 3, 'nama_menu' => 'Data Divisi', 'url_menu' => 'masterdata', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 4, 'nama_menu' => 'Transaksi', 'url_menu' => 'transaksi', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 5, 'nama_menu' => 'Laporan', 'url_menu' => 'laporan', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 6, 'nama_menu' => 'Presensi', 'url_menu' => 'presensi', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert data into user_menu_sub
        DB::table('user_menu_sub')->insert([
            [
                'nama_menu_sub' => 'Perusahaan',
                'url_menu' => 'perusahaan',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pengguna',
                'url_menu' => 'users',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'COA',
                'url_menu' => 'coa',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Jabatan',
                'url_menu' => 'jabatan',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Karyawan',
                'url_menu' => 'karyawan',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pelanggan',
                'url_menu' => 'pelanggan',
                'urutan_menu' => 4,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Supplier',
                'url_menu' => 'supplier',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Barang',
                'url_menu' => 'barang',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Jasa (jasa)',
                'url_menu' => 'jasa',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Penjualan',
                'url_menu' => 'penjualan',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pembelian',
                'url_menu' => 'pembelian',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Penggajian',
                'url_menu' => 'penggajian',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pelunasan',
                'url_menu' => 'pelunasan',
                'urutan_menu' => 5,
                'is_active' => 1,
                'id_menu' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Presensi',
                'url_menu' => 'presensi',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Jurnal',
                'url_menu' => 'jurnal',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Neraca',
                'url_menu' => 'neraca',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Laba Rugi',
                'url_menu' => 'laba-rugi',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Roles',
                'url_menu' => 'user_role',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Then insert into user_access_menu
        DB::table('user_access_menu')->insert([
            // admin
            ['urutan_menu' => 1, 'id_role' => 1, 'id_menu' => 1, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 2, 'id_role' => 1, 'id_menu' => 2, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 3, 'id_role' => 1, 'id_menu' => 3, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 4, 'id_role' => 1, 'id_menu' => 4, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 5, 'id_role' => 1, 'id_menu' => 5, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 6, 'id_role' => 1, 'id_menu' => 6, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            // ceo 1
            ['urutan_menu' => 1, 'id_role' => 2, 'id_menu' => 2, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 2, 'id_role' => 2, 'id_menu' => 3, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 3, 'id_role' => 2, 'id_menu' => 4, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 4, 'id_role' => 2, 'id_menu' => 5, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 5, 'id_role' => 1, 'id_menu' => 6, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            // kar1
            ['urutan_menu' => 1, 'id_role' => 3, 'id_menu' => 4, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 2, 'id_role' => 3, 'id_menu' => 6, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            // kar2
            ['urutan_menu' => 1, 'id_role' => 3, 'id_menu' => 5, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 2, 'id_role' => 4, 'id_menu' => 6, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_access_menu');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_menu_sub');
        Schema::dropIfExists('user_menu');

        // Optionally, you could delete the inserted data in the reverse order
        DB::table('users')->delete();
        DB::table('user_access_menu')->delete();
        DB::table('user_role')->delete();
        DB::table('user_menu_sub')->delete();
        DB::table('user_menu')->delete();
    }

};



