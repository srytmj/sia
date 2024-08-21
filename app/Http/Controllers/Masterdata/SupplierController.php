<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Supplier;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
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
            $suppliers = Supplier::join('perusahaan', 'supplier.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('supplier.*', 'perusahaan.nama as nama_perusahaan')
                ->get();
            $perusahaan = DB::table('perusahaan')->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $suppliers = Supplier::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'supplier.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->select('supplier.*')
                ->get();
        }

        return view('masterdata.supplier.index', [
            'table' => 'supplier',
            'suppliers' => $suppliers,
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
            'no_telp' => 'required',
            'alamat' => 'required',
            'id_perusahaan' => 'required',
        ]);

        // Save data
        Supplier::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $suppliers = Supplier::findOrFail($id);

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();

        // Pass the data to the edit view
        // return view('masterdata.supplier.edit', compact('suppliers', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'suppliers' => $suppliers,
            'perusahaan' => $perusahaan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_supplier)
    {
        // Save data
        Supplier::where('id_supplier', $id_supplier)
        ->update([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['success' => true]);
    }
}
