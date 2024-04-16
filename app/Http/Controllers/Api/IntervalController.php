<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Interval;
use Illuminate\Http\Request;

class IntervalController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $limit = $req->get('limit');
        $user_id = $req->get('user_id');

        if ($user_id) {
            $interval = Interval::latest()->whereNull('deleted_at')->where('user_id', '=', $user_id)->paginate(1);
        } else if ($limit) {
            $interval = Interval::latest()->whereNull('deleted_at')->paginate($limit);
        } else {
            $interval = Interval::latest()->whereNull('deleted_at')->paginate(5);
        }

        return new GeneralResource(true, 'List Data Interval', $interval);
    }

    // Get Single Data
    public function show(Interval $interval)
    {
        if ($interval->deleted_at) {
            return response()->json("Interval tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $interval);
    }
}
