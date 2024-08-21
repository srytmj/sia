<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Users;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve data from the database
        $items = Users::all(); // You can also use pagination if needed
        $usrs = DB::table('users')
        ->leftJoin('user_role', 'users.id_role', '=', 'user_role.id_role')
        ->join('perusahaan', 'users.id_perusahaan', '=', 'perusahaan.id_perusahaan')
        ->select('users.*', 'user_role.nama_role', 'perusahaan.nama')
        ->get();
        $perusahaan = DB::table('perusahaan')->get();
        $roles = DB::table('user_role')->get();

        // Pass data to the view
        return view('masterdata.users.index', [
            'items' => $usrs,
            'table' => 'users',
            'perusahaan' => $perusahaan,
            'roles' => $roles
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
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'id_role' => 'required|exists:user_role,id_role',
            'status' => 'required|in:aktif,nonaktif',
            'detail' => 'nullable|string',
        ]);

        // Save the new COA
        users::create([
            'id_perusahaan' => $request->id_perusahaan,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
            'status' => $request->status,
            'detail' => $request->detail,
        ]);

        // // Validate the input data
        // $validatedData = $request->validate([
        //     'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        //     'username' => 'required|string|max:255|unique:users,username',
        //     'email' => 'required|string|email|max:255|unique:users,email',
        //     'password' => 'required|string|min:8|confirmed',
        //     'id_role' => 'required|exists:user_role,id_role',
        //     'status' => 'required|in:aktif,nonaktif',
        //     'detail' => 'nullable|string',
        // ]);

        // Return a success response or redirect
        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the user, perusahaan, and roles data
        $user = DB::table('users')->where('id', $id)->first();
        $perusahaan = DB::table('perusahaan')->get();
        $roles = DB::table('user_role')->get();

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('masterdata.users.edit', compact('user', 'perusahaan', 'roles'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:user_role,id_role',
            'status' => 'required|in:aktif,nonaktif',
            'detail' => 'nullable|string',
        ]);

        // Update the user data
        $updateData = [
            'id_perusahaan' => $validatedData['id_perusahaan'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'role_id' => $validatedData['role_id'],
            'status' => $validatedData['status'],
            'detail' => $validatedData['detail'],
            'updated_at' => now(),
        ];

        // If password is provided, hash and update it
        if ($validatedData['password']) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        DB::table('users')->where('id', $id)->update($updateData);

        // Return a success response or redirect
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $users = Users::findOrFail($id);
        $users->delete();
        return response()->json(['success' => true]);
    }
}
