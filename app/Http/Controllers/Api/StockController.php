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
            'ref_no' => $request->ref_no,
            'total_price' => $request->total_price,
            'total_qty' => $request->total_qty
        ]);

        return new GeneralResource(true, 'Data Stok Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, Stock $stock)
    {
        $validator = Validator::make($req->all(), [
            'product_id' => 'required',
            'qty' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($stock->deleted_at) {
            return response()->json("Stok tidak ditemukan!", 404);
        }

        $existProduct = Product::where('id', $stock->product_id)->first();
        if (!$existProduct) {
            return response()->json("Produk tidak ditemukan!", 404);
        }

        $result = $stock->update([
            'product_id' => $req->product_id,
            'product_name' => $existProduct->name,
            'product_price' => $existProduct->price,
            'qty' => $req->qty
        ]);
        if ($result) {
            $existProduct->qty = $existProduct->qty + ($req->qty - $stock->qty);
            echo $existProduct->qty . "Masuk sini";
            $existProduct->save();
        }

        return new GeneralResource(true, 'Data Stok Berhasil Diubah!', $stock);
    }

    // Delete Data
    public function destroy(Stock $stock)
    {
        if ($stock->deleted_at) {
            return response()->json("Stok tidak ditemukan!", 404);
        }
        $existProduct = Product::where('id', $stock->product_id)->first();
        if (!$existProduct) {
            return response()->json("Produk tidak ditemukan!", 404);
        }
        $existProduct->qty = $existProduct->qty - $stock->qty;
        $stock->deleted_at = now();
        $existProduct->save();
        $stock->save();
        return new GeneralResource(true, 'Data Stok Berhasil Dihapus!', null);
    }
}
