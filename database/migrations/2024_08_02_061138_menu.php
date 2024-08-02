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

        DB::table('user_role')->insert([
            [
                'nama_role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Tabel user_access_menu
        Schema::create('user_access_menu', function (Blueprint $table) {
            $table->id('id_access_menu');
            $table->integer('urutan_menu');

            $table->foreignId('id_role'); // Foreign key column
            $table->foreign('id_role')->references('id_role')->on('user_role')->onDelete('cascade');

            $table->foreignId('id_menu'); // Foreign key column
            $table->foreign('id_menu')->references('id_menu')->on('user_menu')->onDelete('cascade');

            $table->integer('id_perusahaan')->nullable();
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

            $table->foreignId('id_perusahaan')->default(1); // Foreign key column
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->foreignId('id_role')->default(1); // Foreign key column
            $table->foreign('id_role')->references('id_role')->on('user_role')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_access_menu');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_menu_sub');
        Schema::dropIfExists('user_menu');
    }

};



