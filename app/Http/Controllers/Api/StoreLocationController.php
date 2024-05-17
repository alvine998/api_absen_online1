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
        $id = $req->get('id');

        $storelocation = StoreLocation::latest()->whereNull('deleted_at');

        if ($store_id) {
            $storelocation->where('store_id', '=', $store_id)->paginate($limit || 5);
        }
        if ($id) {
            $storelocation->where('id', '=', $id)->paginate($limit || 5);
        }
        if ($limit) {
            $storelocation->paginate($limit || 5);
        } 
        $stores = $storelocation->paginate(5);
        if(!$req->query()) {
            $stores = StoreLocation::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new GeneralResource(true, 'List Data Lokasi Toko', $stores);
    }

    // Get Single Data
    public function show(StoreLocation $storelocation)
    {
        if(!$storelocation){
            return response()->json("Lokasi Toko tidak ada!", 404);
        }
        if ($storelocation->deleted_at) {
            return response()->json("Lokasi Toko tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $storelocation);
    }
}
