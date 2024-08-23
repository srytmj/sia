<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
class Test extends BaseController
{
    public function test($akun)
    {
        $result = DB::table('coa')
            ->join('coa_kelompok', 'coa.kelompok_akun', '=', 'coa_kelompok.nama_kelompok_akun')
            ->whereRaw('LOWER(coa.nama_akun) = ?', $akun)
            ->select(DB::raw('CONCAT(coa_kelompok.kelompok_akun, coa.kode) AS kode_akun'))
            ->value('kode_akun');

        // return json
        return response()->json($result);   
    }
}