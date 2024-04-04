<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('product.index', compact('product'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        return view('product.create');
    }

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

        if (Product::where('code', $req->code)->whereNull('deleted_at')->exists()) {
            return response()->json("Kode Produk Telah Digunakan!", 404);
        }

        Product::create([
            'code' => $req->code,
            'name' => $req->name,
            'qty' => $req->qty,
            'price' => $req->price,
            'note' => $req->note
        ]);

        return redirect()->route('product.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Product $product)
    {
        return view("product.edit", compact('product'));
    }

    public function update(Request $req, Product $product)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);

        $product->update([
            'code' => $req->code,
            'name' => $req->name,
            'qty' => $req->qty,
            'price' => $req->price,
            'note' => $req->note
        ]);
        return redirect()->route('product.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy(Product $product)
    {
        $product->deleted_at = now();
        $product->save();
        return redirect()->route('product.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
