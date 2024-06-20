<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $stock = Stock::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('stock.index', compact('stock'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function create()
    {
        $product = Product::latest()->where([['deleted_at', '=', null]])->paginate(999);

        return view('store.create', compact('product'));
    }

    public function update(Request $req, Stock $stock)
    {
        $stock->update([
            'ref_no' => $req->ref_no
        ]);
        return redirect()->route('stock.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
