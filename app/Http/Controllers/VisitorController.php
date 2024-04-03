<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visitor = Visit::latest()->whereNull('deleted_at')->paginate(5);
        return view('visitor.index', compact('visitor'));
    }
}
