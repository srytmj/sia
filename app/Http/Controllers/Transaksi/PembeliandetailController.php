<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Transaksi\Pembeliandetail;
use App\Models\Transaksi\Pembelian;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePembeliandetailRequest;
use App\Http\Requests\UpdatePembeliandetailRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembeliandetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_pembelian)
    {
        $user = auth()->user(); // Get the currently logged-in user

        $pembelian = DB::table('pembelian')
            ->where('id_pembelian', $id_pembelian)
            ->join('supplier', 'pembelian.id_supplier', '=', 'supplier.id_supplier')
            ->join('perusahaan', 'pembelian.id_perusahaan', '=', 'perusahaan.id_perusahaan')
            ->select('pembelian.*', 'supplier.nama as nama_supplier', 'perusahaan.nama as nama_perusahaan')
            ->first();

        $pembeliandetails = DB::table('pembelian_detail')
            ->join('pembelian', 'pembelian_detail.id_pembelian', '=', 'pembelian.id_pembelian')
            ->join('barang', 'pembelian_detail.id_barang', '=', 'barang.id_barang')
            ->select('pembelian_detail.*', 'barang.nama', 'barang.satuan')
            ->where('pembelian.id_pembelian', $id_pembelian)
            ->get();

        if ($user->id_perusahaan == 1) {
            $perusahaans = DB::table('perusahaan')
                ->where('perusahaan.id_perusahaan', '!=', 1)
                ->whereIn('perusahaan.id_perusahaan', function($query) {
                    $query->select('id_perusahaan')
                          ->from('supplier');
                })
                ->get();
            $suppliers = DB::table('supplier')->get();

        } else {
            $suppliers = DB::table('supplier')
            ->where('id_perusahaan', $pembelian->id_perusahaan)
            ->get();        
        }

        $barangs = DB::table('barang')
            ->where('id_perusahaan', $pembelian->id_perusahaan)
            // ->where('kategori', 'perlengkapan')
            ->get();

        $payment_option = 'pending';

        $total = DB::table('pembelian_detail')
            ->where('id_pembelian', $id_pembelian)
            ->sum('subtotal');

        return view('transaksi.pembelian.detail.index', compact('pembeliandetails', 'id_pembelian', 'pembelian', 'perusahaans', 'suppliers', 'barangs', 'payment_option', 'total'));
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
    public function store(StorePembeliandetailRequest $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'id_pembelian' => 'required',
            'kuantitas' => 'required',
        ]);

        // Pembeliandetail::create($request->all());

        // Pembeliandetail::create($request->all());
        Pembeliandetail::create([
            'id_pembelian' => $request->id_pembelian,
            'id_barang' => $request->id_barang,
            'kuantitas' => $request->kuantitas,
            'harga' => $request->harga,
        ]);

        return response()->json(['success' => 'Data saved successfully.']);
        // return redirect()->route('pembeliandetail.index')->with('success', 'Pembeliandetail created successfully.');
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
        $user = auth()->user(); // Get the currently logged-in user

        $pembeliandetail = Pembeliandetail::find($id);

        if (!$pembeliandetail) {
            return redirect()->route('pembeliandetail.index')->with('error', 'Role not found');
        }
        // Check if the user's id_perusahaan is 1
        if ($user->id_perusahaan == 1) {
            $perusahaans = DB::table('perusahaan')
                ->where('perusahaan.id_perusahaan', '!=', 1)
                ->get();
        } else {
            // 
        }

        $selectedPerusahaan = $pembeliandetail->id_perusahaan; // Assuming 'id_perusahaan' is related to 'jasa'

        $pembelian_detail = DB::table('pembelian_detail')
            ->join('pembeliandetail', 'pembelian_detail.id_pembelian', '=', 'pembeliandetail.id_pembelian')
            ->join('barang', 'pembelian_detail.id_barang', '=', 'barang.id_barang')
            ->select('pembelian_detail.id_pembelian_detail', 'pembelian_detail.id_barang', 'barang.nama', 'barang.satuan', 'pembelian_detail.kuantitas', 'pembelian_detail.harga', 'pembelian_detail.subtotal')
            ->where('pembeliandetail.id_pembelian', $id)
            ->get();

        $barang = DB::table('barang')
            ->where('id_perusahaan', $pembeliandetail->id_perusahaan)
            ->where('kategori', 'perlengkapan')
            ->get();
        
        $suppliers = DB::table('supplier')
            ->where('id_perusahaan', $pembeliandetail->id_perusahaan)
            ->get();

        return view('transaksi.pembeliandetail.edit', compact('pembeliandetail', 'pembelian_detail', 'barang', 'perusahaans', 'suppliers', 'selectedPerusahaan'));
        // return response()->json([$pembeliandetail, $pembelian_detail]);
    }  
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pembeliandetail = Pembeliandetail::findOrFail($id);
        $pembeliandetail->update($request->all());

        return redirect()->route('pembeliandetail.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pembeliandetail = Pembeliandetail::findOrFail($id);
        $pembeliandetail->delete();
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

    public function save(Request $request)
    {
        // log
        // bikin cara gimana biar bisa input jurnal
        // based by jenis barang
        // kalo misal barang yang dibeli itu perlengkapan ya perlengkapan pada kas
        // kalo persediaan ya persediaan pada kas
        // 
        // 
        // 
        // 
        // 
        //       

        $request->validate([
            // 'dibayar_dimuka' => 'required',
            'id_supplier' => 'required',
            'id_perusahaan' => 'required',
            'id_pembelian' => 'required',
            'payment_option' => 'required',
            'total' => 'required',
        ]);

        // Retrieve the form inputs
        $paymentOption = $request->input('payment_option'); // e.g., 'tunai' or 'kredit'
        $dibayarDimuka = $request->input('dibayar_dimuka'); // Default to 0 if not provided
        
        $total = $request->input('total'); // Total amount

        // Initialize kredit and status variables
        $kredit = 0;
        $status = 'lunas'; // Default status

        // Calculate kredit and update status based on payment_option
        if ($paymentOption === 'kredit') {
            $kredit = $total - $dibayarDimuka;
            $status = $kredit > 0 ? 'belum lunas' : 'lunas'; // Update status based on kredit amount
            $tanggal_pelunasan = null;
        } else if ($paymentOption === 'tunai') {
            $dibayarDimuka = $total;
            $status = 'lunas';
            $tanggal_pelunasan = now();
        }

        // Fetch the Pembelian model instance and update it
        $pembelian = Pembelian::find($request->id_pembelian);

        $pembelian->update([
            'tunai' => $dibayarDimuka,
            'kredit' => $kredit,
            'id_supplier' => $request->id_supplier,
            'id_perusahaan' => $request->id_perusahaan,
            'jenis_transaksi' => $request->payment_option,
            'status' => $status,
            'tanggal_pelunasan' => $tanggal_pelunasan,
        ]);

        if ($paymentOption === 'tunai') {
            // Record to jurnal
            DB::table('jurnal')->insert([
                'id_transaksi' => $request->id_pembelian,
                'jenis_transaksi' => 'pembelian',
                'kode_akun' => Jurnal::coa('modal pemilik'), // ini ganti jadi pendapatan
                'tanggal_jurnal' => now(),
                'posisi_d_c' => 'd',
                'nominal' => $dibayarDimuka,
                'kelompok' => '3',
                'id_perusahaan' => $request->id_perusahaan, // can be changed in production
            ]);

            DB::table('jurnal')->insert([
                'id_transaksi' => $request->id_pembelian,
                'jenis_transaksi' => 'pembelian',
                'kode_akun' => Jurnal::coa('kas'), // ini ganti jadi pendapatan
                'tanggal_jurnal' => now(),
                'posisi_d_c' => 'd',
                'nominal' => $dibayarDimuka,
                'kelompok' => '1',
                'id_perusahaan' => $request->id_perusahaan, // can be changed in production
            ]);
        } else {
            DB::table('jurnal')->insert([
                'id_transaksi' => $request->id_pembelian,
                'jenis_transaksi' => 'pembelian',
                'kode_akun' => Jurnal::coa('modal pemilik'), // ini ganti jadi pendapatan
                'tanggal_jurnal' => now(),
                'posisi_d_c' => 'd',
                'nominal' => $dibayarDimuka,
                'kelompok' => '3',
                'id_perusahaan' => $request->id_perusahaan, // can be changed in production
            ]);

            DB::table('jurnal')->insert([
                'id_transaksi' => $request->id_pembelian,
                'jenis_transaksi' => 'pembelian',
                'kode_akun' => Jurnal::coa('kas'), // ini ganti jadi pendapatan
                'tanggal_jurnal' => now(),
                'posisi_d_c' => 'd',
                'nominal' => $dibayarDimuka,
                'kelompok' => '1',
                'id_perusahaan' => $request->id_perusahaan, // can be changed in production
            ]);
        }

    
        return response()->json(['success' => 'Data saved successfully.']);
    }
    
}
