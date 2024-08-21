<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Jasa;
use App\Models\Masterdata\Jasadetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreJasaRequest;
use App\Http\Requests\UpdateJasaRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JasaController extends Controller
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
            $jasas = Jasa::join('perusahaan', 'jasa.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('jasa.*', 'perusahaan.nama as nama_perusahaan')
                ->get();
            $perusahaan = DB::table('perusahaan')
                ->where('perusahaan.jenis_perusahaan', 'jasa')
                ->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $jasas = Jasa::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'jasa.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('jasa.*')
                ->get();
        }

        return view('masterdata.jasa.index', [
            'table' => 'jasa',
            'jasas' => $jasas,
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
    public function store(StoreJasaRequest $request)
    {
        $request->validate([
            'nama' => 'required',
            'detail' => 'required',
            'harga' => 'required',
            'id_perusahaan' => 'required',
        ]);

        Jasa::create($request->all());

        return redirect()->route('jasa.index')->with('success', 'Jasa created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jasa $jasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jasa = Jasa::find($id);

        if (!$jasa) {
            return redirect()->route('jasa.index')->with('error', 'Role not found');
        }
        $jasa_detail = DB::table('jasa_detail')
            ->join('jasa', 'jasa_detail.id_jasa', '=', 'jasa.id_jasa')
            ->join('barang', 'jasa_detail.id_barang', '=', 'barang.id_barang')
            ->select(
                    'jasa_detail.id_jasa_detail AS id_jasa_detail',
                    'jasa_detail.id_barang AS id',
                    'barang.nama AS nama',
                    'barang.satuan AS satuan',
                    DB::raw('COUNT(jasa_detail.id_barang) AS total_items'),
                    DB::raw('SUM(jasa_detail.kuantitas) AS kuantitas')
                )
            ->where('jasa.id_jasa', $id)
            ->groupBy('jasa_detail.id_barang', 'barang.nama', 'barang.satuan', 'jasa_detail.id_jasa_detail')
            ->get();

        $barang = DB::table('barang')
            ->where('id_perusahaan', $jasa->id_perusahaan)
            ->where('kategori', 'perlengkapan')
            ->get();
    
        return view('masterdata.jasa.edit', compact('jasa', 'jasa_detail', 'barang'));
        // return response()->json([$jasa, $jasa_detail]);

    }  
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->update($request->all());

        return redirect()->route('jasa.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->delete();
        return response()->json(['success' => true]);
    }

    public function storedetail(StoreJasaRequest $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'id_jasa' => 'required',
            'kuantitas' => 'required',
        ]);

        Jasadetail::create($request->all());
        return response()->json(['success' => true]);
    }

    public function editdetail($id)
    {
        $jasa_detail = Jasadetail::find($id);
        $barang = DB::table('barang')
            ->where('id_perusahaan', $jasa_detail->id_jasa_detail)
            ->where('kategori', 'perlengkapan')
            ->get();
            
        return response()->json($data = [
            'jasa_detail' => $jasa_detail,
            'barang' => $barang,
        ]);
    }

    public function updatedetail(Request $request, $id)
    {
        $jasa_detail = Jasadetail::findOrFail($id);
        $jasa_detail->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroydetail($id)
    {
        $jasa_detail = Jasadetail::findOrFail($id);
        $jasa_detail->delete();
        return response()->json(['success' => true]);
    }
}
