<?php

namespace App\Http\Controllers;

use App\Models\Masterdata;
use App\Http\Requests\StoreMasterdataRequest;
use App\Http\Requests\UpdateMasterdataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterdataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $table)
    {
        if ($table == null) {
            abort(404);
        }

        $data = DB::table($table)->get();

        return view('masterdata.view', ['items' => $data, 'table' => $table]);
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
        $table = $request->input('table');
        $data = $request->except('table');

        // timestamp
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // validate na save data
        DB::table($table)->insert($data);

        return response()->json(['success' => true]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $table = $request->input('table');
        $id = $request->input('ids');

        // nentuin primary key
        $primaryKey = 'id'; // Default primary key
        $fallbackPrimaryKey = "id_{$table}"; // cnoth: id_perusahaan buat 'perusahaan'

        // cek idnya id doang ato id_table
        if (Schema::hasColumn($table, $fallbackPrimaryKey)) {
            $primaryKey = $fallbackPrimaryKey;
        }
        // ambil data dari table tertenut
        $data = DB::table($table)->where($primaryKey, $id)->first();

        if (!$data) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // convert data to array sblm diubah ke JSON
        $dataArray = (array) $data;

        // nmbah table ke array
        $dataArray['table'] = $table;

        // return data as JSON
        return response()->json($dataArray);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // Ambil semua data dari request
            $data = $request->all();

            // Ambil nilai 'table'
            $table = $data['table'];
            // apus nilai 'table' dari array
            unset($data['table']);

            // nntuiim primary key berdasarkan nama table
            $primaryKey = 'id';
            $fallbackPrimaryKey = "id_{$table}";

            if (Schema::hasColumn($table, $fallbackPrimaryKey)) {
                $primaryKey = $fallbackPrimaryKey;
            }

            $id = $data[$primaryKey];
            unset($data[$primaryKey]);

            $data['updated_at'] = now();

            DB::table($table)
                ->where($primaryKey, $id)
                ->update($data);

            return response()->json(['success' => true]);

        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masterdata $masterdata)
    {
        //
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('ids');
            $table = $request->input('table');
            
            $primaryKey = 'id';
            $fallbackPrimaryKey = "id_{$table}";
        
            if (Schema::hasColumn($table, $fallbackPrimaryKey)) {
                $primaryKey = $fallbackPrimaryKey;
            }    
            // Verifikasi apakah tabel dan kolom ID ada
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, $primaryKey)) {
                return response()->json(['success' => false, 'message' => 'Invalid table or column'], 400);
            }
    
            // Hapus data berdasarkan ID dan table
            DB::table($table)->where($primaryKey, $id)->delete();
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage()], 500);
        }
    }


    public function getTableColumns($table)
    {
        $columns = Schema::getColumnListing($table);
        $columnData = [];

        foreach ($columns as $column) {
            $type = DB::select(DB::raw("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'"));
            $columnData[] = [
                'name' => $column,
                'type' => $type[0]->Type,
            ];
        }

        return response()->json($columnData);
    }

    public function getData(Request $request)
    {
        $id = $request->input('id');
        $table = $request->input('table');
        $realid = 'id_' . $table;

        // verif table dan column
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, $realid)) {
            return response()->json(['error' => 'Invalid table or column'], 400);
        }

        // Ambil data berdasarkan id dan table
        $data = DB::table($table)->where($realid, $id)->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

}
