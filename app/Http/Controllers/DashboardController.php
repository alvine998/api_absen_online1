<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $store = Store::whereNull('deleted_at')->count();
        $user = User::whereNull('deleted_at')->count();
        $absent = Absent::whereNull('deleted_at')->count();
        $visitor = Visit::whereNull('deleted_at')->count();
        $product = Product::whereNull('deleted_at')->count();

        return view('dashboard.index', compact('store', 'user', 'absent', 'visitor', 'product'));
    }
}
