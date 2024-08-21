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
            'jenis_transaksi' => 'required',
            'id_perusahaan' => 'required',
            'id_supplier' => 'required',
        ]);

        // Pembelian::create($request->all());
        Pembelian::create([
            'keterangan' => 'masuk',
            'jenis_transaksi' => $request->jenis_transaksi,
            'status' => 'belum_lunas',
            'tanggal_transaksi' => now(),
            'id_perusahaan' => $request->id_perusahaan,
            'id_supplier' => $request->id_supplier,
        ]);
        return redirect()->route('pembelian.index')->with('success', 'Pembelian created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user(); // Get the currently logged-in user

        $pembelian = Pembelian::find($id);

        if (!$pembelian) {
            return redirect()->route('pembelian.index')->with('error', 'Role not found');
        }
        // Check if the user's id_perusahaan is 1
        if ($user->id_perusahaan == 1) {
            $perusahaans = DB::table('perusahaan')
                ->where('perusahaan.id_perusahaan', '!=', 1)
                ->get();
        } else {
            // 
        }

        $selectedPerusahaan = $pembelian->id_perusahaan; // Assuming 'id_perusahaan' is related to 'jasa'

        $pembelian_detail = DB::table('pembelian_detail')
            ->join('pembelian', 'pembelian_detail.id_pembelian', '=', 'pembelian.id_pembelian')
            ->join('barang', 'pembelian_detail.id_barang', '=', 'barang.id_barang')
            ->select('pembelian_detail.id_pembelian_detail', 'pembelian_detail.id_barang', 'barang.nama', 'barang.satuan', 'pembelian_detail.kuantitas', 'pembelian_detail.harga', 'pembelian_detail.subtotal')
            ->where('pembelian.id_pembelian', $id)
            ->get();

        $barang = DB::table('barang')
            ->where('id_perusahaan', $pembelian->id_perusahaan)
            ->where('kategori', 'perlengkapan')
            ->get();
        
        $suppliers = DB::table('supplier')
            ->where('id_perusahaan', $pembelian->id_perusahaan)
            ->get();

        return view('transaksi.pembelian.edit', compact('pembelian', 'pembelian_detail', 'barang', 'perusahaans', 'suppliers', 'selectedPerusahaan'));
        // return response()->json([$pembelian, $pembelian_detail]);

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

    public function storedetail(StorePembelianRequest $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'id_pembelian' => 'required',
            'kuantitas' => 'required',
        ]);

        Pembeliandetail::create($request->all());
        return response()->json(['success' => true]);
    }

    public function editdetail($id)
    {
        $pembelian_detail = Pembeliandetail::find($id);
        $barang = DB::table('barang')
            ->where('id_perusahaan', $pembelian_detail->id_pembelian_detail)
            ->where('kategori', 'perlengkapan')
            ->get();
            
        return response()->json($data = [
            'pembelian_detail' => $pembelian_detail,
            'barang' => $barang,
        ]);
    }

    public function updatedetail(Request $request, $id)
    {
        $pembelian_detail = Pembeliandetail::findOrFail($id);
        $pembelian_detail->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroydetail($id)
    {
        $pembelian_detail = Pembeliandetail::findOrFail($id);
        $pembelian_detail->delete();
        return response()->json(['success' => true]);
    }
}
