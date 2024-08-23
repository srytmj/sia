<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Coa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCoaRequest;
use App\Http\Requests\UpdateCoaRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoaController extends Controller
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
            $coas = Coa::join('perusahaan', 'coa.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('coa.*', 'perusahaan.nama')
                ->get();
            $perusahaan = DB::table('perusahaan')->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $coas = Coa::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'coa.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('coa.*', 'perusahaan.nama')
                ->get();
        }

        $kelompokAkun = DB::table('coa_kelompok')
            // ignore row 1
            ->where('id', '!=', 1)
            ->get();

        return view('masterdata.coa.index', [
            'table' => 'coa',
            'coas' => $coas,
            'kelompokAkun' => $kelompokAkun,
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
            'nama_akun' => 'required|string',
            'kelompok_akun' => 'required|string',
            'posisi_d_c' => 'required|string',
            'saldo_awal' => 'required|integer',
            'id_perusahaan' => 'required|integer|exists:perusahaan,id_perusahaan',
        ]);

        // Determine the next kode value
        $lastCoa = Coa::where('kelompok_akun', $request->kelompok_akun)
            ->where('id_perusahaan', $request->id_perusahaan)
            ->orderBy('kode', 'desc')
            ->first();

        // Start from 1 if no previous entries exist
        $nextId = $lastCoa ? $lastCoa->kode + 1 : 1;

        // Format the ID to always be 2 digits (e.g., 01, 02, ..., 10, 11)
        $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

        // Save the new COA
        Coa::create([
            'kode' => $formattedId,
            'nama_akun' => $request->nama_akun,
            'kelompok_akun' => $request->kelompok_akun,
            'posisi_d_c' => $request->posisi_d_c,
            'saldo_awal' => $request->saldo_awal,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return redirect()->route('coa.index')->with('success', 'COA created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $coas = Coa::findOrFail($id);
    
        // Fetch the list of kelompok_akun for the dropdown
        $kelompokAkun = DB::table('coa_kelompok')
        // ignore row 1
        ->where('id', '!=', 1)
        ->get();

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();
    
        // Pass the data to the edit view
        // return view('masterdata.coa.edit', compact('coas', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'coas' => $coas,
            'kelompokAkun' => $kelompokAkun,
            'perusahaan' => $perusahaan
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_coa)
    {
        // Find the kelompok
        $kelompok = DB::table('coa_kelompok')->where('nama_kelompok_akun', $request->kelompok_akun)->first();

        if (!$kelompok) {
            return redirect()->back()->with('error', 'Kelompok Akun not found');
        }
        // Determine the next kode value
        $lastCoa = Coa::where('kelompok_akun', $request->kelompok_akun)
            ->where('id_perusahaan', $request->id_perusahaan)
            ->orderBy('kode', 'desc')
            ->first();

        // Start from 1 if no previous entries exist
        $nextId = $lastCoa ? $lastCoa->kode + 1 : 1;

        // Format the ID to always be 2 digits (e.g., 01, 02, ..., 10, 11)
        $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

        // Update the COA record
        Coa::where('id_coa', $id_coa)
            ->update([
                'kode' => $formattedId,
                'nama_akun' => $request->nama_akun,
                'kelompok_akun' => $request->kelompok_akun,
                'posisi_d_c' => $request->posisi_d_c,
                'saldo_awal' => $request->saldo_awal,
                'id_perusahaan' => $request->id_perusahaan,
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $coa = Coa::findOrFail($id);
        $coa->delete();

        return response()->json(['success' => true]);
    }
}
