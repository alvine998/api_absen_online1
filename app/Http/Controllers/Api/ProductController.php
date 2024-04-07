<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Get Data
    public function index(Request $req)
    {
        $search = $req->get('search');
        $query = Product::query()->whereNull('deleted_at');
        if ($search) {
            $query->where(function ($q) use ($search){
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%');
            });
        }
        $product = $query->paginate(5);

        if (!$req->query()) {
            $product = Product::latest()->whereNull('deleted_at')->paginate(5);
        }
        return new ProductResource(true, 'List Data Produk', $product);
    }

    // Get Single Data
    public function show(Product $product)
    {
        if ($product->deleted_at) {
            return response()->json("Produk tidak ditemukan!", 404);
        }
        return new ProductResource(true, 'Data Ditemukan', $product);
    }

    // Post Data
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'code' => 'required',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (Product::where('code', $req->code)->exists()) {
            return response()->json("Kode Produk Telah Digunakan!", 404);
        }

        $result = Product::create([
            'code' => $req->code,
            'name' => $req->name,
            'qty' => $req->qty,
            'price' => $req->price,
            'note' => $req->note
        ]);

        return new ProductResource(true, 'Data Produk Berhasil Ditambahkan', $result);
    }

    // Update Data
    public function update(Request $req, Product $product)
    {
        $validator = Validator::make($req->all(), [
            'code' => 'required',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($product->deleted_at) {
            return response()->json("Produk tidak ditemukan!", 404);
        }

        if (Product::where('code', $req->code)->exists()) {
            return response()->json("Kode Produk Telah Digunakan!", 404);
        }

        $product->update([
            'code' => $req->code,
            'name' => $req->name,
            'qty' => $req->qty,
            'price' => $req->price,
            'note' => $req->note
        ]);

        return new ProductResource(true, 'Data Produk Berhasil Diubah!', $product);
    }

    // Delete Data
    public function destroy(Product $product)
    {
        if ($product->deleted_at) {
            return response()->json("Produk tidak ditemukan!", 404);
        }
        $product->deleted_at = now();
        $product->save();
        return new ProductResource(true, 'Data Produk Berhasil Dihapus!', null);
    }
}
