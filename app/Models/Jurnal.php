<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class jurnal extends Model
{
    use HasFactory;

    static public function coa($akun)
    {
        $result = DB::table('coa')
            ->join('coa_kelompok', 'coa.kelompok_akun', '=', 'coa_kelompok.nama_kelompok_akun')
            ->whereRaw('LOWER(coa.nama_akun) = ?', $akun)
            ->select(DB::raw('CONCAT(coa_kelompok.kelompok_akun, coa.kode) AS kode_akun'))
            ->value('kode_akun');

        // return json
        // return response()->json($result); 
        return $result;  
    }
}
