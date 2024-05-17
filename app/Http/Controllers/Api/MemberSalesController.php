<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\MemberSales;
use Illuminate\Http\Request;

class MemberSalesController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $limit = $req->get('limit');
        $store_id = $req->get('store_id');
        $user_id = $req->get('user_id');

        if ($store_id && $limit) {
            $membersales = MemberSales::latest()->whereNull('deleted_at')->where('store_id', '=', $store_id)->paginate($limit);
        } else if ($user_id) {
            $membersales = MemberSales::latest()->whereNull('deleted_at')->where('user_id', '=', $user_id)->paginate(999);
        } else if ($limit) {
            $membersales = MemberSales::latest()->whereNull('deleted_at')->paginate($limit);
        } else {
            $membersales = MemberSales::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new GeneralResource(true, 'List Data Member Supervisor', $membersales);
    }

    // Get Single Data
    public function show(MemberSales $membersales)
    {
        if ($membersales->deleted_at) {
            return response()->json("Member Supervisor tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $membersales);
    }
}
