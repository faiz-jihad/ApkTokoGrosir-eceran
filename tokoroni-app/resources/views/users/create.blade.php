@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="main-content">
    <div class="page-header">
        <div class="page-title-container">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-plus mr-2"></i>Tambah User Baru
                </h1>
                <p class="page-subtitle">Tambahkan pengguna baru ke sistem</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="form-container">
            <!-- Validation Errors -->
            @if($errors->any())
            <div class="alert alert-danger fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-3 fa-lg"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Terjadi Kesalahan!</h6>
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success fade show mb-4" role="alert">
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

            <div class="form-card">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="form-header-content">
                        <h3 class="form-title">Form Tambah User</h3>
                        <p class="form-subtitle">Isi semua informasi yang diperlukan untuk membuat user baru</p>
                    </div>
                </div>

                <div class="form-body">
                    <form method="POST" action="{{ route('users.store') }}" id="userForm">
                        @csrf

                        <div class="form-row">
                            <!-- Informasi Dasar -->
                            <div class="form-col">
                                <div class="form-section">
                                    <div class="form-section-header">
                                        <i class="fas fa-id-card mr-2"></i>
                                        <h4 class="form-section-title">Informasi Dasar</h4>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            Nama Lengkap
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="Masukkan nama lengkap"
                                                   required
                                                   autofocus>
                                        </div>
                                        @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        <div class="form-hint">
                                            Nama lengkap pengguna (minimal 3 karakter)
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            Alamat Email
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="contoh@email.com"
                                                   required>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        <div class="form-hint">
                                            Email akan digunakan untuk login
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            Nomor Telepon
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone') }}"
                                                   placeholder="08xxxxxxxxxx">
                                        </div>
                                        @error('phone')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        <div class="form-hint">
                                            Nomor telepon aktif (opsional)
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keamanan & Role -->
                            <div class="form-col">
                                <div class="form-section">
                                    <div class="form-section-header">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        <h4 class="form-section-title">Keamanan & Role</h4>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            Password
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                            </div>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   id="password"
                                                   name="password"
                                                   placeholder="Minimal 8 karakter"
                                                   required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror

                                        <div class="password-strength mt-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="strength-label">Kekuatan Password:</span>
                                                <span id="strengthText" class="strength-text"></span>
                                            </div>
                                            <div class="strength-bar">
                                                <div id="strengthBar" class="strength-progress"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">
                                            Konfirmasi Password
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                            </div>
                                            <input type="password"
                                                   class="form-control"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   placeholder="Ulangi password"
                                                   required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="passwordMatch" class="form-hint mt-2"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="role" class="form-label">
                                            Role
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user-tag"></i>
                                                </span>
                                            </div>
                                            <select class="form-control @error('role') is-invalid @enderror"
                                                    id="role"
                                                    name="role"
                                                    required>
                                                <option value="">Pilih Role</option>
                                                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>
                                                    Kasir
                                                </option>
                                                <option value="gudang" {{ old('role') == 'gudang' ? 'selected' : '' }}>
                                                    Gudang
                                                </option>
                                                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>
                                                    Owner
                                                </option>
                                            </select>
                                        </div>
                                        @error('role')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        <div class="form-hint">
                                            Tentukan hak akses pengguna
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            Status Akun
                                        </label>
                                        <div class="status-toggle-group">
                                            <div class="status-toggle">
                                                <input type="checkbox"
                                                       class="status-checkbox"
                                                       id="is_active"
                                                       name="is_active"
                                                       value="1"
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label for="is_active" class="status-label">
                                                    <span class="status-slider"></span>
                                                    <span class="status-text">Aktif</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-hint">
                                            Nonaktifkan jika tidak ingin pengguna bisa login
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="form-section mt-4">
                            <div class="form-section-header">
                                <i class="fas fa-info-circle mr-2"></i>
                                <h4 class="form-section-title">Informasi Tambahan</h4>
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">
                                    Alamat Lengkap
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                    </div>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <div class="form-actions-left">
                                <button type="reset" class="btn btn-secondary" id="resetBtn">
                                    <i class="fas fa-redo mr-2"></i> Reset Form
                                </button>
                            </div>
                            <div class="form-actions-right">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i> Simpan User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Form Container */
.form-container {
    max-width: 1200px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    transition: var(--transition);
}

.form-card:hover {
    box-shadow: var(--shadow-xl);
}

/* Form Header */
.form-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    padding: 28px 32px;
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
}

.form-header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    backdrop-filter: blur(10px);
}

.form-header-content {
    flex: 1;
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
}

.form-subtitle {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
}

/* Form Body */
.form-body {
    padding: 32px;
}

/* Form Layout */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    margin-bottom: 24px;
}

