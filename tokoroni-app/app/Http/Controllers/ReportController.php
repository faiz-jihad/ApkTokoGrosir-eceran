<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)))
                  ->whereYear('created_at', date('Y', strtotime($request->month)));
        }

        $transactions = $query->latest()->get();
        $total = $transactions->sum('total');

        return view('reports.index', compact('transactions','total'));
    }
}
