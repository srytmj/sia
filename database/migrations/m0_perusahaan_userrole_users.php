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
        // Migrasi untuk tabel perusahaan
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('id_perusahaan');
            $table->string('nama', 50)->unique();
            $table->string('alamat', 50);
            $table->string('jenis_perusahaan', 50);
            $table->timestamps();
        });

        // Tabel user_role
        Schema::create('user_role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role', 50);
            $table->timestamps();
        });

        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status', 50)->default('aktif')->nullable();
            $table->string('detail', 50)->nullable();

            $table->foreignId('id_role')->default(null)->nullable(); // Foreign key column
            $table->foreign('id_role')->references('id_role')->on('user_role')->onDelete('cascade');

            $table->foreignId('id_perusahaan')->default(1); // Foreign key column
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        // Insert data into perusahaan
        DB::table('perusahaan')->insert([
            [
                'nama' => 'Admin',
                'alamat' => 'Jl. Admin',
                'jenis_perusahaan' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'PT. Tajin Mendunia',
                'alamat' => 'Jl. Tajir',
                'jenis_perusahaan' => 'Jasa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'PT. Jualan  Apasaja',
                'alamat' => 'Jl. Apasaja',
                'jenis_perusahaan' => 'Dagang',
                'created_at' => now(),
                'updated_at' => now()
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

        // Insert data into users
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'superadmin',
                'id_role' => 1,
                'id_perusahaan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'ceo1',
                'email' => 'ceo1@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'ceo pt 1',
                'id_role' => 2,
                'id_perusahaan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'karyawan1',
                'email' => 'kar1@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'karyawan pt 1',
                'id_role' => 3,
                'id_perusahaan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'karyawan2',
                'email' => 'kar2@mail.com',
                'password' => bcrypt('12341234'),
                'status' => 'aktif',
                'detail' => 'karyawan pt 1',
                'id_role' => 4,
                'id_perusahaan' => 2,
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
        Schema::dropIfExists('users');
    }
};
