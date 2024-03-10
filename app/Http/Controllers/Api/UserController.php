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
        $user = User::latest()->whereNull('deleted_at')->paginate(5);
        return new UserResource(true, 'List Data User', $user);
    }

    // Get Single Data
    public function show(User $user)
    {
        if ($user->deleted_at) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }
        return new UserResource(true, 'Data Ditemukan', $user);
    }

    // Post Data
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'nik' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (User::where('email', $req->email)->exists()) {
            return response()->json("Email telah terdaftar!", 404);
        }

        if (User::where('nik', $req->nik)->exists()) {
            return response()->json("NIK telah terdaftar!", 404);
        }

        $hashPassword = Hash::make($req->password);

        $result = User::create([
            'name' => $req->name,
            'nik' => $req->nik,
            'email' => $req->email,
            'type' => $req->type,
            'password' => $hashPassword
        ]);

        return new UserResource(true, 'Data Pengguna Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, User $user)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'nik' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($user->deleted_at) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }

        $user->update([
            'name' => $req->name,
            'nik' => $req->nik,
            'email' => $req->email,
            'type' => $req->type
        ]);

        return new UserResource(true, 'Data Pengguna Berhasil Diubah!', $user);
    }


    // Delete Data
    public function destroy(User $user)
    {
        if ($user->deleted_at) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }
        $user->deleted_at = now();
        $user->save();
        return new UserResource(true, 'Data Pengguna Berhasil Dihapus!', null);
    }

    // Login
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nik' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $existUser = User::where('nik', $req->nik)->whereNull('deleted_at')->first();

        if ($existUser) {
            if (Hash::check($req->password, $existUser['password'])) {
                return new UserResource(true, 'Berhasil Login!', $existUser);
            } else {
                return response()->json("Password Salah!", 404);
            }
        } else {
            return response()->json("NIK tidak ditemukan!", 404);
        }
    }
}
