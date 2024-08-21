<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Pelanggan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // Get the currently logged-in user

        // Check if the user's id_perusahaan is 1
        if ($user->id_perusahaan == 1) {
            // If the user's id_perusahaan is 1, fetch all COA data
            $pelanggans = Pelanggan::join('perusahaan', 'pelanggan.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('pelanggan.*', 'perusahaan.nama as nama_perusahaan')
                ->get();
            $perusahaan = DB::table('perusahaan')->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $pelanggans = Pelanggan::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'pelanggan.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('pelanggan.*')
                ->get();
        }

        $jabatan = DB::table('jabatan')->get();

        return view('masterdata.pelanggan.index', [
            'table' => 'pelanggan',
            'pelanggans' => $pelanggans,
            'perusahaan' => $perusahaan,
            'jabatan' => $jabatan,
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'id_perusahaan' => 'required',
        ]);

        // Save data
        Pelanggan::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'status' => 'Aktif',
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $pelanggans = Pelanggan::findOrFail($id);

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();
    
        $jabatan = DB::table('jabatan')->get();

        // Pass the data to the edit view
        // return view('masterdata.pelanggan.edit', compact('pelanggans', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'pelanggans' => $pelanggans,
            'perusahaan' => $perusahaan,
            'jabatan' => $jabatan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pelanggan)
    {
        // Save data
        Pelanggan::where('id_pelanggan', $id_pelanggan)
        ->update([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return response()->json(['success' => true]);
    }
}
