<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Jabatan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreJabatanRequest;
use App\Http\Requests\UpdateJabatanRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JabatanController extends Controller
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
            $jabatans = Jabatan::join('perusahaan', 'jabatan.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('jabatan.*', 'perusahaan.nama as nama_perusahaan')
                ->get();
            $perusahaan = DB::table('perusahaan')->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $jabatans = Jabatan::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'jabatan.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('jabatan.*', 'perusahaan.nama')
                ->get();
        }

        return view('masterdata.jabatan.index', [
            'table' => 'jabatan',
            'jabatans' => $jabatans,
            'perusahaan' => $perusahaan
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
            'nama' => 'required|string',
            'asuransi' => 'required|integer',
            'tarif_tetap' => 'required|integer',
            'tarif_tidak_tetap' => 'required|integer',
            'id_perusahaan' => 'required|integer|exists:perusahaan,id_perusahaan',
        ]);

        // Save the new COA
        Jabatan::create([
            'nama' => $request->nama,
            'asuransi' => $request->asuransi,
            'tarif_tetap' => $request->tarif_tetap,
            'tarif_tidak_tetap' => $request->tarif_tidak_tetap,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'COA created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $jabatans = Jabatan::findOrFail($id);

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();
    
        // Pass the data to the edit view
        // return view('masterdata.jabatan.edit', compact('jabatans', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'jabatans' => $jabatans,
            'perusahaan' => $perusahaan
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_jabatan)
    {
        Jabatan::where('id_jabatan', $id_jabatan)
            ->update([
            'nama' => $request->nama,
            'asuransi' => $request->asuransi,
            'tarif_tetap' => $request->tarif_tetap,
            'tarif_tidak_tetap' => $request->tarif_tidak_tetap,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return response()->json(['success' => true]);
    }
}
