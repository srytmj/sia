<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Transaksi\Pembelian;
use App\Models\Transaksi\Pembeliandetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembelianController extends Controller
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
            $pembelians = Pembelian::join('perusahaan', 'pembelian.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->join('supplier', 'pembelian.id_supplier', '=', 'supplier.id_supplier')
                ->select('pembelian.*', 'perusahaan.nama as nama_perusahaan', 'supplier.nama as nama_supplier')
                ->get();
                
            $perusahaans = DB::table('perusahaan')
                ->where('perusahaan.id_perusahaan', '!=', 1)
                ->whereIn('perusahaan.id_perusahaan', function($query) {
                    $query->select('id_perusahaan')
                          ->from('supplier');
                })
                ->get();
            
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $pembelians = Pembelian::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'pembelian.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->join('supplier', 'pembelian.id_supplier', '=', 'supplier.id_supplier')
                ->select('pembelian.*', 'supplier.nama as nama_supplier')
                ->get();
        }

        $suppliers = DB::table('supplier')->get();

        return view('transaksi.pembelian.index', [
            'table' => 'pembelian',
            'pembelians' => $pembelians,
            'perusahaans' => $perusahaans,
            'suppliers' => $suppliers,
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
    public function store(StorePembelianRequest $request)
    {
        $request->validate([
            'id_perusahaan' => 'required',
            'id_supplier' => 'required',
        ]);

        // Pembelian::create($request->all());
        Pembelian::create([
            'no_transaksi' => Pembelian::getKode(),
            'status' => 'pending',
            'tanggal_transaksi' => now(),
            'id_perusahaan' => $request->id_perusahaan,
            'id_supplier' => $request->id_supplier,
        ]);
        return redirect()->route('pembelian.index')->with('success', 'Pembelian created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // 
    }  
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update($request->all());

        return redirect()->route('pembelian.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();
        return response()->json(['success' => true]);
    }
}
