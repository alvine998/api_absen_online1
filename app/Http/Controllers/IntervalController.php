<?php

namespace App\Http\Controllers;

use App\Models\Interval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IntervalController extends Controller
{
    public function index()
    {
        $interval = Interval::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('interval.index', compact('interval'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $users = User::latest()->whereNotIn('id', function ($query) {
            $query->select('user_id')->from('intervals')->where('deleted_at', '=', null);
        })->paginate(9999);
        return view('interval.create', compact('users'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'interval' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $existUser = User::where('id', $req->user_id)->whereNull('deleted_at')->first();
        if (!$existUser) {
            return response()->json("Pengguna Tidak Ditemukan!", 404);
        }
        Interval::create([
            'user_id' => $req->user_id,
            'user_name' => $existUser->name,
            'interval' => $req->interval
        ]);

        return redirect()->route('interval.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Interval $interval)
    {
        $users = User::latest()->whereNull('deleted_at')->paginate(999);
        return view("interval.edit", compact('interval', 'users'));
    }

    public function update(Request $req, Interval $interval)
    {
        $this->validate($req, [
            'user_id' => 'required',
            'interval' => 'required'
        ]);

        $existUser = User::where('id', $req->user_id)->whereNull('deleted_at')->first();
        if (!$existUser) {
            return response()->json("Pengguna Tidak Ditemukan!", 404);
        }

        $interval->update([
            'user_id' => $req->user_id,
            'user_name' => $existUser->name,
            'interval' => $req->interval
        ]);
        return redirect()->route('interval.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy(Interval $interval)
    {
        $interval->deleted_at = now();
        $interval->save();
        return redirect()->route('interval.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
