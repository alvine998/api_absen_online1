<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $search = $req->get('search');
        $query = Store::query()->whereNull('deleted_at');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
        if ($req->get('user_id')) {
            $query->latest()->where('user_id', $req->get('user_id'));
        }
        if ($req->get('type') == "sales") {
            $query->latest()->where('user_id', 0);
        }
        if ($req->get('type') == "spg") {
            $query->latest()->where('user_id', '>', 0);
        }
        $store = $query->paginate($req->get('limit') !== 0 ? $req->get('limit') : 5);

        if (!$req->query()) {
            $store = Store::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new StoreResource(true, 'List Data Toko', $store);
    }

    // Get Single Data
    public function show(Store $store)
    {
        if ($store->deleted_at) {
            return response()->json("Toko tidak ditemukan!", 404);
        }
        return new StoreResource(true, 'Data Ditemukan', $store);
    }

    // Post Data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!User::where('id', $request->user_id)->exists()) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }

        if (Store::where('code', $request->code)->exists()) {
            return response()->json("Kode Toko Telah Digunakan!", 404);
        }

        $result = Store::create([
            'user_id' => $request->user_id,
            'code' => $request->code,
            'name' => $request->name,
            'note1' => $request->note1,
            'note2' => $request->note2
        ]);

        return new StoreResource(true, 'Data Toko Berhasil Ditambahkan', $result);
    }


    // Update Data
    public function update(Request $req, Store $store)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'code' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($store->deleted_at) {
            return response()->json("Toko tidak ditemukan!", 404);
        }

        if (!User::where('id', $req->user_id)->whereNull('deleted_at')->exists()) {
            return response()->json("Pengguna tidak ditemukan!", 404);
        }

        if (Store::where('code', $req->code)->exists()) {
            return response()->json("Kode Toko Telah Digunakan!", 404);
        }

        $store->update([
            'user_id' => $req->user_id,
            'code' => $req->code,
            'name' => $req->name,
            'note1' => $req->note1,
            'note2' => $req->note2
        ]);

        return new StoreResource(true, 'Data Toko Berhasil Diubah!', $store);
    }

    // Delete Data
    public function destroy(Store $store)
    {
        if ($store->deleted_at) {
            return response()->json("Toko tidak ditemukan!", 404);
        }
        $store->deleted_at = now();
        $store->save();
        return new StoreResource(true, 'Data Toko Berhasil Dihapus!', null);
    }
}
