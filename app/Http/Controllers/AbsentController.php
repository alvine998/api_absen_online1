<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use Illuminate\Http\Request;

class AbsentController extends Controller
{
    public function index()
    {
        $absent = Absent::latest()->whereNull('deleted_at')->paginate(5);
        return view('absent.index', compact('absent'));
    }
}
