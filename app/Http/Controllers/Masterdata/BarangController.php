<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Barang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BarangController extends Controller
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
            $barangs = Barang::join('perusahaan', 'barang.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('barang.*', 'perusahaan.nama as nama_perusahaan')
                ->get();
            $perusahaan = DB::table('perusahaan')->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $barangs = Barang::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'barang.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('barang.*')
                ->get();
        }

        return view('masterdata.barang.index', [
            'table' => 'barang',
            'barangs' => $barangs,
            'perusahaan' => $perusahaan,
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
            'detail' => 'required',
            'satuan' => 'required',
            'kategori' => 'required',
            'id_perusahaan' => 'required',
        ]);

        // Save data
        Barang::create([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $barangs = Barang::findOrFail($id);

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();

        // Pass the data to the edit view
        // return view('masterdata.barang.edit', compact('barangs', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'barangs' => $barangs,
            'perusahaan' => $perusahaan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_barang)
    {
        // Save data
        Barang::where('id_barang', $id_barang)
        ->update([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json(['success' => true]);
    }
}
