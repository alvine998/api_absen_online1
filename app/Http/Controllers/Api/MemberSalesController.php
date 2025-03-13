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
        $limit = $req->get('limit', 5); // Default limit to 5
        $store_id = $req->get('store_id');
        $user_id = $req->get('user_id');
        $search = $req->get('search');

        // Start query builder
        $query = MemberSales::query()->whereNull('deleted_at');

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('store_name', 'like', '%' . $search . '%')
                    ->orWhere('store_code', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%');
            });
        }

        // Apply store_id filter
        if ($store_id) {
            $query->where('store_id', $store_id);
        }

        // Apply user_id filter
        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        // Get paginated results
        $membersales = $query->latest()->paginate($limit);

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
