<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;

            // hitung total & cek stok
            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if ($item['qty'] > $product->stock) {
                    throw new \Exception("Stok {$product->name} tidak cukup");
                }

                $total += $product->price * $item['qty'];
            }

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total' => $total,
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item['qty']);
            }

            DB::commit();

            return redirect()
                ->route('transactions.history')
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withErrors($e->getMessage());
        }
    }

    public function history()
    {
        $transactions = Transaction::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('transactions.history', compact('transactions'));
    }
}
