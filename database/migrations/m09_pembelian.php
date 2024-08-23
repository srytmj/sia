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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->string('no_transaksi');

            $table->foreignId('id_supplier');
            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('cascade');

            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

            $table->date('tanggal_transaksi');
            $table->date('tanggal_pelunasan')->nullable();
            $table->integer('tunai')->nullable();
            $table->integer('kredit')->nullable();
            $table->string('jenis_transaksi')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
        
        // Triggers
        // DB::unprepared('
        //     CREATE TRIGGER update_pembelian_values BEFORE INSERT OR UPDATE ON pembelian
        //     FOR EACH ROW
        //     BEGIN
        //         DECLARE total_pembelian DECIMAL(15,2);
        //         DECLARE sum_subtotal DECIMAL(15,2);
                
        //         -- Calculate the total from pembelian_detail
        //         SELECT SUM(subtotal) INTO sum_subtotal 
        //         FROM pembelian_detail 
        //         WHERE id_pembelian = NEW.id_transaksi;

        //         -- Set the kredit value
        //         SET NEW.kredit = sum_subtotal - IFNULL(NEW.tunai, 0);

        //         -- Set the status value
        //         IF NEW.kredit IS NULL THEN
        //             SET NEW.status = NULL;
        //         ELSEIF NEW.kredit = 0 THEN
        //             SET NEW.status = "Lunas";
        //         ELSE
        //             SET NEW.status = "Belum Lunas";
        //         END IF;

        //         -- Set the jenis_transaksi value
        //         IF NEW.kredit IS NULL THEN
        //             SET NEW.jenis_transaksi = NULL;
        //         ELSEIF sum_subtotal = (NEW.kredit + IFNULL(NEW.tunai, 0)) THEN
        //             SET NEW.jenis_transaksi = "Total Sesuai";
        //         ELSE
        //             SET NEW.jenis_transaksi = "Total Tidak Sesuai";
        //         END IF;
        //     END;
        // ');

        // Schema::create('pembelian', function (Blueprint $table) {
        //     $table->id('id_pembelian');
        //     $table->string('keterangan');
        //     $table->string('jenis_transaksi');
        //     $table->string('status')->nullable();
        //     $table->date('tanggal_transaksi');
        //     $table->date('tanggal_pelunasan')->nullable();
        //     $table->integer('kredit')->virtualAs('SELECT SUM(subtotal) FROM pembelian_detail WHERE id_pembelian = id_pembelian');
        //     $table->timestamps();

        //     $table->foreignId('id_perusahaan');
        //     $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');

        //     $table->foreignId('id_supplier');
        //     $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('cascade');
        // });

        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->id('id_pembelian_detail');

            $table->foreignId('id_pembelian');
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');

            $table->foreignId('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');

            $table->integer('kuantitas');
            $table->integer('harga');
            $table->integer('subtotal')->virtualAs('kuantitas * harga');
            $table->timestamps();
        });

        DB::table('pembelian')->insert([
            [
                'no_transaksi' => 'PBL-001',
                'id_supplier' => 1,
                'id_perusahaan' => 2,
                'tanggal_transaksi' => Carbon::parse('2024-08-01'),
                'tanggal_pelunasan' => Carbon::parse('2024-08-01'),
                'tunai' => 125000,
                'kredit' => 0,
                'jenis_transaksi' => 'tunai',
                'status' => 'lunas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_transaksi' => 'PBL-002',
                'id_supplier' => 2,
                'id_perusahaan' => 2,
                'tanggal_transaksi' => Carbon::parse('2024-08-03'),
                'tanggal_pelunasan' => null,
                'tunai' => null,
                'kredit' => null,
                'jenis_transaksi' => null,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        DB::table('pembelian_detail')->insert([
            [
                'id_pembelian' => 1,
                'id_barang' => 1,
                'kuantitas' => 5,
                'harga' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 1,
                'id_barang' => 2,
                'kuantitas' => 3,
                'harga' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 2,
                'id_barang' => 3,
                'kuantitas' => 4,
                'harga' => 20000,
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
        Schema::dropIfExists('pembelian');
        Schema::dropIfExists('pembelian_detail');
    }
};
