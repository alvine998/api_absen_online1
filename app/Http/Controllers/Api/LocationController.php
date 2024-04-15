<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $limit = $req->get('limit');
        $user_id = $req->get('user_id');
        if ($user_id && $limit) {
            $location = Location::latest()->whereNull('deleted_at')->where('user_id', '=', $user_id)->paginate($limit);
        } else if ($limit) {
            $location = Location::latest()->whereNull('deleted_at')->paginate($limit);
        } else {
            $location = Location::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new GeneralResource(true, 'List Data Lokasi', $location);
    }

    // Get Single Data
    public function show(Location $location)
    {
        if ($location->deleted_at) {
            return response()->json("Lokasi tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $location);
    }

     // Post Data
     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'user_id' => 'required',
             'latt' => 'required',
             'long' => 'required',
         ]);
 
         if ($validator->fails()) {
             return response()->json($validator->errors(), 400);
         }

         $existUser = User::where('id', $request->user_id)->first(); 
         if (!$existUser) {
             return response()->json("Pengguna tidak ditemukan!", 404);
         }
 
         $result = Location::create([
             'user_id' => $request->user_id,
             'user_name' => $existUser->name,
             'latt' => $request->latt,
             'long' => $request->long
         ]);
 
         return new GeneralResource(true, 'Data Lokasi Berhasil Ditambahkan', $result);
     }
}
