<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('store.index', compact('store'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $user = User::latest()->where([['deleted_at', '=', null], ['type', '=', 'spg'], ['role', '=', 'supervisor']])->paginate(999);

        return view('store.create', compact('user'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'code' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Store::create([
            'user_id' => $req->user_id || 0,
            'code' => $req->code,
            'name' => $req->name,
            'note1' => $req->note1,
            'note2' => $req->note2
        ]);

        return redirect()->route('store.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Store $store)
    {
        $user = User::latest()->where([['deleted_at', '=', null], ['type', '=', 'spg'], ['role', '=', 'supervisor']])->paginate(999);
        return view("store.edit", compact('store', 'user'));
    }

    public function update(Request $req, Store $store)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
        ]);

        $store->update([
            'user_id' => $req->user_id || 0,
            'code' => $req->code,
            'name' => $req->name,
            'note1' => $req->note1,
            'note2' => $req->note2
        ]);
        return redirect()->route('store.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy(Store $store)
    {
        $store->deleted_at = now();
        $store->save();
        return redirect()->route('store.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
