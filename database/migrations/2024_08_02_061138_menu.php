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
        // Migrasi untuk tabel kategori_perusahaan
        Schema::create('kategori_perusahaan', function (Blueprint $table) {
            $table->id('id_kategori_perusahaan');
            $table->string('nama', 50);
            $table->timestamps();
        });

        // Migrasi untuk tabel perusahaan
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('id_perusahaan');
            $table->string('nama', 50)->unique();
            $table->string('alamat', 50);
            $table->unsignedBigInteger('id_kategori_perusahaan')->nullable();
            $table->foreign('id_kategori_perusahaan')->references('id_kategori_perusahaan')->on('kategori_perusahaan')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('kategori_perusahaan')->insert([
            [
                'nama' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dagang',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Jasa',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        
        // Insert data into perusahaan
        DB::table('perusahaan')->insert([
            [
                'nama' => 'Admin',
                'alamat' => 'Jl. Admin',
                'id_kategori_perusahaan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'PT. Tajin Mendunia',
                'alamat' => 'Jl. Tajir',
                'id_kategori_perusahaan' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

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

        // Tabel user_role
        Schema::create('user_role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role', 50);
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

        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('jabatan', 50)->nullable();
            $table->string('status_akun', 50)->nullable();
            $table->string('detail', 50)->nullable();

            $table->foreignId('id_role')->default(1); // Foreign key column
            $table->foreign('id_role')->references('id_role')->on('user_role')->onDelete('cascade');

            $table->foreignId('id_perusahaan')->default(1); // Foreign key column
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        // Insert data into user_menu first
        DB::table('user_menu')->insert([
            ['id_menu' => 1, 'nama_menu' => 'Master Data', 'url_menu' => 'masterdata', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 2, 'nama_menu' => 'Transaksi', 'url_menu' => 'transaksi', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_menu' => 3, 'nama_menu' => 'Laporan', 'url_menu' => 'laporan', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
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
                'nama_menu_sub' => 'COA',
                'url_menu' => 'coa',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Jabatan',
                'url_menu' => 'jabatan',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Karyawan',
                'url_menu' => 'karyawan',
                'urutan_menu' => 4,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pengguna',
                'url_menu' => 'pengguna',
                'urutan_menu' => 5,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pelanggan',
                'url_menu' => 'pelanggan',
                'urutan_menu' => 6,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Supplier',
                'url_menu' => 'supplier',
                'urutan_menu' => 7,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Barang',
                'url_menu' => 'barang',
                'urutan_menu' => 8,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Jasa (jasa)',
                'url_menu' => 'jasa',
                'urutan_menu' => 9,
                'is_active' => 1,
                'id_menu' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Penjualan',
                'url_menu' => 'penjualan',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pembelian',
                'url_menu' => 'pembelian',
                'urutan_menu' => 2,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Penggajian',
                'url_menu' => 'penggajian',
                'urutan_menu' => 3,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Presensi',
                'url_menu' => 'presensi',
                'urutan_menu' => 4,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Pelunasan',
                'url_menu' => 'pelunasan',
                'urutan_menu' => 5,
                'is_active' => 1,
                'id_menu' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu_sub' => 'Jurnal',
                'url_menu' => 'jurnal',
                'urutan_menu' => 1,
                'is_active' => 1,
                'id_menu' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert data into user_role
        DB::table('user_role')->insert([
            [
                'nama_role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'CEO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'Karyawan A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'Karyawan B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Then insert into user_access_menu
        DB::table('user_access_menu')->insert([
            ['urutan_menu' => 1, 'id_role' => 1, 'id_menu' => 1, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 2, 'id_role' => 1, 'id_menu' => 2, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 3, 'id_role' => 1, 'id_menu' => 3, 'id_perusahaan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 1, 'id_role' => 2, 'id_menu' => 1, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 2, 'id_role' => 2, 'id_menu' => 2, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 3, 'id_role' => 2, 'id_menu' => 3, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 1, 'id_role' => 3, 'id_menu' => 2, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['urutan_menu' => 3, 'id_role' => 4, 'id_menu' => 3, 'id_perusahaan' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert data into users
        DB::table('users')->insert([
            [
                'username' => 'maja',
                'email' => 'maja@mail.com',
                'password' => bcrypt('12341234'),
                'jabatan' => 'admin',
                'status_akun' => 'aktif',
                'detail' => 'superadmin',
                'id_role' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'ceo1',
                'email' => 'ceo1@mail.com',
                'password' => bcrypt('12341234'),
                'jabatan' => 'ceo',
                'status_akun' => 'aktif',
                'detail' => 'ceo pt 1',
                'id_role' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'karyawan1',
                'email' => 'kar1@mail.com',
                'password' => bcrypt('12341234'),
                'jabatan' => 'karyawan',
                'status_akun' => 'aktif',
                'detail' => 'karyawan pt 1',
                'id_role' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'karyawan2',
                'email' => 'kar2@mail.com',
                'password' => bcrypt('12341234'),
                'jabatan' => 'karyawan',
                'status_akun' => 'aktif',
                'detail' => 'karyawan pt 1',
                'id_role' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
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



