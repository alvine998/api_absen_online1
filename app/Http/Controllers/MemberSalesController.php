<?php

namespace App\Http\Controllers;

use App\Models\MemberSales;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberSalesController extends Controller
{
    public function index()
    {
        $membersales = MemberSales::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('membersales.index', compact('membersales'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $sales = User::latest()->whereNull('deleted_at')->where([['type', '=', 'sales']])->paginate(9999);
        $stores = Store::latest()->whereNull('deleted_at')->where([['user_id', '=', 0]])->paginate(9999);

        return view('membersales.create', compact('sales', 'stores'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'store_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $store = Store::where('id', $req->store_id)->whereNull('deleted_at')->first();

        foreach (json_decode($req->users) as $data) {
            $existUser = User::where('id', $data->id)->whereNull('deleted_at')->first();
            $existMemberSales = MemberSales::where([['user_id', '=', $data->id], ['store_id', '=', $req->store_id]])->whereNull('deleted_at')->first();
            if (!$existUser) {
                return response()->json("Sales Tidak Ditemukan!", 404);
            }

            if ($existMemberSales) {
                return response()->json("Sales Telah Terdaftar!", 404);
            }

            MemberSales::create([
                'store_id' => $req->store_id,
                'store_name' => $store->name,
                'store_code' => $store->code,
                'user_id' => $data->id,
                'user_name' => $existUser->name
            ]);
        }

        return redirect()->route('membersales.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(MemberSales $membersales)
    {
        return view("membersales.edit", compact('membersales'));
    }

    public function update(Request $req, MemberSales $membersales)
    {
        $this->validate($req, [
            'store_id' => 'required',
            'user_id' => 'required'
        ]);

        $existStore = Store::where('store_id', $req->store_id)->whereNull('deleted_at')->first();
        $existUser = User::where('user_id', $req->user_id)->whereNull('deleted_at')->first();

        if (!$existUser) {
            return response()->json("Sales Tidak Ditemukan!", 404);
        }

        $membersales->update([
            'store_id' => $req->store_id,
            'store_name' => $existStore->name,
            'store_code' => $existStore->code,
            'user_id' => $req->user_id,
            'user_name' => $existUser->name
        ]);
        return redirect()->route('membersales.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy(MemberSales $membersales)
    {
        // $membersales->store_name = $membersales->store_name;
        // $membersales->user_id = $membersales->user_id;
        // $membersales->user_name = $membersales->user_name;
        // $membersales->deleted_at = now();
        // $membersales->save();
        echo ($membersales . 'members');
        return redirect()->route('membersales.index')->with(['success' => 'Data Berhasil Dihapus!' . $membersales->store_name]);
    }
}