.form-col {
    min-width: 0;
}

/* Form Sections */
.form-section {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 24px;
    height: 100%;
    transition: var(--transition);
}

.form-section:hover {
    border-color: var(--primary-light);
    box-shadow: var(--shadow);
}

.form-section-header {
    display: flex;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid var(--primary-50);
}

.form-section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
}

.form-section-header i {
    color: var(--primary);
    font-size: 20px;
}

/* Form Elements */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 8px;
    letter-spacing: 0.2px;
}

.form-label .required {
    color: var(--danger);
    margin-left: 4px;
}

/* Input Groups */
.input-group {
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid var(--border);
    transition: var(--transition);
}

.input-group:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.input-group-text {
    background: var(--primary-50);
    border: none;
    color: var(--primary);
    padding: 0 16px;
    font-size: 14px;
    border-radius: 0;
}

.form-control {
    border: none;
    padding: 12px 16px;
    font-size: 14px;
    color: var(--text);
    background: white;
    border-radius: 0;
    transition: none;
}

.form-control:focus {
    box-shadow: none;
    background: white;
}

.form-control::placeholder {
    color: var(--text-light);
    opacity: 0.6;
}

.form-control.is-invalid {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23ef4444' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 16px 16px;
    padding-right: 48px;
}

/* Input Group Append */
.input-group-append .btn {
    background: var(--light);
    border: none;
    border-left: 1px solid var(--border);
    color: var(--text-light);
    padding: 0 20px;
    transition: var(--transition);
}

.input-group-append .btn:hover {
    background: var(--primary);
    color: white;
}

/* Form Hints */
.form-hint {
    font-size: 12px;
    color: var(--text-light);
    margin-top: 6px;
    line-height: 1.4;
}

/* Password Strength */
.password-strength {
    background: var(--light);
    border-radius: var(--radius);
    padding: 12px 16px;
    margin-top: 16px;
}

.strength-label {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 500;
}

.strength-text {
    font-size: 12px;
    font-weight: 600;
}

.strength-text.text-danger { color: var(--danger); }
.strength-text.text-warning { color: var(--warning); }
.strength-text.text-info { color: var(--primary); }
.strength-text.text-success { color: var(--success); }

.strength-bar {
    height: 6px;
    background: var(--border);
    border-radius: 3px;
    overflow: hidden;
    margin-top: 8px;
}

.strength-progress {
    height: 100%;
    border-radius: 3px;
    width: 0%;
    transition: width 0.3s ease, background-color 0.3s ease;
}

.strength-progress.bg-danger { background: var(--danger); }
.strength-progress.bg-warning { background: var(--warning); }
.strength-progress.bg-info { background: var(--primary); }
.strength-progress.bg-success { background: var(--success); }

/* Password Match */
#passwordMatch {
    font-size: 13px;
    font-weight: 500;
    min-height: 20px;
}

#passwordMatch i {
    margin-right: 6px;
}

#passwordMatch.match {
    color: var(--success);
}

#passwordMatch.mismatch {
    color: var(--danger);
}

/* Status Toggle */
.status-toggle-group {
    display: flex;
    align-items: center;
    margin-top: 8px;
}

.status-toggle {
    position: relative;
    display: inline-block;
}

.status-checkbox {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.status-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    gap: 12px;
}

.status-slider {
    position: relative;
    width: 52px;
    height: 26px;
    background: var(--border);
    border-radius: 34px;
    transition: .4s;
}

.status-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: .4s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.status-checkbox:checked + .status-label .status-slider {
    background: var(--success);
}

.status-checkbox:checked + .status-label .status-slider:before {
    transform: translateX(26px);
}

.status-text {
    font-weight: 600;
    color: var(--text);
    font-size: 14px;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 32px 0 16px;
    border-top: 1px solid var(--border);
    margin-top: 32px;
}

.form-actions-left,
.form-actions-right {
    display: flex;
    gap: 12px;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 14px;
    border-radius: var(--radius-lg);
    transition: var(--transition);
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
    letter-spacing: 0.3px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: white;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
}

.btn-secondary {
    background: white;
    color: var(--text);
    border-color: var(--border);
}

