@extends('layouts.app')

@section('title', 'Tambah Produk Baru')
@section('subtitle', 'Tambah produk baru ke dalam katalog')

@section('content')
<div class="product-form-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div>
                <h1 class="page-title">Tambah Produk Baru</h1>
                <p class="page-subtitle">Isi informasi produk di bawah ini</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-wrapper">
        <div class="form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle"></i>
                    Informasi Produk
                </h3>
                <div class="form-steps">
                    <div class="step active">1</div>
                    <div class="step-line"></div>
                    <div class="step">2</div>
                    <div class="step-line"></div>
                    <div class="step">3</div>
                </div>
            </div>

            <form method="POST" action="{{ route('products.store') }}" id="productForm" enctype="multipart/form-data">
                @csrf

                <div class="form-body">
                    <!-- Basic Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h4>
                                <i class="fas fa-info-circle"></i>
                                Informasi Dasar
                            </h4>
                            <small class="required-note">* Wajib diisi</small>
                        </div>

                        <div class="grid grid-2">
                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Nama Produk
                                    <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control @error('name') error @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Contoh: Aqua 600ml"
                                       required>
                                @error('name')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Nama produk yang jelas dan deskriptif</div>
                            </div>

                            <!-- Product Code -->
                            <div class="form-group">
                                <label for="code" class="form-label">
                                    Kode Produk
                                    <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text"
                                           id="code"
                                           name="code"
                                           class="form-control @error('code') error @enderror"
                                           value="{{ old('code') }}"
                                           placeholder="Contoh: PRD-001"
                                           required>
                                    <button type="button" class="input-action" onclick="generateProductCode()" title="Generate Kode Otomatis">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('code')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Kode unik untuk identifikasi produk</div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id" class="form-label">
                                Kategori
                                <span class="required">*</span>
                            </label>
                            <div class="category-select">
                                <select id="category_id"
                                        name="category_id"
                                        class="form-control @error('category_id') error @enderror"
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="category-actions">
                                    <button type="button" class="btn-text" onclick="showCategoryModal()">
                                        <i class="fas fa-plus"></i>
                                        Tambah Kategori
                                    </button>
                                </div>
                            </div>
                            @error('category_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="form-label">
                                Deskripsi Produk
                            </label>
                            <textarea id="description"
                                      name="description"
                                      class="form-control @error('description') error @enderror"
                                      rows="4"
                                      placeholder="Deskripsi lengkap tentang produk...">{{ old('description') }}</textarea>
                            <div class="textarea-info">
                                <span id="charCount">0</span> / 500 karakter
                            </div>
                            @error('description')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-hint">Deskripsi produk yang informatif (maksimal 500 karakter)</div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="form-section">
                        <div class="section-header">
                            <h4>
                                <i class="fas fa-tag"></i>
                                Harga & Stok
                            </h4>
                        </div>

                        <div class="grid grid-3">
                            <!-- Price -->
                            <div class="form-group">
                                <label for="price" class="form-label">
                                    Harga Jual
                                    <span class="required">*</span>
                                </label>
                                <div class="price-input">
                                    <span class="currency-prefix">Rp</span>
                                    <input type="number"
                                           id="price"
                                           name="price"
                                           class="form-control @error('price') error @enderror"
                                           value="{{ old('price') }}"
                                           placeholder="0"
                                           min="0"
                                           step="100"
                                           required>
                                </div>
                                @error('price')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Harga jual produk ke konsumen</div>
                            </div>

                            <!-- Cost Price -->
                            <div class="form-group">
                                <label for="cost_price" class="form-label">
                                    Harga Modal
                                </label>
                                <div class="price-input">
                                    <span class="currency-prefix">Rp</span>
                                    <input type="number"
                                           id="cost_price"
                                           name="cost_price"
                                           class="form-control @error('cost_price') error @enderror"
                                           value="{{ old('cost_price') }}"
                                           placeholder="0"
                                           min="0"
                                           step="100">
                                </div>
                                @error('cost_price')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Harga beli dari supplier (opsional)</div>
                            </div>

                            <!-- Profit Margin -->
                            <div class="form-group">
                                <label class="form-label">Margin Keuntungan</label>
                                <div class="profit-display">
                                    <span id="profitAmount">Rp 0</span>
                                    <span id="profitPercentage" class="profit-percentage">0%</span>
                                </div>
                                <div class="form-hint">Estimasi keuntungan per produk</div>
                            </div>
                        </div>

                        <div class="grid grid-3">
                            <!-- Stock -->
                            <div class="form-group">
                                <label for="stock" class="form-label">
                                    Stok Awal
                                    <span class="required">*</span>
                                </label>
                                <input type="number"
                                       id="stock"
                                       name="stock"
                                       class="form-control @error('stock') error @enderror"
                                       value="{{ old('stock', 0) }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                                @error('stock')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Jumlah stok awal produk</div>
                            </div>

                            <!-- Minimum Stock -->
                            <div class="form-group">
                                <label for="min_stock" class="form-label">
                                    Stok Minimum
                                </label>
                                <input type="number"
                                       id="min_stock"
                                       name="min_stock"
                                       class="form-control @error('min_stock') error @enderror"
                                       value="{{ old('min_stock', 10) }}"
                                       placeholder="10"
                                       min="0">
                                @error('min_stock')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Peringatan saat stok mencapai angka ini</div>
                            </div>

                            <!-- Unit -->
                            <div class="form-group">
                                <label for="unit" class="form-label">
                                    Satuan
                                </label>
                                <select id="unit"
                                        name="unit"
                                        class="form-control @error('unit') error @enderror">
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                                    <option value="dus" {{ old('unit') == 'dus' ? 'selected' : '' }}>Dus</option>
                                    <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                                    <option value="meter" {{ old('unit') == 'meter' ? 'selected' : '' }}>Meter</option>
                                </select>
                                @error('unit')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="form-section">
                        <div class="section-header">
                            <h4>
                                <i class="fas fa-images"></i>
                                Gambar Produk
                            </h4>
                            <small class="optional-note">Opsional</small>
                        </div>

                        <div class="image-upload-container">
                            <div class="upload-area" id="uploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <h4>Upload Gambar Produk</h4>
                                <p>Drag & drop atau klik untuk memilih file</p>
                                <p class="upload-info">Format: JPG, PNG (Maks. 2MB)</p>
                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       class="file-input"
                                       onchange="previewImage(this)">
                            </div>
                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <div class="preview-container">
                                    <img id="previewImage" src="" alt="Preview">
                                    <button type="button" class="remove-image" onclick="removeImage()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="image-info">
                                    <span id="fileName"></span>
                                    <small id="fileSize"></small>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Additional Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h4>
                                <i class="fas fa-cog"></i>
                                Informasi Tambahan
                            </h4>
                        </div>

                        <div class="grid grid-2">
                            <!-- Supplier -->
                            <div class="form-group">
                                <label for="supplier_id" class="form-label">
                                    Supplier
                                </label>
                                <select id="supplier_id"
                                        name="supplier_id"
                                        class="form-control @error('supplier_id') error @enderror">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Pemasok produk (jika ada)</div>
                            </div>

                            <!-- Barcode -->
                            <div class="form-group">
                                <label for="barcode" class="form-label">
                                    Barcode
                                </label>
                                <div class="input-group">
                                    <input type="text"
                                           id="barcode"
                                           name="barcode"
                                           class="form-control @error('barcode') error @enderror"
                                           value="{{ old('barcode') }}"
                                           placeholder="Kode barcode (opsional)">
                                    <button type="button" class="input-action" onclick="generateBarcode()" title="Generate Barcode">
                                        <i class="fas fa-barcode"></i>
                                    </button>
                                </div>
                                @error('barcode')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">Kode barcode untuk scanning (opsional)</div>
                            </div>
                        </div>

                        <!-- Weight & Dimensions -->
                        <div class="grid grid-3">
                            <div class="form-group">
                                <label for="weight" class="form-label">
                                    Berat (gram)
                                </label>
                                <input type="number"
                                       id="weight"
                                       name="weight"
                                       class="form-control @error('weight') error @enderror"
                                       value="{{ old('weight') }}"
                                       placeholder="0"
                                       min="0"
                                       step="0.01">
                                @error('weight')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="dimensions" class="form-label">
                                    Dimensi (cm)
                                </label>
                                <input type="text"
                                       id="dimensions"
                                       name="dimensions"
                                       class="form-control @error('dimensions') error @enderror"
                                       value="{{ old('dimensions') }}"
                                       placeholder="P x L x T">
                                @error('dimensions')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="expiry_date" class="form-label">
                                    Tanggal Kadaluarsa
                                </label>
                                <input type="date"
                                       id="expiry_date"
                                       name="expiry_date"
                                       class="form-control @error('expiry_date') error @enderror"
                                       value="{{ old('expiry_date') }}"
                                       min="{{ date('Y-m-d') }}">
                                @error('expiry_date')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">Produk Aktif (ditampilkan di katalog)</span>
                                </label>
                            </div>
                            <div class="form-hint">Nonaktifkan jika produk sedang tidak tersedia</div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="form-footer">
                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-redo"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan Produk
                        </button>
                    </div>
                    <div class="form-note">
                        <i class="fas fa-info-circle"></i>
                        Pastikan semua informasi yang diisi sudah benar sebelum menyimpan
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Sidebar -->
        <div class="preview-sidebar">
            <div class="preview-card">
                <h3 class="preview-title">
                    <i class="fas fa-eye"></i>
                    Preview Produk
                </h3>

                <div class="preview-content">
                    <!-- Image Preview -->
                    <div class="preview-image">
                        <img id="previewImageDisplay" src="https://via.placeholder.com/300x300?text=No+Image" alt="Product Preview">
                    </div>

                    <!-- Product Info -->
                    <div class="preview-info">
                        <h4 id="previewName">Nama Produk</h4>
                        <div class="preview-code" id="previewCode">Kode: -</div>
                        <div class="preview-category" id="previewCategory">Kategori: -</div>
                        <div class="preview-price" id="previewPrice">Harga: Rp 0</div>
                        <div class="preview-stock" id="previewStock">Stok: 0</div>
                    </div>

                    <!-- Description Preview -->
                    <div class="preview-description">
                        <h5>Deskripsi:</h5>
                        <p id="previewDescription">Belum ada deskripsi</p>
                    </div>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="validation-card">
                <h3 class="validation-title">
                    <i class="fas fa-check-circle"></i>
                    Validasi Form
                </h3>

                <ul class="validation-list">
                    <li class="validation-item" id="validationName">
                        <i class="fas fa-circle"></i>
                        <span>Nama produk</span>
                    </li>
                    <li class="validation-item" id="validationCode">
                        <i class="fas fa-circle"></i>
                        <span>Kode produk</span>
                    </li>
                    <li class="validation-item" id="validationCategory">
                        <i class="fas fa-circle"></i>
                        <span>Kategori</span>
                    </li>
                    <li class="validation-item" id="validationPrice">
                        <i class="fas fa-circle"></i>
                        <span>Harga jual</span>
                    </li>
                    <li class="validation-item" id="validationStock">
                        <i class="fas fa-circle"></i>
                        <span>Stok awal</span>
                    </li>
                </ul>

                <div class="validation-status" id="validationStatus">
                    <span>0 dari 5 valid</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Form Layout */
    .product-form-container {
        padding-bottom: 40px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 14px;
    }

    /* Form Wrapper */
    .form-wrapper {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    @media (max-width: 1200px) {
        .form-wrapper {
            grid-template-columns: 1fr;
        }
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-header {
        padding: 20px 30px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-steps {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .step {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--light);
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-light);
    }

    .step.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .step-line {
        width: 30px;
        height: 2px;
        background: var(--border);
    }

    /* Form Body */
    .form-body {
        padding: 30px;
    }

    .form-section {
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid var(--light);
    }

    .form-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .required-note, .optional-note {
        font-size: 12px;
        color: var(--text-light);
        font-style: italic;
    }

    /* Grid System */
    .grid {
        display: grid;
        gap: 20px;
        margin-bottom: 20px;
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    @media (max-width: 768px) {
        .grid-2, .grid-3 {
            grid-template-columns: 1fr;
        }
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }

    .required {
        color: var(--danger);
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control.error {
        border-color: var(--danger);
        background: rgba(239, 68, 68, 0.05);
    }

    .form-control.error:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 6px;
        line-height: 1.4;
    }

    /* Input Groups */
    .input-group {
        position: relative;
        display: flex;
    }

    .input-group .form-control {
        flex: 1;
        padding-right: 50px;
    }

    .input-action {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--light);
        border: 1px solid var(--border);
        border-radius: 6px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.2s ease;
    }

    .input-action:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Category Select */
    .category-select {
        display: flex;
        gap: 10px;
    }

    .category-select .form-control {
        flex: 1;
    }

    .category-actions {
        display: flex;
        align-items: center;
    }

    .btn-text {
        background: none;
        border: none;
        color: var(--primary);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px;
        transition: color 0.2s ease;
    }

    .btn-text:hover {
        color: var(--primary-dark);
    }

    /* Textarea */
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .textarea-info {
        text-align: right;
        font-size: 12px;
        color: var(--text-light);
        margin-top: 4px;
    }

    /* Price Input */
    .price-input {
        position: relative;
    }

    .currency-prefix {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 600;
        color: var(--primary);
        pointer-events: none;
    }

    .price-input .form-control {
        padding-left: 45px;
    }

    /* Profit Display */
    .profit-display {
        background: var(--light);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .profit-percentage {
        font-size: 14px;
        color: var(--success);
        font-weight: 600;
    }

    /* Image Upload */
    .image-upload-container {
        margin-top: 10px;
    }

    .upload-area {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--light);
    }

    .upload-area:hover {
        border-color: var(--primary);
        background: rgba(37, 99, 235, 0.05);
    }

    .upload-area i {
        font-size: 48px;
        color: var(--text-light);
        margin-bottom: 16px;
    }

    .upload-area h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .upload-area p {
        color: var(--text-light);
        margin: 4px 0;
    }

    .upload-info {
        font-size: 12px;
    }

    .file-input {
        display: none;
    }

    .image-preview {
        margin-top: 20px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .preview-container {
        position: relative;
        width: 200px;
        height: 200px;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: white;
    }

    .preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: rgba(0, 0, 0, 0.6);
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
    }

    .remove-image:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .image-info {
        margin-top: 10px;
        font-size: 14px;
        color: var(--text);
    }

    .image-info small {
        color: var(--text-light);
        display: block;
        margin-top: 2px;
    }

    /* Checkbox */
    .checkbox-group {
        margin-top: 10px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        width: 20px;
        height: 20px;
        background: white;
        border: 2px solid var(--border);
        border-radius: 4px;
        margin-right: 10px;
        position: relative;
        transition: all 0.2s ease;
    }

    .checkbox-label input:checked ~ .checkmark {
        background: var(--primary);
        border-color: var(--primary);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 6px;
        top: 2px;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .checkbox-label input:checked ~ .checkmark:after {
        display: block;
    }

    .checkbox-text {
        font-size: 14px;
        color: var(--text);
        font-weight: 500;
    }

    /* Error Messages */
    .error-message {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--danger);
        font-size: 13px;
        margin-top: 6px;
        background: rgba(239, 68, 68, 0.1);
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 3px solid var(--danger);
    }

    /* Form Footer */
    .form-footer {
        padding: 20px 30px;
        border-top: 1px solid var(--border);
        background: var(--light);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-note {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-light);
        font-size: 13px;
        padding: 12px;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border);
    }

    .form-note i {
        color: var(--primary);
    }

    /* Buttons */
    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-secondary {
        background: white;
        color: var(--text);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: var(--light);
        border-color: var(--text-light);
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

    /* Preview Sidebar */
    .preview-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .preview-card, .validation-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .preview-title, .validation-title {
        padding: 20px;
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .preview-content {
        padding: 20px;
    }

    .preview-image {
        width: 100%;
        height: 200px;
        border-radius: 8px;
        overflow: hidden;
        background: var(--light);
        border: 1px solid var(--border);
        margin-bottom: 20px;
    }

    .preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-info {
        margin-bottom: 20px;
    }

    .preview-info h4 {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .preview-code, .preview-category, .preview-price, .preview-stock {
        font-size: 14px;
        color: var(--text);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .preview-description h5 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .preview-description p {
        font-size: 13px;
        color: var(--text-light);
        line-height: 1.5;
        max-height: 100px;
        overflow-y: auto;
    }

    /* Validation Card */
    .validation-list {
        padding: 20px;
        margin: 0;
        list-style: none;
    }

    .validation-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid var(--light);
    }

    .validation-item:last-child {
        border-bottom: none;
    }

    .validation-item i {
        color: var(--text-light);
        font-size: 8px;
    }

    .validation-item.valid i {
        color: var(--success);
    }

    .validation-item.invalid i {
        color: var(--danger);
    }

    .validation-status {
        padding: 15px 20px;
        border-top: 1px solid var(--border);
        text-align: center;
        font-weight: 600;
        color: var(--dark);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize character counter
        const descriptionTextarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        if (descriptionTextarea && charCount) {
            descriptionTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
            // Set initial count
            charCount.textContent = descriptionTextarea.value.length;
        }

        // Initialize form validation
        setupFormValidation();

        // Setup live preview
        setupLivePreview();

        // Calculate profit on price change
        document.getElementById('price')?.addEventListener('input', calculateProfit);
        document.getElementById('cost_price')?.addEventListener('input', calculateProfit);
    });

    // Generate product code
    function generateProductCode() {
        const timestamp = Date.now().toString().slice(-6);
        const random = Math.floor(Math.random() * 100).toString().padStart(2, '0');
        const code = `PRD-${timestamp}${random}`;
        document.getElementById('code').value = code;
        updateValidation('code');
        updatePreview('code', code);
    }

    // Generate barcode
    function generateBarcode() {
        const timestamp = Date.now().toString();
        const barcode = timestamp.slice(-12);
        document.getElementById('barcode').value = barcode;
    }

    // Calculate profit
    function calculateProfit() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const cost = parseFloat(document.getElementById('cost_price').value) || 0;

        const profit = price - cost;
        const percentage = cost > 0 ? ((profit / cost) * 100).toFixed(1) : 0;

        document.getElementById('profitAmount').textContent = formatCurrency(profit);
        document.getElementById('profitPercentage').textContent = `${percentage}%`;

        // Update percentage color
        const percentageElement = document.getElementById('profitPercentage');
        if (percentage > 0) {
            percentageElement.style.color = 'var(--success)';
        } else if (percentage < 0) {
            percentageElement.style.color = 'var(--danger)';
        } else {
            percentageElement.style.color = 'var(--text-light)';
        }
    }

    // Image preview
    function previewImage(input) {
        const uploadArea = document.getElementById('uploadArea');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const previewImageDisplay = document.getElementById('previewImageDisplay');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                showAlert('error', 'Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }

            // Validate file type
            if (!file.type.match('image.*')) {
                showAlert('error', 'Hanya file gambar yang diizinkan.');
                input.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                uploadArea.style.display = 'none';
                imagePreview.style.display = 'block';
                previewImage.src = e.target.result;
                previewImageDisplay.src = e.target.result;
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
            }

            reader.readAsDataURL(file);
        }
    }

    // Remove image
    function removeImage() {
        const uploadArea = document.getElementById('uploadArea');
        const imagePreview = document.getElementById('imagePreview');
        const previewImageDisplay = document.getElementById('previewImageDisplay');
        const fileInput = document.querySelector('.file-input');

        uploadArea.style.display = 'block';
        imagePreview.style.display = 'none';
        previewImageDisplay.src = 'https://via.placeholder.com/300x300?text=No+Image';
        fileInput.value = '';
    }

    // Setup form validation
    function setupFormValidation() {
        const form = document.getElementById('productForm');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                updateValidation(this.id);
            });
            input.addEventListener('change', function() {
                updateValidation(this.id);
            });

            // Initialize validation state
            updateValidation(input.id);
        });
    }

    // Update validation status
    function updateValidation(fieldId) {
        const input = document.getElementById(fieldId);
        const validationItem = document.getElementById(`validation${capitalizeFirstLetter(fieldId)}`);

        if (!input || !validationItem) return;

        if (input.validity.valid && (input.value.trim() !== '' || !input.required)) {
            validationItem.classList.add('valid');
            validationItem.classList.remove('invalid');
            validationItem.querySelector('i').className = 'fas fa-check-circle';
            validationItem.querySelector('i').style.color = 'var(--success)';
        } else {
            validationItem.classList.add('invalid');
            validationItem.classList.remove('valid');
            validationItem.querySelector('i').className = 'fas fa-times-circle';
            validationItem.querySelector('i').style.color = 'var(--danger)';
        }

        updateValidationStatus();
    }

    // Update overall validation status
    function updateValidationStatus() {
        const validationItems = document.querySelectorAll('.validation-item');
        const validCount = document.querySelectorAll('.validation-item.valid').length;
        const totalCount = validationItems.length;

        const statusElement = document.getElementById('validationStatus');
        statusElement.textContent = `${validCount} dari ${totalCount} valid`;

        // Update status color
        if (validCount === totalCount) {
            statusElement.style.color = 'var(--success)';
        } else if (validCount > 0) {
            statusElement.style.color = 'var(--warning)';
        } else {
            statusElement.style.color = 'var(--danger)';
        }
    }

    // Setup live preview
    function setupLivePreview() {
        const previewFields = ['name', 'code', 'price', 'stock', 'description'];

        previewFields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    updatePreview(field, this.value);
                });
                // Initialize preview
                updatePreview(field, input.value);
            }
        });

        // Handle category select
        const categorySelect = document.getElementById('category_id');
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                updatePreview('category', selectedOption.text);
                updateValidation('category_id');
            });
        }
    }

    // Update preview
    function updatePreview(field, value) {
        const previewElements = {
            'name': document.getElementById('previewName'),
            'code': document.getElementById('previewCode'),
            'price': document.getElementById('previewPrice'),
            'stock': document.getElementById('previewStock'),
            'description': document.getElementById('previewDescription'),
            'category': document.getElementById('previewCategory')
        };

        if (previewElements[field]) {
            switch(field) {
                case 'price':
                    previewElements[field].textContent = `Harga: ${formatCurrency(value || 0)}`;
                    break;
                case 'stock':
                    previewElements[field].textContent = `Stok: ${value || 0}`;
                    break;
                case 'code':
                    previewElements[field].textContent = value ? `Kode: ${value}` : 'Kode: -';
                    break;
                case 'category':
                    previewElements[field].textContent = value ? `Kategori: ${value}` : 'Kategori: -';
                    break;
                case 'description':
                    previewElements[field].textContent = value || 'Belum ada deskripsi';
                    break;
                default:
                    previewElements[field].textContent = value || `[${field}]`;
            }
        }
    }

    // Reset form
    function resetForm() {
        if (confirm('Reset form ke keadaan awal?')) {
            document.getElementById('productForm').reset();
            removeImage();

            // Reset preview
            updatePreview('name', '');
            updatePreview('code', '');
            updatePreview('category', '');
            updatePreview('price', '0');
            updatePreview('stock', '0');
            updatePreview('description', '');

            // Reset validation
            document.querySelectorAll('.validation-item').forEach(item => {
                item.classList.remove('valid', 'invalid');
                item.querySelector('i').className = 'fas fa-circle';
                item.querySelector('i').style.color = 'var(--text-light)';
            });

            updateValidationStatus();

            // Reset character count
            const charCount = document.getElementById('charCount');
            if (charCount) charCount.textContent = '0';

            // Reset profit calculation
            calculateProfit();

            showAlert('info', 'Form telah direset.');
        }
    }

    // Show category modal (placeholder function)
    function showCategoryModal() {
        alert('Fitur tambah kategori akan diimplementasikan');
        // In production, you would show a modal here
    }

    // Helper functions
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function formatCurrency(amount) {
        const num = parseFloat(amount) || 0;
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showAlert(type, message) {
        // Simple alert for demo purposes
        alert(message);
    }
</script>
@endsection
