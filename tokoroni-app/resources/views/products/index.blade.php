@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm card-custom">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-boxes mr-2"></i>Daftar Produk
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('products.create') }}" class="btn btn-light btn-custom">
                                <i class="fas fa-plus-circle mr-1"></i> Tambah Produk
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Success Alert -->
                        @if (session('success'))
                            <div class="alert alert-success alert-custom fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle mr-3 fa-lg"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Berhasil!</h6>
                                        <p class="mb-0">{{ session('success') }}</p>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Filter Section -->
                        <div class="filter-section mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-custom">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Cari produk..."
                                            id="search-input">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control form-control-custom" id="category-filter">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories ?? [] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control form-control-custom" id="status-filter">
                                        <option value="">Semua Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control form-control-custom" id="stock-filter">
                                        <option value="">Semua Stok</option>
                                        <option value="low">Stok Rendah</option>
                                        <option value="normal">Stok Normal</option>
                                        <option value="out">Stok Habis</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-secondary btn-sm" id="reset-filters">
                                            <i class="fas fa-redo mr-1"></i> Reset
                                        </button>
                                        <button class="btn btn-info btn-sm" id="apply-filters">
                                            <i class="fas fa-filter mr-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="stats-section mb-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <div class="stat-card stat-card-primary">
                                        <div class="stat-icon">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h3>{{ $stats['total'] ?? 0 }}</h3>
                                            <p>Total Produk</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="stat-card stat-card-success">
                                        <div class="stat-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h3>{{ $stats['active'] ?? 0 }}</h3>
                                            <p>Produk Aktif</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="stat-card stat-card-warning">
                                        <div class="stat-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h3>{{ $stats['low_stock'] ?? 0 }}</h3>
                                            <p>Stok Rendah</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="stat-card stat-card-danger">
                                        <div class="stat-icon">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                        <div class="stat-content">
                                            <h3>{{ $stats['out_of_stock'] ?? 0 }}</h3>
                                            <p>Stok Habis</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div class="table-section">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom" id="products-table">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th width="50" class="text-center">#</th>
                                            <th width="100" class="text-center">Kode</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th width="120" class="text-right">Harga</th>
                                            <th width="100" class="text-center">Stok</th>
                                            <th width="100" class="text-center">Status</th>
                                            <th width="140" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            <tr class="product-row" data-category="{{ $product->category_id ?? '' }}"
                                                data-status="{{ $product->is_active }}"
                                                data-stock="{{ $product->stock <= 0 ? 'out' : ($product->stock <= $product->min_stock ? 'low' : 'normal') }}">
                                                <td class="text-center serial-number">
                                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-code">{{ $product->code }}</span>
                                                </td>
                                                <td>
                                                    <div class="product-info">
                                                        <div class="product-image">
                                                            @if ($product->image)
                                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                                    alt="{{ $product->name }}" class="img-product">
                                                            @else
                                                                <div class="img-placeholder">
                                                                    <i class="fas fa-box"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="product-details">
                                                            <h6 class="product-name">{{ $product->name }}</h6>
                                                            @if ($product->barcode)
                                                                <small class="text-muted">
                                                                    <i
                                                                        class="fas fa-barcode mr-1"></i>{{ $product->barcode }}
                                                                </small>
                                                            @endif
                                                            @if ($product->description)
                                                                <p class="product-description">
                                                                    {{ Str::limit($product->description, 50) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-category">
                                                        {{ $product->category->name ?? 'Tidak Berkategori' }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="price-info">
                                                        <span class="price">Rp
                                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                                        @if ($product->cost_price)
                                                            <br>
                                                            <small class="cost-price">
                                                                Beli: Rp
                                                                {{ number_format($product->cost_price, 0, ',', '.') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="stock-indicator">
                                                        @php
                                                            $maxStock = max($product->stock, $product->min_stock * 2);
                                                            $percentage = min(100, ($product->stock / $maxStock) * 100);
                                                            $stockClass =
                                                                $product->stock <= 0
                                                                    ? 'danger'
                                                                    : ($product->stock <= $product->min_stock
                                                                        ? 'warning'
                                                                        : 'success');
                                                        @endphp
                                                        <div class="stock-bar">
                                                            <div class="stock-progress"
                                                                style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <span class="stock-badge badge-{{ $stockClass }}">
                                                            {{ $product->stock }} {{ $product->unit }}
                                                        </span>
                                                        @if ($product->stock <= $product->min_stock)
                                                            <small class="stock-warning text-{{ $stockClass }}">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                Min: {{ $product->min_stock }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="status-badge status-{{ $product->is_active ? 'active' : 'inactive' }}">
                                                        <i
                                                            class="fas fa-{{ $product->is_active ? 'check' : 'times' }} mr-1"></i>
                                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-buttons">
                                                        @if (Route::has('products.show'))
                                                            <a href="{{ route('products.show', $product->id) }}"
                                                                class="btn btn-action btn-info" title="Detail"
                                                                data-toggle="tooltip">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                            class="btn btn-action btn-warning" title="Edit"
                                                            data-toggle="tooltip">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-action btn-danger"
                                                            title="Hapus" data-toggle="modal"
                                                            data-target="#deleteModal{{ $product->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content modal-custom">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i
                                                                    class="fas fa-exclamation-triangle text-danger mr-2"></i>
                                                                Konfirmasi Hapus
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center mb-3">
                                                                <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                                                                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                                                                <div class="alert alert-light">
                                                                    <strong>{{ $product->name }}</strong><br>
                                                                    <small>Kode: {{ $product->code }}</small>
                                                                </div>
                                                                <p class="text-danger"><small>Tindakan ini tidak dapat
                                                                        dibatalkan!</small></p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                                method="POST" class="w-100">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="d-flex justify-content-between w-100">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">
                                                                        <i class="fas fa-times mr-1"></i> Batal
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <div class="empty-state">
                                                        <div class="empty-icon">
                                                            <i class="fas fa-box-open"></i>
                                                        </div>
                                                        <h4>Tidak ada data produk</h4>
                                                        <p class="text-muted">Mulai dengan menambahkan produk pertama Anda.
                                                        </p>
                                                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                                                            <i class="fas fa-plus mr-1"></i> Tambah Produk
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($products->hasPages())
                            <div class="pagination-section mt-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <p class="pagination-info">
                                            Menampilkan <strong>{{ $products->firstItem() }}</strong> sampai
                                            <strong>{{ $products->lastItem() }}</strong> dari
                                            <strong>{{ $products->total() }}</strong> produk
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <nav aria-label="Page navigation" class="float-md-right">
                                            {{ $products->links('pagination::bootstrap-4') }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer card-footer-custom">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="mr-2">Tampilkan:</span>
                                    <select class="form-control form-control-sm per-page-select" id="per-page-select">
                                        <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page', 15) == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                    <span class="ml-2">entri per halaman</span>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                                <div class="export-buttons">
                                    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                        <i class="fas fa-print mr-1"></i> Cetak
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" id="export-csv">
                                        <i class="fas fa-file-csv mr-1"></i> Export CSV
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" id="export-pdf">
                                        <i class="fas fa-file-pdf mr-1"></i> Export PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
      /* =============================================
   GLOBAL STYLES & VARIABLES
   ============================================= */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    --danger-gradient: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    --info-gradient: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    --light-gradient: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --element-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    --hover-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    --border-radius: 12px;
    --border-radius-sm: 8px;
    --transition: all 0.3s ease;
}

/* =============================================
   MAIN CARD & HEADER
   ============================================= */
.card-custom {
    border: none;
    border-radius: var(--border-radius);
    overflow: hidden;
    background: #ffffff;
    box-shadow: var(--card-shadow);
}

.card-header-custom {
    background: var(--primary-gradient);
    color: white;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
}

.card-header-custom .card-title {
    font-weight: 600;
    font-size: 1.4rem;
    letter-spacing: 0.5px;
    margin: 0;
}

.btn-custom {
    border-radius: var(--border-radius-sm);
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    transition: var(--transition);
    border: none;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: var(--hover-shadow);
}

/* =============================================
   ALERTS
   ============================================= */
.alert-custom {
    border-radius: 10px;
    border: none;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--element-shadow);
}

.alert-custom.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left: 4px solid #28a745;
}

.alert-custom .d-flex {
    display: flex;
    align-items: center;
}

.alert-custom .alert-heading {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

/* =============================================
   FILTER SECTION
   ============================================= */
.filter-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.filter-section .row.g-3 {
    margin: -0.75rem;
}

.filter-section .row.g-3 > * {
    padding: 0.75rem;
}

.input-group-custom {
    border-radius: var(--border-radius-sm);
    overflow: hidden;
}

.input-group-custom .input-group-text {
    background: #667eea;
    color: white;
    border: none;
    border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
    padding: 0.625rem 1rem;
}

.form-control-custom {
    border-radius: var(--border-radius-sm);
    border: 1px solid #e0e0e0;
    padding: 0.625rem 1rem;
    transition: var(--transition);
}

.form-control-custom:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* =============================================
   STATS CARDS
   ============================================= */
.stats-section .row.g-3 {
    margin: -0.75rem;
}

.stats-section .row.g-3 > * {
    padding: 0.75rem;
}

.stat-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    height: 100%;
    border: 1px solid #f0f0f0;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.75rem;
    color: white;
}

.stat-card-primary .stat-icon {
    background: var(--primary-gradient);
}

.stat-card-success .stat-icon {
    background: var(--success-gradient);
}

.stat-card-warning .stat-icon {
    background: var(--warning-gradient);
}

.stat-card-danger .stat-icon {
    background: var(--danger-gradient);
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #333;
    line-height: 1;
}

.stat-content p {
    margin: 0.25rem 0 0 0;
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
}

/* =============================================
   TABLE STYLES
   ============================================= */
.table-section {
    overflow: hidden;
    border-radius: var(--border-radius-sm);
}

.table-custom {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.thead-custom {
    background: var(--light-gradient);
}

.thead-custom th {
    border: none;
    padding: 1rem 0.75rem;
    font-weight: 600;
    color: #495057;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle;
}

.table-custom tbody tr {
    transition: var(--transition);
    border-bottom: 1px solid #f0f0f0;
    background: white;
}

.table-custom tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.table-custom td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f0f0f0;
}

.serial-number {
    font-weight: 500;
    color: #666;
}

/* =============================================
   PRODUCT INFO
   ============================================= */
.product-info {
    display: flex;
    align-items: center;
    min-width: 0;
}

.product-image {
    width: 50px;
    height: 50px;
    margin-right: 1rem;
    flex-shrink: 0;
}

.img-product {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--border-radius-sm);
    border: 1px solid #e0e0e0;
}

.img-placeholder {
    width: 100%;
    height: 100%;
    background: var(--light-gradient);
    border-radius: var(--border-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 1.25rem;
}

.product-details {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.product-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 0.95rem;
}

.product-description {
    color: #6c757d;
    font-size: 0.85rem;
    margin: 0.25rem 0 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* =============================================
   BADGES
   ============================================= */
.badge-code {
    background: #e9ecef;
    color: #495057;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
    display: inline-block;
    text-align: center;
    min-width: 70px;
}

.badge-category {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #495057;
    padding: 0.4rem 0.8rem;
    border-radius: var(--border-radius-sm);
    font-weight: 500;
    display: inline-block;
}

/* =============================================
   PRICE STYLES
   ============================================= */
.price-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    line-height: 1.4;
}

.price {
    font-weight: 700;
    font-size: 1rem;
    color: #28a745;
}

.cost-price {
    color: #6c757d;
    font-size: 0.8rem;
    font-weight: 400;
}

/* =============================================
   STOCK INDICATOR
   ============================================= */
.stock-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    min-width: 120px;
}

.stock-bar {
    width: 80px;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
    position: relative;
}

.stock-progress {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s ease;
    position: absolute;
    left: 0;
    top: 0;
}

.stock-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
    min-width: 70px;
    display: inline-block;
    text-align: center;
    font-size: 0.85rem;
}

.badge-success .stock-progress {
    background: #28a745;
}

.badge-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.badge-warning .stock-progress {
    background: #ffc107;
}

.badge-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
}

.badge-danger .stock-progress {
    background: #dc3545;
}

.badge-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

.stock-warning {
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
}

/* =============================================
   STATUS BADGE
   ============================================= */
.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 500;
    display: inline-block;
    font-size: 0.85rem;
    text-align: center;
    min-width: 80px;
}

