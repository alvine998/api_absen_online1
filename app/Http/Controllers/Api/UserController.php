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
    public function index(Request $req)
    {
        $query = User::query();
        if ($req->get('search')) {
            $query->latest()->where('name', 'like', '%' . $req->get('search') . '%')->where('email', 'like', '%' . $req->get('search') . '%')->where('nik', 'like', '%' . $req->get('search') . '%');
        }
        if ($req->get('type')) {
            $query->latest()->where('type', '=' ,$req->get('type'));
         }
        $user = $query->latest()->whereNull('deleted_at')->paginate(5);;

        if (!$req->query()) {
            $user = User::latest()->whereNull('deleted_at')->paginate(5);
        }
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
            'user_name' => 'required',
            'user_type' => 'required',
            'user_id' => 'required'
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
            'password' => $hashPassword,
            'created_by' => json_encode([
                'user_name' => $req->user_name,
                'user_type' => $req->user_type,
                'user_id' => $req->user_id,
            ])
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
            'type' => $req->type,
            'created_by' => json_encode([
                'user_name' => $req->user_name,
                'user_type' => $req->user_type,
                'user_id' => $req->user_id,
            ])
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
                return new UserResource(false, 'Gagal Login, Password Salah!', null);
            }
        } else {
            return new UserResource(false, 'Gagal Login!', null);
        }
    }
}
