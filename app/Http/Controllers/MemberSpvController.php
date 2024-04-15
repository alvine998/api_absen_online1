<?php

namespace App\Http\Controllers;

use App\Models\Memberspv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MemberSpvController extends Controller
{
    public function index()
    {
        $supervisor = Memberspv::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('memberspv.index', compact('supervisor'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $spvs = User::latest()->whereNull('deleted_at')->where([['type', '=', 'spg'], ['role', '=', 'supervisor']])->paginate(9999);
        $members = User::latest()->whereNotIn('id', function ($query) {
            $query->select('user_id')->from('memberspvs')->where('deleted_at', '=', null);
        })->where([['type', '=', 'spg'], ['role', '=', null]])->paginate(9999);

        return view('memberspv.create', compact('members', 'spvs'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'spv_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $spv = User::where('id', $req->spv_id)->whereNull('deleted_at')->first();

        foreach (json_decode($req->users) as $data) {
            $existUser = User::where('id', $data->id)->whereNull('deleted_at')->first();

            if (!$existUser) {
                return response()->json("SPG Tidak Ditemukan!", 404);
            }

            Memberspv::create([
                'spv_id' => $req->spv_id,
                'spv_name' => $spv->name,
                'user_id' => $data->id,
                'user_name' => $existUser->name
            ]);
        }

        return redirect()->route('memberspv.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Memberspv $supervisor)
    {
        return view("memberspv.edit", compact('supervisor'));
    }

    public function update(Request $req, Memberspv $supervisor)
    {
        $this->validate($req, [
            'spv_id' => 'required',
            'spv_name' => 'required',
            'user_id' => 'required'
        ]);

        $existSpv = Memberspv::where('spv_id', $req->spv_id)->whereNull('deleted_at')->first();
        $existUser = User::where('user_id', $req->user_id)->whereNull('deleted_at')->first();

        if ($existSpv) {
            return response()->json("Supervisor Sudah Ada!", 404);
        }

        if (!$existUser) {
            return response()->json("SPG Tidak Ditemukan!", 404);
        }

        $supervisor->update([
            'spv_id' => $req->spv_id,
            'spv_name' => $existSpv->name,
            'user_id' => $req->user_id,
            'user_name' => $existUser->name
        ]);
        return redirect()->route('memberspv.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy(Memberspv $memberspv)
    {
        $memberspv->deleted_at = now();
        $memberspv->save();
        return redirect()->route('memberspv.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
