<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\StoreLocation;
use Illuminate\Http\Request;

class StoreLocationController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $limit = $req->get('limit');
        $store_id = $req->get('store_id');

        if ($store_id && $limit) {
            $storelocation = StoreLocation::latest()->whereNull('deleted_at')->where('store_id', '=', $store_id)->paginate($limit);
        } else if ($limit) {
            $storelocation = StoreLocation::latest()->whereNull('deleted_at')->paginate($limit);
        } else {
            $storelocation = StoreLocation::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new GeneralResource(true, 'List Data Lokasi Toko', $storelocation);
    }

    // Get Single Data
    public function show(StoreLocation $storelocation)
    {
        if ($storelocation->deleted_at) {
            return response()->json("Lokasi Toko tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $storelocation);
    }
}
