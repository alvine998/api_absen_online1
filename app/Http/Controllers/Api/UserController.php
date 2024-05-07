<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $search = $req->get('search');
        $query = User::query()->whereNull('deleted_at');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }
        if ($req->get('type')) {
            $query->latest()->where('type', '=', $req->get('type'));
        }
        if ($req->get('isnotspv') == '1') {
            $query->latest()->where('role', '=', null);
        }
        if ($req->get('isnotspv') == '0') {
            $query->latest()->where('role', '=', 'supervisor');
        }
        $user = $query->paginate(5);

        if (!$req->query()) {
            $user = User::latest()->whereNull('deleted_at')->paginate(5);
        }
        return new UserResource(true, 'List Data User', $user, null);
    }

    // Get Single Data
    public function show(User $user)
    {
        if ($user->deleted_at) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }
        return new UserResource(true, 'Data Ditemukan', $user, null);
    }

    // Post Data
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'nik' => 'required',
            'password' => 'required|min:8',
            'user_name' => 'required',
            'user_type' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (User::where('nik', $req->nik)->exists()) {
            return response()->json("NIK telah terdaftar!", 404);
        }

        $hashPassword = Hash::make($req->password);
        if ($req->file('photo')) {
            $photo = $req->file('photo');
            $photo->storeAs('public/storage', $photo->hashName());

            $result = User::create([
                'name' => $req->name,
                'nik' => $req->nik,
                'notes' => $req->notes,
                'type' => $req->type,
                'role' => $req->role,
                'photo' => $photo->hashName(),
                'password' => $hashPassword,
                'created_by' => json_encode([
                    'user_name' => $req->user_name,
                    'user_type' => $req->user_type,
                    'user_id' => $req->user_id,
                ])
            ]);
        } else {
            $result = User::create([
                'name' => $req->name,
                'nik' => $req->nik,
                'notes' => $req->notes,
                'type' => $req->type,
                'role' => $req->role,
                'password' => $hashPassword,
                'created_by' => json_encode([
                    'user_name' => $req->user_name,
                    'user_type' => $req->user_type,
                    'user_id' => $req->user_id,
                ])
            ]);
        }

        return new UserResource(true, 'Data Pengguna Berhasil Ditambahkan', $result, null);
    }

    // Update Data
    public function update(Request $req, User $user)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'nik' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($user->deleted_at) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }

        if ($req->password) {
            $hashPassword = Hash::make($req->password);

            $user->update([
                'name' => $req->name,
                'nik' => $req->nik,
                'notes' => $req->notes,
                'type' => $req->type,
                'role' => $req->role,
                'password' => $hashPassword,
                'created_by' => json_encode([
                    'user_name' => $req->user_name,
                    'user_type' => $req->user_type,
                    'user_id' => $req->user_id,
                ])
            ]);
        } else if ($req->file('photo')) {
            $photo = $req->file('photo');
            $photo->storeAs('public/storage', $photo->hashName());

            $user->update([
                'name' => $req->name,
                'nik' => $req->nik,
                'notes' => $req->notes,
                'type' => $req->type,
                'role' => $req->role,
                'photo' => $photo->hashName(),
                'created_by' => json_encode([
                    'user_name' => $req->user_name,
                    'user_type' => $req->user_type,
                    'user_id' => $req->user_id,
                ])
            ]);
        } else {
            $user->update([
                'name' => $req->name,
                'nik' => $req->nik,
                'notes' => $req->notes,
                'type' => $req->type,
                'role' => $req->role,
                'created_by' => json_encode([
                    'user_name' => $req->user_name,
                    'user_type' => $req->user_type,
                    'user_id' => $req->user_id,
                ])
            ]);
        }

        return new UserResource(true, 'Data Pengguna Berhasil Diubah!', $user, null);
    }


    // Delete Data
    public function destroy(User $user)
    {
        if ($user->deleted_at) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }
        $user->deleted_at = now();
        $user->save();
        return new UserResource(true, 'Data Pengguna Berhasil Dihapus!', null, null);
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

        $existUser = User::where('nik', '=', $req->nik)->where('deleted_at', '=', null)->first();

        if ($existUser) {
            $existStore = Store::where('user_id', '=', $existUser->id)->whereNull('deleted_at')->first();
            // if (!$existStore) {
            //     return response()->json(["success" => false, "message" => "Toko tidak ditemukan!"], 404);
            // }
            if (Hash::check($req->password, $existUser['password'])) {
                if ($existUser['type'] == "spg") {
                    if ($existUser['role'] == "supervisor") {
                        return new UserResource(true, 'Berhasil Login!', $existUser, $existStore);
                    } else {
                        return new UserResource(false, 'Anda bukan supervisor!', null, null);
                    }
                } else {
                    return new UserResource(true, 'Berhasil Login!', $existUser, $existStore);
                }
            } else {
                return new UserResource(false, 'Gagal Login, Password Salah!', null, null);
            }
        } else {
            return new UserResource(false, 'Gagal Login!', null, null);
        }
    }
}
