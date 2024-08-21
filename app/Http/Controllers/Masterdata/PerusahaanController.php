<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve data from the database
        $items = Perusahaan::all(); // You can also use pagination if needed

        // Pass data to the view
        return view('masterdata.perusahaan.index', [
            'items' => $items,
            'table' => 'perusahaan'
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
    public function store(StorePerusahaanRequest $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_perusahaan' => 'required',
        ]);

        Perusahaan::create($request->all());

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $perusahaan = Perusahaan::find($id);
        return response()->json($perusahaan);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());

        return response()->json(['success' => 'Data updated successfully']);
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();
        return response()->json(['success' => true]);
    }
}
