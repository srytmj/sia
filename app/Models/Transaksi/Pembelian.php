<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';

    protected $primaryKey = 'id_pembelian';

    protected $guarded = [];

    static public function getKode()
    {
        // Query untuk mengambil nilai maksimum bahanbaku_kode dari tabel bahanbaku
        $max_bahanbaku_kode = Pembelian::max('id_pembelian');

        // Jika nilai maksimum tidak ditemukan, beri nilai awal BB-000
        if (!$max_bahanbaku_kode) {
            return 'PBL-001';
        }

        // Mengambil tiga digit terakhir dari bahanbaku_kode maksimum
        $no_awal = (int) substr($max_bahanbaku_kode, -3);

        // Menambahkan 1 ke tiga digit terakhir
        $no_akhir = $no_awal + 1;

        // Menyambungkan string BB- dengan tiga digit terakhir yang sudah ditambahkan 1
        $bahanbaku_kode_baru = 'PBL-' . str_pad($no_akhir, 3, "0", STR_PAD_LEFT);

        return $bahanbaku_kode_baru;
    }
}
