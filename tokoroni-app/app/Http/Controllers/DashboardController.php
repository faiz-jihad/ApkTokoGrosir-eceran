<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // =====================
        // OWNER DASHBOARD
        // =====================
        if ($user->role === 'owner') {

            $totalUsers = User::count();
            $totalProducts = Product::count();
            $totalTransactions = Transaction::count();

            // 🔥 TOTAL PENDAPATAN (BENAR)
            $totalRevenue = DB::table('transaction_items')
                ->select(DB::raw('SUM(qty * price) as total'))
                ->value('total') ?? 0;

            // 🔥 RATA-RATA TRANSAKSI
            $avgTransaction = DB::table('transactions as t')
                ->join('transaction_items as ti', 'ti.transaction_id', '=', 't.id')
                ->select(DB::raw('AVG(ti.qty * ti.price) as avg'))
                ->value('avg') ?? 0;

            // 🔥 TRANSAKSI HARI INI
            $todayTransactions = Transaction::whereDate('created_at', today())->count();

            // 🔥 PRODUK TERLARIS
            $topProducts = DB::table('transaction_items')
                ->join('products', 'products.id', '=', 'transaction_items.product_id')
                ->select(
                    'products.name',
                    DB::raw('SUM(transaction_items.qty) as total_sold'),
                    DB::raw('SUM(transaction_items.qty * transaction_items.price) as revenue')
                )
                ->groupBy('products.name')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();

            // 🔥 TRANSAKSI TERAKHIR
            $recentTransactions = Transaction::latest()->limit(5)->get();

            return view('dashboard.owner', compact(
                'totalUsers',
                'totalProducts',
                'totalTransactions',
                'totalRevenue',
                'avgTransaction',
                'todayTransactions',
                'topProducts',
                'recentTransactions'
            ));
        }

        // =====================
        // KASIR / GUDANG
        // =====================
        return view('dashboard.user');
    }
}
