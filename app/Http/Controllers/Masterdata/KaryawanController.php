<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Karyawan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
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
            $karyawans = Karyawan::join('perusahaan', 'karyawan.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
                ->select('karyawan.*', 'perusahaan.nama as nama_perusahaan', 'jabatan.nama as jabatan')
                ->get();
            $perusahaan = DB::table('perusahaan')->get();
        } else {
            // Otherwise, fetch only COA data related to the user's id_perusahaan
            $karyawans = Karyawan::where('id_perusahaan', $user->id_perusahaan)
                ->join('perusahaan', 'karyawan.id_perusahaan', '=', 'perusahaan.id_perusahaan')
                ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
                ->select('karyawan.*', 'jabatan.nama as jabatan')
                ->get();
        }

        $jabatan = DB::table('jabatan')->get();

        return view('masterdata.karyawan.index', [
            'table' => 'karyawan',
            'karyawans' => $karyawans,
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
            // user
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'detail' => 'nullable|string',
            // karyawan
            'nama' => 'required|string',
            'id_jabatan' => 'required',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required',            
        ]);

        DB::table('users')->insert([
            'id_perusahaan' => $request->id_perusahaan,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => null,
            'status' => 'aktif',
            'detail' => $request->detail,
        ]);

        // Save data
        Karyawan::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'status' => 'Aktif',
            'id_jabatan' => $request->id_jabatan,
            'id_perusahaan' => $request->id_perusahaan,
            'id_user' => DB::table('users')->latest('id')->first()->id,
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $karyawans = Karyawan::findOrFail($id);

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();
    
        $jabatan = DB::table('jabatan')->get();

        // Pass the data to the edit view
        // return view('masterdata.karyawan.edit', compact('karyawans', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'karyawans' => $karyawans,
            'perusahaan' => $perusahaan,
            'jabatan' => $jabatan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_karyawan)
    {
        // Update the COA record
        Karyawan::where('id_karyawan', $id_karyawan)
            ->update([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'id_jabatan' => $request->id_jabatan,
                'id_perusahaan' => $request->id_perusahaan,
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return response()->json(['success' => true]);
    }
}
