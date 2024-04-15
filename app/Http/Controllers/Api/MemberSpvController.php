<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Memberspv;
use Illuminate\Http\Request;

class MemberSpvController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $limit = $req->get('limit');
        $spv_id = $req->get('spv_id');
        $user_id = $req->get('user_id');

        if ($spv_id && $limit) {
            $memberspv = Memberspv::latest()->whereNull('deleted_at')->where('spv_id', '=', $spv_id)->paginate($limit);
        } else if ($user_id) {
            $memberspv = Memberspv::latest()->whereNull('deleted_at')->where('user_id', '=', $user_id)->paginate(1);
        } else if ($limit) {
            $memberspv = Memberspv::latest()->whereNull('deleted_at')->paginate($limit);
        } else {
            $memberspv = Memberspv::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new GeneralResource(true, 'List Data Member Supervisor', $memberspv);
    }

    // Get Single Data
    public function show(Memberspv $memberspv)
    {
        if ($memberspv->deleted_at) {
            return response()->json("Member Supervisor tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $memberspv);
    }
}
