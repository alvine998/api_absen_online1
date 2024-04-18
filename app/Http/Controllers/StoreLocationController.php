<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoreLocationController extends Controller
{
    public function index()
    {
        $storelocation = StoreLocation::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('storelocation.index', compact('storelocation'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $stores = Store::latest()->whereNull('deleted_at')->paginate(999);

        return view('storelocation.create', compact('stores'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required',
            'latt' => 'required',
            'long' => 'required',
            'radius' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $existStore = Store::where('id', $req->store_id)->whereNull('deleted_at')->first();

        if (!$existStore) {
            return response()->json("Toko Tidak Ditemukan!", 404);
        }

        StoreLocation::create([
            'store_id' => $req->store_id,
            'store_name' => $existStore->name,
            'latt' => $req->latt,
            'long' => $req->long,
            'radius' => $req->radius
        ]);

        return redirect()->route('storelocation.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(StoreLocation $storelocation)
    {
        $stores = Store::latest()->whereNull('deleted_at')->paginate(999);
        return view("storelocation.edit", compact('storelocation', 'stores'));
    }

    public function update(Request $req, StoreLocation $storelocation)
    {
        $this->validate($req, [
            'store_id' => 'required',
            'latt' => 'required',
            'long' => 'required',
            'radius' => 'required',
        ]);

        $existStore = Store::where('id', $req->store_id)->whereNull('deleted_at')->first();

        if (!$existStore) {
            return response()->json("Toko Tidak Ditemukan!", 404);
        }

        $storelocation->update([
            'store_id' => $req->store_id,
            'store_name' => $existStore->name,
            'latt' => $req->latt,
            'long' => $req->long,
            'radius' => $req->radius
        ]);
        return redirect()->route('storelocation.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy(StoreLocation $storelocation)
    {
        $storelocation->deleted_at = now();
        $storelocation->save();
        return redirect()->route('storelocation.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
