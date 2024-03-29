<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    // Get Data
    public function index()
    {
        $visit = Visit::latest()->whereNull('deleted_at')->paginate(5);
        return new GeneralResource(true, 'List Data Pengunjung', $visit);
    }

    // Get Single Data
    public function show(Visit $visit)
    {
        if ($visit->deleted_at) {
            return response()->json("Pengunjung tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $visit);
    }

    // Post Data
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required',
            'store_name' => 'required',
            'store_type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'in_date' => 'required',
            'in_time' => 'required',
            'in_lat' => 'required',
            'in_long' => 'required',
            'user_login' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $image = $req->file('image');
        $image->storeAs('public/storage', $image->hashName());

        $result = Visit::create([
            'store_id' => $req->store_id,
            'store_name' => $req->store_name,
            'image' => $image->hashName(),
            'in_date' => $req->in_date,
            'in_time' => $req->in_time,
            'in_lat' => $req->in_lat,
            'in_long' => $req->in_long,
            'out_date' => $req->out_date,
            'out_time' => $req->out_time,
            'out_lat' => $req->out_lat,
            'out_long' => $req->out_long,
            'user_login' => $req->user_login
        ]);

        return new GeneralResource(true, 'Data Pengunjung Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, Visit $visit)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required',
            'store_name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'latt' => 'required',
            'long' => 'required',
            'user_login' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($visit->deleted_at) {
            return response()->json("Absensi tidak ditemukan!", 404);
        }

        //check if image is not empty
        if ($req->hasFile('image')) {

            //upload image
            $image = $req->file('image');
            $image->storeAs('public/storage', $image->hashName());

            //delete old image
            Storage::delete('public/storage/' . $visit->image);

            $visit->update([
                'store_id' => $req->store_id,
                'store_name' => $req->store_name,
                'image' => $image->hashName(),
                'in_date' => $req->in_date,
                'in_time' => $req->in_time,
                'in_lat' => $req->in_lat,
                'in_long' => $req->in_long,
                'out_date' => $req->out_date,
                'out_time' => $req->out_time,
                'out_lat' => $req->out_lat,
                'out_long' => $req->out_long,
                'user_login' => $req->user_login
            ]);
        } else {

            //update visit without image
            $visit->update([
                'store_id' => $req->store_id,
                'store_name' => $req->store_name,
                'in_date' => $req->in_date,
                'in_time' => $req->in_time,
                'in_lat' => $req->in_lat,
                'in_long' => $req->in_long,
                'out_date' => $req->out_date,
                'out_time' => $req->out_time,
                'out_lat' => $req->out_lat,
                'out_long' => $req->out_long,
                'user_login' => $req->user_login
            ]);
        }

        return new GeneralResource(true, 'Data Pengunjung Berhasil Diubah!', $visit);
    }

    // Delete Data
    public function destroy(Visit $visit)
    {
        if ($visit->deleted_at) {
            return response()->json("Pengunjung tidak ditemukan!", 404);
        }
        $visit->deleted_at = now();
        $visit->save();
        Storage::delete('public/storage/' . $visit->image);
        return new GeneralResource(true, 'Data Pengunjung Berhasil Dihapus!', null);
    }
}
