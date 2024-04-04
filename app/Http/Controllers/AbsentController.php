<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    public function index()
    {
        $absent = Absent::latest()->whereNull('deleted_at')->paginate(5);
        if (Auth::check()) {
            return view('absent.index', compact('absent'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
