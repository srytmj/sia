<?php

namespace App\Http\Controllers;

use App\Models\Masterdata;
use App\Http\Requests\StoreMasterdataRequest;
use App\Http\Requests\UpdateMasterdataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterdataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $table)
    {
        // Validasi nama tabel (opsional, bisa menyesuaikan dengan kebutuhan)
        $validTables = ['perusahaan', 'supplier']; // Daftar tabel yang diizinkan
        if ($table == null) {
            abort(404); // Tabel tidak valid, tampilkan halaman 404
        }

        // Ambil data dari tabel yang ditentukan
        $data = DB::table($table)->get();

        // Kembalikan tampilan dengan data yang diambil
        return view('masterdata', ['items' => $data, 'table' => $table]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterdataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Masterdata $masterdata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Masterdata $masterdata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterdataRequest $request, Masterdata $masterdata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masterdata $masterdata)
    {
        //
    }
}
