<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * List Produk
     */
    public function index()
    {
        $products = Product::with(['category', 'supplier'])
            ->latest()
            ->paginate(15);

        return view('products.index', compact('products'));
         $products = Product::with('category')
        ->latest()
        ->paginate(request('per_page', 15));

    $categories = Category::where('is_active', true)->get();

    // Stats untuk cards
    $stats = [
        'total' => Product::count(),
        'active' => Product::where('is_active', true)->count(),
        'low_stock' => Product::whereColumn('stock', '<=', 'min_stock')
            ->where('stock', '>', 0)
            ->count(),
        'out_of_stock' => Product::where('stock', '<=', 0)->count(),
    ];

    return view('products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Form Tambah Produk
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Simpan Produk Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:100|unique:products,code',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'cost_price'    => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'min_stock'     => 'nullable|integer|min:0',
            'unit'          => 'nullable|string|max:20',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'barcode'       => 'nullable|string|unique:products,barcode',
            'expiry_date'   => 'nullable|date',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'     => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated['is_active']  = $request->boolean('is_active', true);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form Edit Produk
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update Produk
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:100|unique:products,code,' . $product->id,
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'cost_price'    => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'min_stock'     => 'nullable|integer|min:0',
            'unit'          => 'nullable|string|max:20',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'barcode'       => 'nullable|string|unique:products,barcode,' . $product->id,
            'expiry_date'   => 'nullable|date',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'     => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $validated['updated_by'] = Auth::id();
        $validated['is_active']  = $request->boolean('is_active', true);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Hapus Produk (Soft Delete)
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

}
