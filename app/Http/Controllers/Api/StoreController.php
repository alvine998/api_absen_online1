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
    public function index()
    {
        $store = Store::latest()->paginate(5);
        return new StoreResource(true, 'List Data Store', $store);
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

    // Get Single Data
    public function show(Store $store)
    {
        return new StoreResource(true, 'Data Ditemukan', $store);
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

        if (!User::where('id', $req->user_id)->exists()) {
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
        $store->delete();
        return new StoreResource(true, 'Data Toko Berhasil Dihapus!', null);
    }
}
