<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $search = $req->get('search');

        $query = Stock::query()->whereNull('deleted_at');
        if ($req->get('user_id')) {
            $query->latest()->where('user_id', $req->get('user_id'));
        }
        if ($req->get('visit_id')) {
            $query->latest()->where('visit_id', $req->get('visit_id'));
        }
        if ($req->get('store_id')) {
            $query->latest()->where('store_id', $req->get('store_id'));
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ref_no', 'like', '%' . $search . '%');
            });
        }
        $stock = $query->paginate(5);

        if (!$req->query()) {
            $stock = Stock::latest()->whereNull('deleted_at')->paginate(5);
        }
        return new GeneralResource(true, 'List Data Stok', $stock);
    }

    // Get Single Data
    public function show(Stock $stock)
    {
        if ($stock->deleted_at) {
            return response()->json("Stok tidak ditemukan!", 404);
        }
        return new GeneralResource(true, 'Data Ditemukan', $stock);
    }

    // Post Data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required',
            'total_qty' => 'required',
            'total_price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $result = Stock::create([
            'products' => $request->products,
            'visit_id' => $request->visit_id,
            'user_id' => $request->user_id,
            'user_name' => $request->user_name,
            'store_id' => $request->store_id,
            'store_name' => $request->store_name,
            'store_code' => $request->store_code,
            'ref_no' => $request->ref_no,
            'total_price' => $request->total_price,
            'total_qty' => $request->total_qty
        ]);

        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->qty += $item['qty'];
                $product->save();
            }
        }

        return new GeneralResource(true, 'Data Stok Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, Stock $stock)
    {

        if ($stock->deleted_at) {
            return response()->json("Stok tidak ditemukan!", 404);
        }

        foreach ($stock->products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->qty -= $item['qty'];
                $product->save();
            }
        }

        $result = $stock->update([
            'visit_id' => $req->visit_id,
            'user_id' => $req->user_id,
            'user_name' => $req->user_name,
            'store_id' => $req->store_id,
            'store_name' => $req->store_name,
            'store_code' => $req->store_code,
            'products' => $req->products,
            'ref_no' => $req->ref_no,
            'total_price' => $req->total_price,
            'total_qty' => $req->total_qty
        ]);

        foreach ($req->products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->qty += $item['qty'];
                $product->save();
            }
        }
        // if ($result) {
        //     $existProduct->qty = $existProduct->qty + ($req->qty - $stock->qty);
        //     echo $existProduct->qty . "Masuk sini";
        //     $existProduct->save();
        // }

        return new GeneralResource(true, 'Data Stok Berhasil Diubah!', $stock);
    }

    // Delete Data
    public function destroy(Stock $stock)
    {
        if ($stock->deleted_at) {
            return response()->json("Stok tidak ditemukan!", 404);
        }
        foreach ($stock->products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->qty -= $item['qty'];
                $product->save();
            }
        }
        $stock->deleted_at = now();
        $stock->save();
        return new GeneralResource(true, 'Data Stok Berhasil Dihapus!', null);
    }
}
