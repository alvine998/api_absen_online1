<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Get Data
    public function index()
    {
        $user = User::latest()->paginate(5);
        return new UserResource(true, 'List Data User', $user);
    }

    // Get Single Data
    public function show(User $user)
    {
        return new UserResource(true, 'Data Ditemukan', $user);
    }

    // Post Data
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (User::where('email', $req->email)->exists()) {
            return response()->json("Email telah digunakan!", 404);
        }

        $hashPassword = Hash::make($req->password);

        $result = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'type' => $req->type,
            'password' => $hashPassword
        ]);

        return new UserResource(true, 'Data Toko Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, User $user)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (User::where('email', $req->email)->exists()) {
            return response()->json("Email telah digunakan!", 404);
        }

        if($req->password){
            $hashPassword = Hash::make($req->password);
        }

        $user->update([
            'name' => $req->name,
            'email' => $req->email,
            'type' => $req->type,
            'password' => $hashPassword
        ]);

        return new UserResource(true, 'Data Pengguna Berhasil Diubah!', $user);
    }


    // Delete Data
    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource(true, 'Data Toko Berhasil Dihapus!', null);
    }
}
