<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AbsentController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $search = $req->get('search');
        $store_id = $req->get('store_id');
        $type = $req->get('type');
        $date_start = $req->get('date_start');
        $date_end = $req->get('date_end');

        $query = Absent::query()->whereNull('deleted_at');
        if ($search) {
            $query->where(function ($q) use ($search){
                $q->where('store_name', 'like', '%' . $search . '%');
            });
        }
        if ($store_id) {
            $query->latest()->where('store_id', '=', $store_id);
        }
        if ($type) {
            $query->latest()->where('type', '=', $type);
        }
        if($date_start && $date_end){
            $dateStart = Carbon::parse($date_start);
            $dateEnd = Carbon::parse($date_end)->endOfDay();

            $query->latest()->whereBetween('date', [$dateStart, $dateEnd]);
        }
        $absent = $query->paginate(5);

        if (!$req->query()) {
            $absent = Absent::latest()->whereNull('deleted_at')->paginate(5);
        }
        return new GeneralResource(true, 'List Data Absensi', $absent);
    }

    // Get Single Data
    public function show(Absent $absent)
    {
        if ($absent->deleted_at) {
            return response()->json("Absensi tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $absent);
    }

    // Post Data
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required',
            'store_name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'latt' => 'required',
            'long' => 'required',
            'user_login' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $image = $req->file('image');
        $image->storeAs('public', $image->hashName());

        $result = Absent::create([
            'store_id' => $req->store_id,
            'store_name' => $req->store_name,
            'date' => $req->date,
            'time' => $req->time,
            'type' => $req->type,
            'image' => $image->hashName(),
            'latt' => $req->latt,
            'long' => $req->long,
            'user_login' => $req->user_login
        ]);

        return new GeneralResource(true, 'Data Absensi Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, Absent $absent)
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

        if ($absent->deleted_at) {
            return response()->json("Absensi tidak ditemukan!", 404);
        }

        //check if image is not empty
        if ($req->hasFile('image')) {

            //upload image
            $image = $req->file('image');
            $image->storeAs('public/storage', $image->hashName());

            //delete old image
            Storage::delete('public/storage/' . $absent->image);

            $absent->update([
                'store_id' => $req->store_id,
                'store_name' => $req->store_name,
                'date' => $req->date,
                'time' => $req->time,
                'type' => $req->type,
                'image' => $image->hashName(),
                'latt' => $req->latt,
                'long' => $req->long,
                'user_login' => $req->user_login
            ]);
        } else {

            //update absent without image
            $absent->update([
                'store_id' => $req->store_id,
                'store_name' => $req->store_name,
                'date' => $req->date,
                'time' => $req->time,
                'type' => $req->type,
                'latt' => $req->latt,
                'long' => $req->long,
                'user_login' => $req->user_login
            ]);
        }

        return new GeneralResource(true, 'Data Absensi Berhasil Diubah!', $absent);
    }

    // Delete Data
    public function destroy(Absent $absent)
    {
        if ($absent->deleted_at) {
            return response()->json("Absensi tidak ditemukan!", 404);
        }
        $absent->deleted_at = now();
        $absent->save();
        Storage::delete('public/storage/'.$absent->image);  
        return new GeneralResource(true, 'Data Absensi Berhasil Dihapus!', null);
    }
}