.status-active {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.status-inactive {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

/* =============================================
   ACTION BUTTONS
   ============================================= */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: nowrap;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: var(--border-radius-sm);
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    border: none;
    font-size: 0.9rem;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-action.btn-info {
    background: var(--info-gradient);
    color: white;
}

.btn-action.btn-warning {
    background: var(--warning-gradient);
    color: white;
}

.btn-action.btn-danger {
    background: var(--danger-gradient);
    color: white;
}

/* =============================================
   MODAL STYLES
   ============================================= */
.modal-custom {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.modal-custom .modal-header {
    background: var(--light-gradient);
    border-radius: var(--border-radius) var(--border-radius) 0 0;
    border-bottom: 1px solid #dee2e6;
    padding: 1.25rem 1.5rem;
}

.modal-custom .modal-body {
    padding: 1.5rem;
}

.modal-custom .modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #dee2e6;
}

/* =============================================
   EMPTY STATE
   ============================================= */
.empty-state {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-icon {
    font-size: 3rem;
    color: #adb5bd;
    margin-bottom: 1rem;
}

.empty-state h4 {
    color: #495057;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

/* =============================================
   PAGINATION
   ============================================= */
.pagination-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    margin-top: 1.5rem;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.pagination .page-link {
    border-radius: var(--border-radius-sm);
    margin: 0 2px;
    border: none;
    color: #495057;
}

.pagination .page-item.active .page-link {
    background: var(--primary-gradient);
    border-color: transparent;
}

/* =============================================
   CARD FOOTER
   ============================================= */
.card-footer-custom {
    background: var(--light-gradient);
    border-top: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

.per-page-select {
    width: auto;
    display: inline-block;
    margin: 0 0.5rem;
    max-width: 80px;
}

.export-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    flex-wrap: wrap;
}

/* =============================================
   RESPONSIVE STYLES
   ============================================= */
@media (max-width: 768px) {
    .card-header-custom {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .card-header-custom .card-tools {
        width: 100%;
        margin-top: 0.5rem;
    }

    .btn-custom {
        width: 100%;
    }

    .filter-section .row {
        flex-direction: column;
    }

    .stats-section .row {
        margin: -0.5rem;
    }

    .stats-section .row > * {
        padding: 0.5rem;
    }

    .stat-card {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }

    .stat-icon {
        margin-right: 0;
        margin-bottom: 0.75rem;
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .product-info {
        flex-direction: column;
        align-items: flex-start;
    }

    .product-image {
        margin-right: 0;
        margin-bottom: 0.75rem;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
    }

    .export-buttons {
        flex-direction: column;
        gap: 0.5rem;
        justify-content: flex-start;
    }

    .pagination-section .row {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .table-custom {
        font-size: 0.9rem;
    }

    .table-custom th,
    .table-custom td {
        padding: 0.75rem 0.5rem;
    }
}

@media (max-width: 576px) {
    .card-header-custom {
        padding: 1rem;
    }

    .card-body {
        padding: 1rem;
    }

    .filter-section {
        padding: 1rem;
    }

    .stat-content h3 {
        font-size: 1.75rem;
    }

    .price-info {
        align-items: flex-start;
    }
}

/* =============================================
   ANIMATIONS
   ============================================= */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-row {
    animation: fadeIn 0.3s ease forwards;
    animation-fill-mode: both;
}

.product-row:nth-child(even) {
    animation-delay: 0.05s;
}

.product-row:nth-child(odd) {
    animation-delay: 0.1s;
}

/* =============================================
   PRINT STYLES
   ============================================= */
@media print {
    .card-header-custom,
    .filter-section,
    .stats-section,
    .card-footer-custom,
    .action-buttons,
    .btn-action,
    .modal {
        display: none !important;
    }

    .card-custom {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }

    .table-custom {
        font-size: 12px;
    }

    .table-custom td,
    .table-custom th {
        border: 1px solid #dee2e6 !important;
    }

    .product-image {
        display: none;
    }
}

/* =============================================
   UTILITY CLASSES
   ============================================= */
.text-gradient-primary {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.cursor-pointer {
    cursor: pointer;
}

.text-ellipsis {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* =============================================
   CUSTOM SCROLLBAR
   ============================================= */
.table-responsive::-webkit-scrollbar {
    height: 6px;
    width: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });

            // Search functionality
            let searchTimeout;
            $('#search-input').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchText = $(this).val().toLowerCase().trim();
                    $('.product-row').each(function() {
                        const rowText = $(this).find(
                                '.product-name, .product-description, .badge-code').text()
                            .toLowerCase();
                        $(this).toggle(rowText.indexOf(searchText) > -1 || searchText ===
                            '');
                    });
                }, 300);
            });

            // Filter functionality
            function applyFilters() {
                const categoryId = $('#category-filter').val();
                const status = $('#status-filter').val();
                const stockStatus = $('#stock-filter').val();

                $('.product-row').each(function() {
                    const rowCategory = $(this).data('category');
                    const rowStatus = $(this).data('status').toString();
                    const rowStock = $(this).data('stock');

                    const categoryMatch = !categoryId || rowCategory == categoryId;
                    const statusMatch = !status || rowStatus == status;
                    const stockMatch = !stockStatus || rowStock == stockStatus;

                    $(this).toggle(categoryMatch && statusMatch && stockMatch);
                });

                // Update visible row numbers
                updateSerialNumbers();
            }

            // Update serial numbers after filtering
            function updateSerialNumbers() {
                let counter = 1;
                $('.product-row:visible').each(function() {
                    $(this).find('.serial-number').text(counter);
                    counter++;
                });
            }

            // Event listeners for filters
            $('#category-filter, #status-filter, #stock-filter').on('change', applyFilters);
            $('#apply-filters').on('click', applyFilters);

            // Reset filters
            $('#reset-filters').on('click', function() {
                $('#search-input').val('');
                $('#category-filter').val('');
                $('#status-filter').val('');
                $('#stock-filter').val('');
                $('.product-row').show();
                updateSerialNumbers();
            });

            // Items per page
            $('#per-page-select').on('change', function() {
                const perPage = $(this).val();
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', '1'); // Reset to first page
                window.location.href = url.toString();
            });

            // Export buttons
            $('#export-csv').on('click', function() {
                Toast.fire({
                    icon: 'info',
                    title: 'Fitur export CSV akan segera tersedia!'
                });
            });

            $('#export-pdf').on('click', function() {
                Toast.fire({
                    icon: 'info',
                    title: 'Fitur export PDF akan segera tersedia!'
                });
            });

            // Toast notification
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Auto-hide success alert after 5 seconds
            setTimeout(function() {
                $('.alert-custom').alert('close');
            }, 5000);
        });
    </script>
@endpush
