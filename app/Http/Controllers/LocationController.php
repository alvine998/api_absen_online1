<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('location.index', compact('location'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $users = User::latest()->whereNull('deleted_at')->paginate(9999);
        return view('location.create', compact('users'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'user_name' => 'required',
            'latt' => 'required',
            'long' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Location::create([
            'user_id' => $req->user_id,
            'user_name' => $req->user_name,
            'latt' => $req->latt,
            'long' => $req->long,
        ]);

        return redirect()->route('location.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
