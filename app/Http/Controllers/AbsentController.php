<?php

namespace App\Http\Controllers;

use App\Exports\AbsentExport;
use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export_excel()
    {
        return Excel::download(new AbsentExport, 'absensi.xlsx');
    }
}