.btn-secondary:hover {
    background: var(--light);
    border-color: var(--text-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.btn-outline-secondary {
    background: transparent;
    color: var(--text-light);
    border-color: var(--border);
}

.btn-outline-secondary:hover {
    background: var(--light);
    border-color: var(--text-light);
    color: var(--text);
    transform: translateY(-2px);
}

/* Alerts */
.alert {
    border-radius: var(--radius-lg);
    border: none;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
    animation: slideDown 0.3s ease-out;
}

.alert-success {
    background: linear-gradient(135deg, var(--success-50) 0%, white 100%);
    border-left: 4px solid var(--success);
    color: var(--dark);
}

.alert-danger {
    background: linear-gradient(135deg, var(--danger-50) 0%, white 100%);
    border-left: 4px solid var(--danger);
    color: var(--dark);
}

.alert-heading {
    font-weight: 700;
    margin-bottom: 4px;
    font-size: 15px;
}

.alert .close {
    padding: 0.75rem 1.25rem;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.alert .close:hover {
    opacity: 1;
}

/* Invalid Feedback */
.invalid-feedback {
    display: flex;
    align-items: center;
    color: var(--danger);
    font-size: 12px;
    margin-top: 6px;
    font-weight: 500;
}

.invalid-feedback i {
    margin-right: 6px;
    font-size: 14px;
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    top: 24px;
    right: 24px;
    background: white;
    border-radius: var(--radius-lg);
    padding: 16px 20px;
    box-shadow: var(--shadow-xl);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 9999;
    animation: slideInRight 0.3s ease-out;
    border-left: 4px solid;
    max-width: 380px;
    min-width: 300px;
}

.toast-success {
    border-left-color: var(--success);
    background: linear-gradient(135deg, var(--success-50) 0%, white 100%);
}

.toast-error {
    border-left-color: var(--danger);
    background: linear-gradient(135deg, var(--danger-50) 0%, white 100%);
}

.toast-warning {
    border-left-color: var(--warning);
    background: linear-gradient(135deg, var(--warning-50) 0%, white 100%);
}

.toast-info {
    border-left-color: var(--primary);
    background: linear-gradient(135deg, var(--primary-50) 0%, white 100%);
}

.toast-icon {
    font-size: 20px;
}

.toast-success .toast-icon {
    color: var(--success);
}

.toast-error .toast-icon {
    color: var(--danger);
}

.toast-warning .toast-icon {
    color: var(--warning);
}

.toast-info .toast-icon {
    color: var(--primary);
}

.toast-message {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    color: var(--dark);
}

.toast-close {
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 4px;
    font-size: 12px;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.toast-close:hover {
    color: var(--text);
}

/* Animations */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .form-container {
        padding: 0 16px;
    }
}

@media (max-width: 992px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .form-col {
        width: 100%;
    }

    .form-section {
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .form-body {
        padding: 24px;
    }

    .form-header {
        padding: 24px;
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }

    .form-header-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }

    .form-title {
        font-size: 20px;
    }

    .form-actions {
        flex-direction: column;
        gap: 16px;
    }

    .form-actions-left,
    .form-actions-right {
        width: 100%;
        justify-content: center;
    }

    .form-actions-left {
        order: 2;
    }

    .form-actions-right {
        order: 1;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .form-body {
        padding: 20px;
    }

    .form-section {
        padding: 16px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .input-group-text {
        padding: 0 12px;
        font-size: 13px;
    }

    .form-control {
        padding: 10px 12px;
        font-size: 13px;
    }

    .form-label {
        font-size: 13px;
    }

    .form-hint {
        font-size: 11px;
    }

    .toast-notification {
        max-width: calc(100% - 48px);
        min-width: auto;
        right: 12px;
        left: 12px;
    }
}

/* Loading State */
.loading {
    position: relative;
    pointer-events: none;
    opacity: 0.7;
}

.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

/* Focus States */
.form-control:focus,
.btn:focus,
.select:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Print Styles */
@media print {
    .form-header,
    .form-actions,
    .btn,
    .toast-notification {
        display: none !important;
    }

    .form-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

    .form-section {
        break-inside: avoid;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const togglePasswordConfirmBtn = document.getElementById('togglePasswordConfirmation');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const passwordMatchDiv = document.getElementById('passwordMatch');
    const userForm = document.getElementById('userForm');
    const resetBtn = document.getElementById('resetBtn');
    const statusCheckbox = document.getElementById('is_active');
    const phoneInput = document.getElementById('phone');
    const alerts = document.querySelectorAll('.alert');
    const closeButtons = document.querySelectorAll('.alert .close');

    // Toggle password visibility
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.setAttribute('aria-label', 'Tampilkan password');
            }
        });
    }

    // Toggle password confirmation visibility
    if (togglePasswordConfirmBtn) {
        togglePasswordConfirmBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (passwordConfirmInput.type === 'password') {
                passwordConfirmInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                passwordConfirmInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.setAttribute('aria-label', 'Tampilkan password');
            }
        });
    }

    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        if (password.length >= 12) strength++;

        return strength;
    }

    // Update password strength indicator
    function updatePasswordStrength() {
        const password = passwordInput.value;
        const strength = checkPasswordStrength(password);

        if (!strengthBar || !strengthText) return;

        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthBar.className = 'strength-progress';
            strengthText.textContent = '';
            strengthText.className = 'strength-text';
            return;
        }

        if (strength < 2) {
            strengthBar.style.width = '25%';
            strengthBar.className = 'strength-progress bg-danger';
            strengthText.textContent = 'Lemah';
            strengthText.className = 'strength-text text-danger';
        } else if (strength < 4) {
            strengthBar.style.width = '50%';
            strengthBar.className = 'strength-progress bg-warning';
            strengthText.textContent = 'Sedang';
            strengthText.className = 'strength-text text-warning';
        } else if (strength < 6) {
            strengthBar.style.width = '75%';
            strengthBar.className = 'strength-progress bg-info';
            strengthText.textContent = 'Kuat';
            strengthText.className = 'strength-text text-info';
        } else {
            strengthBar.style.width = '100%';
            strengthBar.className = 'strength-progress bg-success';
            strengthText.textContent = 'Sangat Kuat';
            strengthText.className = 'strength-text text-success';
        }
    }

    // Check password match
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmInput.value;

        if (!passwordMatchDiv) return;

        if (confirmation.length === 0) {
            passwordMatchDiv.innerHTML = '';
            passwordMatchDiv.className = '';
            return;
        }

        if (password === confirmation) {
            passwordMatchDiv.innerHTML = '<i class="fas fa-check-circle"></i> Password cocok';
            passwordMatchDiv.classList.add('match');
            passwordMatchDiv.classList.remove('mismatch');
        } else {
            passwordMatchDiv.innerHTML = '<i class="fas fa-times-circle"></i> Password tidak cocok';
            passwordMatchDiv.classList.add('mismatch');
            passwordMatchDiv.classList.remove('match');
        }
    }

    // Event listeners for password inputs
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            updatePasswordStrength();
            checkPasswordMatch();
        });
    }

    if (passwordConfirmInput) {
        passwordConfirmInput.addEventListener('input', checkPasswordMatch);
    }

    // Auto-hide alerts after 5 seconds
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert && alert.classList.contains('show')) {
                const closeBtn = alert.querySelector('.close');
                if (closeBtn) {
                    closeBtn.click();
                }
            }
        }, 5000);
    });

    // Form validation on submit
    if (userForm) {
        userForm.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmation = passwordConfirmInput.value;

            // Check password match
            if (password !== confirmation) {
                e.preventDefault();
                showToast('error', 'Password dan konfirmasi password tidak cocok!');
                passwordConfirmInput.focus();
                return false;
            }

            // Check password strength
            if (password.length < 8) {
                e.preventDefault();
                showToast('error', 'Password minimal 8 karakter!');
                passwordInput.focus();
                return false;
            }

            const strength = checkPasswordStrength(password);
            if (strength < 2) {
                e.preventDefault();
                showToast('warning', 'Password terlalu lemah! Gunakan kombinasi huruf dan angka.');
                passwordInput.focus();
                return false;
            }

            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            }

            return true;
        });
    }

    // Reset form button
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
                userForm.reset();
                updatePasswordStrength();
                checkPasswordMatch();

                // Reset status toggle
                if (statusCheckbox) {
                    statusCheckbox.checked = true;
                    const statusText = statusCheckbox.parentElement.querySelector('.status-text');
                    if (statusText) {
                        statusText.textContent = 'Aktif';
                    }
                }

                showToast('info', 'Form telah direset ke nilai default');
            }
        });
    }

    // Update status toggle text
    if (statusCheckbox) {
        statusCheckbox.addEventListener('change', function() {
            const statusText = this.parentElement.querySelector('.status-text');
            if (statusText) {
                statusText.textContent = this.checked ? 'Aktif' : 'Nonaktif';
            }
        });
    }

    // Auto format phone number
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');

            if (value.length > 0) {
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }

                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.substring(0, 3) + '-' + value.substring(3);
                } else if (value.length <= 10) {
                    value = value.substring(0, 3) + '-' + value.substring(3, 6) + '-' + value.substring(6);
                } else {
                    value = value.substring(0, 3) + '-' + value.substring(3, 7) + '-' + value.substring(7, 11);
                }
            }

            this.value = value;
        });
    }

    // Toast notification function
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
            </div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" aria-label="Tutup notifikasi">
                <i class="fas fa-times"></i>
            </button>
        `;

        document.body.appendChild(toast);

        // Auto remove after 5 seconds
        const autoRemove = setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);

        // Close button
        const closeBtn = toast.querySelector('.toast-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                clearTimeout(autoRemove);
                toast.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            });
        }
    }

    // Bootstrap alert dismiss
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.3s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }
        });
    });

    // Initialize
    updatePasswordStrength();
    checkPasswordMatch();
});
</script>
@endpush
