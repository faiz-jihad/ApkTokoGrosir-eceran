@extends('layouts.app')

@section('title', 'Transaksi Kasir')
@section('subtitle', 'Sistem Point of Sale - Input penjualan baru')

@section('content')
<div class="pos-container">
    <!-- Left Column: Product Catalog -->
    <div class="pos-products">
        <div class="products-header">
            <h3 class="section-title">
                <i class="fas fa-boxes"></i>
                Katalog Produk
            </h3>
            <div class="header-actions">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchProduct" placeholder="Cari produk..." class="pos-search" autocomplete="off">
                    <button class="clear-search" id="clearSearch">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="products-count">
                    <span id="productsCount">{{ $products->count() }}</span> produk tersedia
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="category-filter" id="categoryFilter">
            <button class="category-btn active" data-category="all">
                <i class="fas fa-layer-group"></i> Semua
            </button>
            {{-- @foreach($categories as $category)
            <button class="category-btn" data-category="{{ $category->id }}">
                <i class="fas fa-tag"></i> {{ $category->name }}
            </button>
            @endforeach --}}
        </div>

        <!-- Products Grid -->
        <div class="products-grid" id="productsGrid">
            @foreach($products as $product)
            <div class="product-card"
                 data-id="{{ $product->id }}"
                 data-name="{{ strtolower($product->name) }}"
                 data-price="{{ $product->price }}"
                 data-stock="{{ $product->stock }}"
                 data-category="{{ $product->category_id ?? '' }}"
                 data-code="{{ $product->code ?? '' }}">
                <div class="product-badge">
                    @if($product->stock > 20)
                    <span class="stock-badge in-stock">
                        <i class="fas fa-check-circle"></i> Stok: {{ $product->stock }}
                    </span>
                    @elseif($product->stock > 0)
                    <span class="stock-badge low-stock">
                        <i class="fas fa-exclamation-triangle"></i> Stok: {{ $product->stock }}
                    </span>
                    @else
                    <span class="stock-badge out-stock">
                        <i class="fas fa-times-circle"></i> Habis
                    </span>
                    @endif
                </div>

                <div class="product-info">
                    <div class="product-code">{{ $product->code ?? 'PRD-' . $product->id }}</div>
                    <h4 class="product-name">{{ $product->name }}</h4>
                    <div class="product-category">
                        <i class="fas fa-tag"></i>
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                    </div>
                    <div class="product-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <button class="add-to-cart-btn" onclick="addProductToCart(this)">
                    <i class="fas fa-plus"></i>
                    <span>Tambah</span>
                </button>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($products->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h4>Tidak Ada Produk</h4>
            <p>Belum ada produk yang tersedia untuk dijual</p>
            @if(auth()->user()->role === 'owner' || auth()->user()->role === 'gudang')
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
            @endif
        </div>
        @endif
    </div>

    <!-- Right Column: Cart & Transaction -->
    <div class="pos-cart">
        <div class="cart-header">
            <h3 class="section-title">
                <i class="fas fa-shopping-cart"></i>
                Keranjang Belanja
            </h3>
            <button class="clear-cart-btn" onclick="clearCart()" id="clearCartBtn">
                <i class="fas fa-trash-alt"></i>
                Kosongkan
            </button>
        </div>

        <!-- Cart Items -->
        <div class="cart-container">
            <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                @csrf

                <!-- Customer Information -->
                <div class="customer-info">
                    <div class="info-header">
                        <i class="fas fa-user"></i>
                        <span>Informasi Pelanggan</span>
                    </div>
                    <div class="info-content">
                        <div class="form-group">
                            <label for="customer_name">Nama Pelanggan</label>
                            <input type="text" id="customer_name" name="customer_name"
                                   class="form-control" placeholder="Pelanggan Umum"
                                   value="{{ old('customer_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="customer_phone">No. Telepon</label>
                            <input type="tel" id="customer_phone" name="customer_phone"
                                   class="form-control" placeholder="08xxxxxxxxxx"
                                   value="{{ old('customer_phone') }}">
                        </div>
                    </div>
                </div>

                <!-- Cart Items Table -->
                <div class="cart-items-container" id="cartContainer">
                    <div class="empty-cart" id="emptyCart">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Keranjang masih kosong</p>
                        <small>Klik produk untuk menambah ke keranjang</small>
                    </div>

                    <table class="cart-table" id="cartTable" style="display: none;">
                        <thead>
                            <tr>
                                <th width="40%">Produk</th>
                                <th width="20%">Qty</th>
                                <th width="20%">Harga</th>
                                <th width="15%">Subtotal</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <!-- Items will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Transaction Summary -->
                <div class="transaction-summary" id="transactionSummary" style="display: none;">
                    <div class="summary-header">
                        <h4>Ringkasan Transaksi</h4>
                    </div>

                    <div class="summary-body">
                        <div class="summary-row">
                            <span>Total Item</span>
                            <span id="totalItems">0</span>
                        </div>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp 0</span>
                        </div>

                        <div class="summary-row discount-row">
                            <div class="discount-label">
                                <span>Diskon</span>
                                <small>(%)</small>
                            </div>
                            <div class="discount-input">
                                <input type="number" id="discount" name="discount"
                                       value="0" min="0" max="100" step="0.1"
                                       onchange="calculateTotal()">
                                <span>%</span>
                            </div>
                        </div>

                        <div class="summary-row">
                            <span>Diskon Amount</span>
                            <span id="discountAmount">Rp 0</span>
                        </div>

                        <div class="summary-row total-row">
                            <span>Total Bayar</span>
                            <span id="grandTotal">Rp 0</span>
                        </div>

                        <!-- Payment Method -->
                        <div class="payment-method">
                            <label>Metode Pembayaran</label>
                            <div class="payment-options">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="cash" checked>
                                    <span class="payment-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Tunai
                                    </span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="debit_card">
                                    <span class="payment-icon">
                                        <i class="fas fa-credit-card"></i>
                                        Debit
                                    </span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="credit_card">
                                    <span class="payment-icon">
                                        <i class="fas fa-credit-card"></i>
                                        Kredit
                                    </span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="e_wallet">
                                    <span class="payment-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                        E-Wallet
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Cash Input -->
                        <div class="cash-input">
                            <label for="cash_received">Uang Diterima</label>
                            <div class="cash-input-group">
                                <span class="cash-prefix">Rp</span>
                                <input type="number" id="cash_received" name="cash_received"
                                       value="0" min="0" step="100"
                                       onchange="calculateChange()">
                            </div>
                        </div>

                        <!-- Change -->
                        <div class="change-row" id="changeRow" style="display: none;">
                            <span>Kembalian</span>
                            <span id="changeAmount" class="change-amount">Rp 0</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" class="btn btn-secondary" onclick="resetTransaction()">
                            <i class="fas fa-redo"></i>
                            Reset
                        </button>

                        <button type="submit" class="btn btn-success" id="processBtn">
                            <i class="fas fa-cash-register"></i>
                            Proses Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* =========================
       LAYOUT & CONTAINER
    ========================= */
    .pos-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 24px;
        height: calc(100vh - 140px);
        max-height: 800px;
    }

    .pos-products, .pos-cart {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .pos-products {
        border: 1px solid var(--border);
    }

    .pos-cart {
        border: 1px solid var(--border);
    }

    /* =========================
       PRODUCTS SECTION
    ========================= */
    .products-header {
        padding: 20px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
        max-width: 300px;
    }

    .pos-search {
        width: 100%;
        padding: 10px 40px 10px 40px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: white;
    }

    .pos-search:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        font-size: 14px;
    }

    .clear-search {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }

    .clear-search:hover {
        color: var(--danger);
    }

    .products-count {
        font-size: 13px;
        color: var(--text-light);
        background: var(--light);
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Category Filter */
    .category-filter {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        gap: 8px;
        overflow-x: auto;
        background: white;
    }

    .category-btn {
        padding: 8px 16px;
        background: var(--light);
        border: 1px solid var(--border);
        border-radius: 20px;
        font-size: 13px;
        color: var(--text-light);
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .category-btn:hover {
        background: #e2e8f0;
        border-color: var(--primary-light);
    }

    .category-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Products Grid */
    .products-grid {
        flex: 1;
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        overflow-y: auto;
    }

    .product-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 15px;
        position: relative;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .product-card:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .stock-badge {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stock-badge.in-stock {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .stock-badge.low-stock {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .stock-badge.out-stock {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .product-info {
        flex: 1;
    }

    .product-code {
        font-size: 11px;
        color: var(--text-light);
        margin-bottom: 4px;
        font-family: 'Monaco', 'Courier New', monospace;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .product-category {
        font-size: 12px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 12px;
    }

    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary);
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 10px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .add-to-cart-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .add-to-cart-btn:active {
        transform: translateY(0);
    }

    /* Empty State */
    .empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        text-align: center;
        color: var(--text-light);
    }

    .empty-icon {
        font-size: 48px;
        color: var(--border);
        margin-bottom: 16px;
    }

    .empty-state h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text);
    }

    .empty-state p {
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* =========================
       CART SECTION
    ========================= */
    .cart-header {
        padding: 20px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .clear-cart-btn {
        padding: 8px 16px;
        background: var(--danger);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .clear-cart-btn:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .cart-container {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Customer Info */
    .customer-info {
        background: var(--light);
        border-radius: 10px;
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .info-header {
        padding: 12px 16px;
        background: rgba(37, 99, 235, 0.1);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: var(--primary);
    }

    .info-content {
        padding: 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    /* Cart Items */
    .cart-items-container {
        flex: 1;
        background: white;
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        min-height: 200px;
    }

    .empty-cart {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        text-align: center;
        padding: 40px;
    }

    .empty-cart i {
        font-size: 48px;
        color: var(--border);
        margin-bottom: 16px;
    }

    .empty-cart p {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text);
    }

    .empty-cart small {
        font-size: 13px;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th {
        background: var(--light);
        padding: 12px 8px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .cart-table td {
        padding: 12px 8px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .cart-table tr:hover {
        background: var(--light);
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .quantity-btn {
        width: 28px;
        height: 28px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.2s ease;
    }

    .quantity-btn:hover {
        background: var(--light);
        border-color: var(--primary);
        color: var(--primary);
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        padding: 6px;
        border: 1px solid var(--border);
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
    }

    .quantity-input:focus {
        outline: none;
        border-color: var(--primary);
    }

    .remove-btn {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .remove-btn:hover {
        color: #dc2626;
        transform: scale(1.1);
    }

    /* Transaction Summary */
    .transaction-summary {
        background: white;
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
    }

    .summary-header {
        padding: 16px 20px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
    }

    .summary-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-body {
        padding: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--light);
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-row.total-row {
        margin-top: 10px;
        padding-top: 15px;
        border-top: 2px solid var(--light);
        font-size: 18px;
        font-weight: 700;
        color: var(--primary);
    }

    .discount-row {
        align-items: center;
    }

    .discount-label {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .discount-label small {
        color: var(--text-light);
        font-size: 11px;
    }

    .discount-input {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .discount-input input {
        width: 70px;
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 6px;
        text-align: center;
        font-weight: 600;
    }

    .discount-input span {
        color: var(--text-light);
        font-size: 14px;
    }

    /* Payment Method */
    .payment-method {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--light);
    }

    .payment-method label {
        display: block;
        margin-bottom: 12px;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input {
        position: absolute;
        opacity: 0;
    }

    .payment-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 12px;
        background: var(--light);
        border: 2px solid var(--border);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-size: 12px;
        font-weight: 500;
    }

    .payment-option input:checked + .payment-icon {
        background: rgba(37, 99, 235, 0.1);
        border-color: var(--primary);
        color: var(--primary);
    }

    .payment-icon i {
        font-size: 18px;
    }

    /* Cash Input */
    .cash-input {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--light);
    }

    .cash-input label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .cash-input-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cash-prefix {
        font-weight: 600;
        color: var(--primary);
    }

    .cash-input-group input {
        flex: 1;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        text-align: right;
    }

    .cash-input-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Change Row */
    .change-row {
        margin-top: 20px;
        padding: 16px;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .change-amount {
        font-size: 18px;
        font-weight: 700;
        color: var(--success);
    }

    /* Action Buttons */
    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary {
        background: var(--light);
        color: var(--text);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    .btn-success {
        background: var(--success);
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-success:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* =========================
       RESPONSIVE DESIGN
    ========================= */
    @media (max-width: 1200px) {
        .pos-container {
            grid-template-columns: 1fr 380px;
        }
    }

    @media (max-width: 992px) {
        .pos-container {
            grid-template-columns: 1fr;
            height: auto;
            max-height: none;
        }

        .pos-cart {
            max-height: 600px;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .info-content {
            grid-template-columns: 1fr;
        }

        .payment-options {
            grid-template-columns: repeat(4, 1fr);
        }

        .action-buttons {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }

        .header-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .search-wrapper {
            max-width: none;
        }

        .payment-options {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let cart = {};
    let cartItemCount = 0;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateCartDisplay();
        setupSearch();
        setupCategoryFilter();
        setupFormValidation();
    });

    // Search functionality
    function setupSearch() {
        const searchInput = document.getElementById('searchProduct');
        const clearSearch = document.getElementById('clearSearch');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterProducts(searchTerm);
            });
        }

        if (clearSearch) {
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                filterProducts('');
                searchInput.focus();
            });
        }
    }

    // Category filter
    function setupCategoryFilter() {
        const categoryBtns = document.querySelectorAll('.category-btn');
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const category = this.dataset.category;
                filterByCategory(category);
            });
        });
    }

    // Filter products by search term
    function filterProducts(searchTerm) {
        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        products.forEach(product => {
            const productName = product.dataset.name;
            const productCode = product.dataset.code || '';
            const shouldShow = productName.includes(searchTerm) ||
                              productCode.toLowerCase().includes(searchTerm);

            product.style.display = shouldShow ? 'flex' : 'none';
            if (shouldShow) visibleCount++;
        });

        document.getElementById('productsCount').textContent = visibleCount;
    }

    // Filter products by category
    function filterByCategory(categoryId) {
        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        products.forEach(product => {
            const productCategory = product.dataset.category;
            const shouldShow = categoryId === 'all' || productCategory === categoryId;

            product.style.display = shouldShow ? 'flex' : 'none';
            if (shouldShow) visibleCount++;
        });

        document.getElementById('productsCount').textContent = visibleCount;
    }

    // Add product to cart
    function addProductToCart(button) {
        const productCard = button.closest('.product-card');
        const productId = productCard.dataset.id;
        const productName = productCard.querySelector('.product-name').textContent;
        const productPrice = parseInt(productCard.dataset.price);
        const productStock = parseInt(productCard.dataset.stock);

        // Check stock
        if (productStock <= 0) {
            showAlert('error', 'Stok produk habis');
            return;
        }

        // Add to cart or increment quantity
        if (cart[productId]) {
            if (cart[productId].qty >= productStock) {
                showAlert('error', 'Stok tidak mencukupi');
                return;
            }
            cart[productId].qty++;
        } else {
            cart[productId] = {
                id: productId,
                name: productName,
                price: productPrice,
                stock: productStock,
                qty: 1
            };
        }

        // Update cart display
        updateCartDisplay();

        // Show success feedback
        showAlert('success', `${productName} ditambahkan ke keranjang`);

        // Animate the button
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = '';
        }, 200);
    }

    // Update cart display
    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        const emptyCart = document.getElementById('emptyCart');
        const cartTable = document.getElementById('cartTable');
        const transactionSummary = document.getElementById('transactionSummary');
        const clearCartBtn = document.getElementById('clearCartBtn');

        cartItems.innerHTML = '';
        let totalItems = 0;
        let subtotal = 0;
        let index = 0;

        // Loop through cart items
        Object.values(cart).forEach(item => {
            const itemSubtotal = item.qty * item.price;
            totalItems += item.qty;
            subtotal += itemSubtotal;

            cartItems.innerHTML += `
                <tr data-id="${item.id}">
                    <td>
                        <div class="product-name-cell">
                            <strong>${item.name}</strong>
                            <small>Rp ${item.price.toLocaleString()}</small>
                        </div>
                    </td>
                    <td>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.qty - 1})">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="quantity-input"
                                   value="${item.qty}" min="1" max="${item.stock}"
                                   onchange="updateQuantity(${item.id}, this.value)">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.qty + 1})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>Rp ${item.price.toLocaleString()}</td>
                    <td>Rp ${itemSubtotal.toLocaleString()}</td>
                    <td>
                        <button type="button" class="remove-btn" onclick="removeItem(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>

                    <!-- Hidden inputs for form submission -->
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                </tr>
            `;
            index++;
        });

        // Update totals
        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('subtotal').textContent = formatCurrency(subtotal);

        // Calculate final total
        calculateTotal();

        // Show/hide empty state
        if (Object.keys(cart).length === 0) {
            emptyCart.style.display = 'flex';
            cartTable.style.display = 'none';
            transactionSummary.style.display = 'none';
            clearCartBtn.style.opacity = '0.5';
            clearCartBtn.style.cursor = 'not-allowed';
        } else {
            emptyCart.style.display = 'none';
            cartTable.style.display = 'table';
            transactionSummary.style.display = 'block';
            clearCartBtn.style.opacity = '1';
            clearCartBtn.style.cursor = 'pointer';
        }

        // Update cart item count
        cartItemCount = Object.keys(cart).length;
    }

    // Update item quantity
    function updateQuantity(productId, newQty) {
        newQty = parseInt(newQty);

        if (newQty < 1) {
            removeItem(productId);
            return;
        }

        if (newQty > cart[productId].stock) {
            showAlert('error', 'Stok tidak mencukupi');
            newQty = cart[productId].stock;
        }

        cart[productId].qty = newQty;
        updateCartDisplay();
    }

    // Remove item from cart
    function removeItem(productId) {
        if (confirm('Hapus produk dari keranjang?')) {
            delete cart[productId];
            updateCartDisplay();
        }
    }

    // Clear entire cart
    function clearCart() {
        if (Object.keys(cart).length === 0) return;

        if (confirm('Kosongkan seluruh keranjang?')) {
            cart = {};
            updateCartDisplay();
            showAlert('info', 'Keranjang telah dikosongkan');
        }
    }

    // Calculate total with discount
    function calculateTotal() {
        const subtotalText = document.getElementById('subtotal').textContent;
        const subtotal = parseCurrency(subtotalText);
        const discountPercent = parseFloat(document.getElementById('discount').value);

        // Calculate discount amount
        const discountAmount = subtotal * (discountPercent / 100);
        const grandTotal = subtotal - discountAmount;

        // Update display
        document.getElementById('discountAmount').textContent = formatCurrency(discountAmount);
        document.getElementById('grandTotal').textContent = formatCurrency(grandTotal);

        // Update change calculation
        calculateChange();
    }

    // Calculate change
    function calculateChange() {
        const grandTotalText = document.getElementById('grandTotal').textContent;
        const grandTotal = parseCurrency(grandTotalText);
        const cashReceived = parseFloat(document.getElementById('cash_received').value) || 0;
        const change = cashReceived - grandTotal;

        const changeRow = document.getElementById('changeRow');
        const processBtn = document.getElementById('processBtn');

        if (cashReceived > 0) {
            changeRow.style.display = 'flex';
            document.getElementById('changeAmount').textContent = formatCurrency(change);

            // Enable/disable process button based on payment
            if (cashReceived >= grandTotal) {
                processBtn.disabled = false;
                processBtn.innerHTML = '<i class="fas fa-cash-register"></i> Proses Transaksi';
            } else {
                processBtn.disabled = true;
                processBtn.innerHTML = '<i class="fas fa-exclamation-circle"></i> Uang Kurang';
            }
        } else {
            changeRow.style.display = 'none';
            processBtn.disabled = false;
            processBtn.innerHTML = '<i class="fas fa-cash-register"></i> Proses Transaksi';
        }
    }

    // Reset transaction
    function resetTransaction() {
        if (Object.keys(cart).length === 0) {
            showAlert('info', 'Tidak ada transaksi untuk direset');
            return;
        }

        if (confirm('Reset transaksi saat ini?')) {
            // Clear cart
            cart = {};
            updateCartDisplay();

            // Reset form fields
            document.getElementById('customer_name').value = '';
            document.getElementById('customer_phone').value = '';
            document.getElementById('discount').value = 0;
            document.getElementById('cash_received').value = 0;

            // Reset payment method to cash
            document.querySelector('input[name="payment_method"][value="cash"]').checked = true;

            showAlert('success', 'Transaksi telah direset');
        }
    }

    // Form validation
    function setupFormValidation() {
        const form = document.getElementById('transactionForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Check if cart is empty
            if (Object.keys(cart).length === 0) {
                showAlert('error', 'Tambahkan produk ke keranjang terlebih dahulu');
                return;
            }

            // Validate quantities
            let hasInvalidQuantity = false;
            Object.values(cart).forEach(item => {
                if (item.qty > item.stock) {
                    hasInvalidQuantity = true;
                    showAlert('error', `Stok ${item.name} tidak mencukupi. Stok tersedia: ${item.stock}`);
                }
            });

            if (hasInvalidQuantity) {
                return;
            }

            // If payment is cash, validate cash received
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const cashReceived = parseFloat(document.getElementById('cash_received').value) || 0;
            const grandTotal = parseCurrency(document.getElementById('grandTotal').textContent);

            if (paymentMethod === 'cash' && cashReceived < grandTotal) {
                showAlert('error', 'Uang yang diterima kurang dari total bayar');
                return;
            }

            // Show confirmation
            if (confirm('Proses transaksi ini?')) {
                // Disable button to prevent double submission
                const processBtn = document.getElementById('processBtn');
                processBtn.disabled = true;
                processBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                // Submit form
                form.submit();
            }
        });
    }

    // Helper function to format currency
    function formatCurrency(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    // Helper function to parse currency
    function parseCurrency(currencyString) {
        return parseFloat(currencyString.replace(/[^\d,-]/g, '').replace(',', ''));
    }

    // Show alert message
    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert-message');
        if (existingAlert) {
            existingAlert.remove();
        }

        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert-message alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${getAlertIcon(type)}"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Style the alert
        const alertStyles = {
            'position': 'fixed',
            'top': '20px',
            'right': '20px',
            'background': getAlertColor(type),
            'color': 'white',
            'padding': '16px 20px',
            'border-radius': '8px',
            'display': 'flex',
            'align-items': 'center',
            'gap': '12px',
            'box-shadow': '0 4px 12px rgba(0,0,0,0.15)',
            'z-index': '1000',
            'animation': 'slideIn 0.3s ease',
            'max-width': '400px'
        };

        Object.assign(alert.style, alertStyles);

        // Add close button styles
        const closeBtn = alert.querySelector('button');
        closeBtn.style.cssText = 'background: none; border: none; color: white; cursor: pointer; margin-left: 10px;';

        // Add to document
        document.body.appendChild(alert);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);

        // Add animation styles if not already present
        if (!document.querySelector('#alert-animation')) {
            const style = document.createElement('style');
            style.id = 'alert-animation';
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
        }
    }

    function getAlertIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'info': 'info-circle',
            'warning': 'exclamation-triangle'
        };
        return icons[type] || 'info-circle';
    }

    function getAlertColor(type) {
        const colors = {
            'success': '#10b981',
            'error': '#ef4444',
            'info': '#3b82f6',
            'warning': '#f59e0b'
        };
        return colors[type] || '#3b82f6';
    }
</script>
@endpush
