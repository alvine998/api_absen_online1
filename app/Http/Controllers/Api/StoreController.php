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
    public function index() 
    {
        $store = Store::latest()->paginate(5);
        return new StoreResource(true, 'List Data Store', $store);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        if(!User::where('id', $request->user_id)->exists()){
            return response()->json("Pengguna tidak ditemukan!", 404);
        }

        if(Store::where('code', $request->code)->exists()){
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
}
