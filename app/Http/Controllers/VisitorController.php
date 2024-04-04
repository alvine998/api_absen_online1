<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    public function index()
    {
        $visitor = Visit::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('visitor.index', compact('visitor'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
