<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Store;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $search = $req->get('search');
        $store_id = $req->get('store_id');
        $user_id = $req->get('user_id');
        $date_start = $req->get('date_start');
        $date_end = $req->get('date_end');
        $limit = $req->get('limit');

        $query = Visit::query()->whereNull('deleted_at');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('store_name', 'like', '%' . $search . '%');
            });
        }
        if ($store_id) {
            $query->latest()->where('store_id', '=', $store_id);
        }
        if ($user_id) {
            $query->latest()->where('user_id', '=', $user_id);
        }
        if ($date_start && $date_end) {
            $dateStart = Carbon::parse($date_start);
            $dateEnd = Carbon::parse($date_end)->endOfDay();

            $query->latest()->whereBetween('created_at', [$dateStart, $dateEnd]);
        }
        $visit = $query->paginate($limit ? $limit : 5);

        if (!$req->query()) {
            $visit = Visit::latest()->whereNull('deleted_at')->paginate(5);
        }
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
            'store_code' => 'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'in_date' => 'required',
            'in_time' => 'required',
            'in_lat' => 'required',
            'in_long' => 'required',
            'user_login' => 'required',
            'user_id' => 'required',
        ]);
        Store::where('id', $req->id)->whereNull('deleted_at')->first();

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $uploadedImages = [];

        $images = $req->file('image');
        if($req->hasFile('image'))
        {
            foreach ($images as $image)
            {
                $uniqueName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/storage', $uniqueName);
                $uploadedImages[] = $uniqueName;
            }
        }

        $result = Visit::create([
            'store_id' => $req->store_id,
            'store_name' => $req->store_name,
            'store_code' => $req->store_code,
            'so_code' => $req->so_code,
            'image' => json_encode($uploadedImages),
            'in_date' => $req->in_date,
            'in_time' => $req->in_time,
            'in_lat' => $req->in_lat,
            'in_long' => $req->in_long,
            'out_date' => $req->out_date,
            'out_time' => $req->out_time,
            'out_lat' => $req->out_lat,
            'out_long' => $req->out_long,
            'user_login' => $req->user_login,
            'user_id' => $req->user_id,
            'note' => $req->note
        ]);

        return new GeneralResource(true, 'Data Pengunjung Berhasil Ditambahkan', $result);
    }

    // Post Order Only
    public function store_order_only(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required',
            'store_name' => 'required',
            'store_code' => 'required',
            'user_login' => 'required',
            'user_id' => 'required',
        ]);
        Store::where('id', $req->id)->whereNull('deleted_at')->first();

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $result = Visit::create([
            'store_id' => $req->store_id,
            'store_name' => $req->store_name,
            'store_code' => $req->store_code,
            'so_code' => 'order_only',
            'image' => 'order_only',
            'in_date' => now(),
            'in_time' => '00:00',
            'in_lat' => 'order_only',
            'in_long' => 'order_only',
            'user_login' => $req->user_login,
            'user_id' => $req->user_id,
            'note' => $req->note
        ]);

        return new GeneralResource(true, 'Data Order Only Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, Visit $visit)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required',
            'store_name' => 'required'
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
                'store_code' => $req->store_code,
                'so_code' => $req->so_code,
                'out_date' => $req->out_date,
                'out_time' => $req->out_time,
                'out_lat' => $req->out_lat,
                'out_long' => $req->out_long,
                'user_login' => $req->user_login,
                'user_id' => $req->user_id,
                'note' => $req->note
            ]);
        } else {

            //update visit without image
            $visit->update([
                'store_id' => $req->store_id,
                'store_name' => $req->store_name,
                'store_code' => $req->store_code,
                'so_code' => $req->so_code,
                'out_date' => $req->out_date,
                'out_time' => $req->out_time,
                'out_lat' => $req->out_lat,
                'out_long' => $req->out_long,
                'user_login' => $req->user_login,
                'user_id' => $req->user_id,
                'note' => $req->note
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
