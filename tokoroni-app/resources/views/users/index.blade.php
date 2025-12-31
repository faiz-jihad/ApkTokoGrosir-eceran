@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div class="mb-3 mb-md-0">
                <nav aria-label="breadcrumb" class="d-inline-block">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-1">
                    <i class="fas fa-users me-2 text-primary"></i>Manajemen Pengguna
                </h1>
                <p class="text-muted mb-0">Kelola data dan akses pengguna sistem</p>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2">
                @if ($users->count() > 0)
                    <button class="btn btn-outline-secondary" id="toggle-columns-btn">
                        <i class="fas fa-columns me-2"></i>Kolom
                    </button>
                @endif
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Baru
                </a>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mt-1 me-3 fs-4"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Berhasil!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mt-1 me-3 fs-4"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Gagal!</h6>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Pengguna</p>
                                <h2 class="fw-bold mb-0">{{ $stats['total'] ?? 0 }}</h2>
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-history me-1"></i>Total semua pengguna
                                </small>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-users fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Aktif</p>
                                <h2 class="fw-bold mb-0">{{ $stats['active'] ?? 0 }}</h2>
                                <small class="text-muted d-flex align-items-center">
                                    @if ($stats['active_percentage'] > 0)
                                        <i class="fas fa-chart-line me-1 text-success"></i>
                                        {{ number_format($stats['active_percentage'], 1) }}% dari total
                                    @endif
                                </small>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-user-check fa-lg text-success"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: {{ $stats['active_percentage'] ?? 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Owner</p>
                                <h2 class="fw-bold mb-0">{{ $stats['owners'] ?? 0 }}</h2>
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-user-shield me-1"></i>Akses penuh sistem
                                </small>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-crown fa-lg text-warning"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            @php
                                $ownerPercentage = $stats['total'] > 0 ? ($stats['owners'] / $stats['total']) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-warning" style="width: {{ $ownerPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Kasir</p>
                                <h2 class="fw-bold mb-0">{{ $stats['kasir'] ?? 0 }}</h2>
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-cash-register me-1"></i>Akses transaksi
                                </small>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-cash-register fa-lg text-info"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            @php
                                $kasirPercentage = $stats['total'] > 0 ? ($stats['kasir'] / $stats['total']) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-info" style="width: {{ $kasirPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm" id="quick-filter-active">
                                <i class="fas fa-user-check me-1"></i>Aktif
                            </button>
                            <button class="btn btn-outline-warning btn-sm" id="quick-filter-owner">
                                <i class="fas fa-crown me-1"></i>Owner
                            </button>
                            <button class="btn btn-outline-info btn-sm" id="quick-filter-kasir">
                                <i class="fas fa-cash-register me-1"></i>Kasir
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" id="quick-filter-gudang">
                                <i class="fas fa-boxes me-1"></i>Gudang
                            </button>
                            <button class="btn btn-outline-danger btn-sm" id="quick-filter-inactive">
                                <i class="fas fa-user-slash me-1"></i>Nonaktif
                            </button>
                            <div class="ms-auto">
                                <button class="btn btn-outline-success btn-sm" id="export-quick">
                                    <i class="fas fa-file-export me-1"></i>Export
                                </button>
                                <button class="btn btn-outline-dark btn-sm" id="print-quick">
                                    <i class="fas fa-print me-1"></i>Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <div class="mb-3 mb-md-0">
                        <h6 class="fw-semibold mb-1">
                            <i class="fas fa-filter me-2 text-primary"></i>Filter Pengguna
                        </h6>
                        <small class="text-muted">Filter berdasarkan kriteria tertentu</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Cari nama atau email..."
                                id="search-input" aria-label="Cari pengguna">
                            <button class="btn btn-outline-secondary" type="button" id="clear-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterCollapse">
                            <i class="fas fa-sliders-h me-1"></i>Filter Lanjutan
                        </button>
                    </div>
                </div>

                <div class="collapse" id="filterCollapse">
                    <div class="border-top pt-3 mt-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user-tag me-1"></i>Peran Pengguna
                                </label>
                                <select class="form-select select2-filter" id="role-filter">
                                    <option value="">Semua Peran</option>
                                    <option value="owner">Owner</option>
                                    <option value="gudang">Gudang</option>
                                    <option value="kasir">Kasir</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-circle me-1"></i>Status Akun
                                </label>
                                <select class="form-select select2-filter" id="status-filter">
                                    <option value="">Semua Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-sort me-1"></i>Urutkan
                                </label>
                                <select class="form-select select2-filter" id="sort-filter">
                                    <option value="latest">Terbaru</option>
                                    <option value="oldest">Terlama</option>
                                    <option value="name_asc">Nama A-Z</option>
                                    <option value="name_desc">Nama Z-A</option>
                                    <option value="role">Peran</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100" id="apply-filters">
                                    <i class="fas fa-search me-1"></i>Terapkan Filter
                                </button>
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar me-1"></i>Tanggal Bergabung
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="date-from"
                                        placeholder="Dari tanggal">
                                    <span class="input-group-text bg-light">sampai</span>
                                    <input type="date" class="form-control" id="date-to"
                                        placeholder="Sampai tanggal">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button class="btn btn-outline-secondary w-100" id="reset-filters">
                                    <i class="fas fa-redo me-1"></i>Reset Semua Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pengguna -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-2 mb-md-0">
                        <h6 class="fw-semibold mb-1">
                            <i class="fas fa-list me-2 text-primary"></i>Daftar Pengguna
                        </h6>
                        <small class="text-muted">
                            <span id="filter-info">Menampilkan {{ $users->count() }} dari {{ $users->total() }}
                                pengguna</span>
                            <span class="badge bg-info ms-2" id="active-filter-badge" style="display: none;"></span>
                        </small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if ($users->count() > 0)
                            <div class="input-group input-group-sm" style="width: 160px;">
                                <span class="input-group-text bg-light">Tampilkan</span>
                                <select class="form-select" id="per-page-select">
                                    <option value="5" {{ request('per_page', 15) == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15
                                    </option>
                                    <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50
                                    </option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="users-table">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th class="fw-semibold">Pengguna</th>
                                <th class="fw-semibold column-email">Email</th>
                                <th class="fw-semibold column-role">Peran</th>
                                <th class="fw-semibold column-status">Status</th>
                                <th class="fw-semibold">Bergabung</th>
                                <th class="fw-semibold">Terakhir Login</th>
                                <th class="pe-4 text-end fw-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body">
                            @forelse($users as $user)
                                <tr class="user-row" data-user-id="{{ $user->id }}" data-role="{{ $user->role }}"
                                    data-status="{{ $user->is_active ? 'active' : 'inactive' }}"
                                    data-email="{{ strtolower($user->email) }}"
                                    data-name="{{ strtolower($user->name) }}"
                                    data-joined="{{ $user->created_at->format('Y-m-d') }}">
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input user-checkbox" type="checkbox"
                                                value="{{ $user->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                @if ($user->image && file_exists(public_path('storage/' . $user->image)))
                                                    <img src="{{ asset('storage/' . $user->image) }}"
                                                        alt="Foto {{ $user->name }}"
                                                        class="rounded-circle border border-3 border-white shadow user-avatar"
                                                        width="48" height="48" style="object-fit: cover;"
                                                        loading="lazy">
                                                @else
                                                    <div class="rounded-circle bg-primary bg-gradient d-flex align-items-center justify-content-center border border-3 border-white shadow user-avatar"
                                                        style="width: 48px; height: 48px;">
                                                        <span class="text-white fw-bold fs-5">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <span
                                                    class="position-absolute bottom-0 end-0 bg-{{ $user->is_active ? 'success' : 'danger' }} border border-2 border-white rounded-circle"
                                                    style="width: 14px; height: 14px;"
                                                    title="{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}"
                                                    data-bs-toggle="tooltip"></span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-id-card me-1"></i>ID: {{ $user->id }}
                                                </small>
                                                @if ($user->phone)
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-phone me-1"></i>{{ $user->phone }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-email">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope text-muted me-2"></i>
                                            <a href="mailto:{{ $user->email }}"
                                                class="text-decoration-none text-truncate" style="max-width: 200px;">
                                                {{ $user->email }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="column-role">
                                        <span
                                            class="badge bg-{{ $user->role == 'owner' ? 'warning' : ($user->role == 'gudang' ? 'info' : 'primary') }} bg-opacity-10 text-{{ $user->role == 'owner' ? 'warning' : ($user->role == 'gudang' ? 'info' : 'primary') }} border border-{{ $user->role == 'owner' ? 'warning' : ($user->role == 'gudang' ? 'info' : 'primary') }} border-opacity-25 p-2 d-inline-flex align-items-center">
                                            @if ($user->role == 'owner')
                                                <i class="fas fa-crown me-2"></i>
                                            @elseif($user->role == 'gudang')
                                                <i class="fas fa-boxes me-2"></i>
                                            @else
                                                <i class="fas fa-cash-register me-2"></i>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="column-status">
                                        <span
                                            class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}-subtle text-{{ $user->is_active ? 'success' : 'danger' }} border border-{{ $user->is_active ? 'success' : 'danger' }} border-opacity-25 p-2 d-inline-flex align-items-center">
                                            <i class="fas fa-circle me-2" style="font-size: 8px;"></i>
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            <div>{{ $user->created_at->format('d M Y') }}</div>
                                            <small class="d-block">{{ $user->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->last_login_at)
                                            <div class="text-muted">
                                                <div>{{ $user->last_login_at->format('d M Y') }}</div>
                                                <small class="d-block">{{ $user->last_login_at->format('H:i') }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum login</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.toggle-status', $user->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-{{ $user->is_active ? 'danger' : 'success' }}"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($user->role !== 'owner')
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}"
                                                    data-user-email="{{ $user->email }}"
                                                    data-user-role="{{ ucfirst($user->role) }}" data-bs-toggle="tooltip"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-users-slash fa-4x text-muted mb-4 opacity-50"></i>
                                            <h5 class="fw-semibold mb-3">Tidak Ada Pengguna</h5>
                                            <p class="text-muted mb-4">Belum ada pengguna yang terdaftar dalam sistem</p>
                                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg px-4">
                                                <i class="fas fa-user-plus me-2"></i>Tambah Pengguna Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="card-footer bg-white border-top py-3 d-none" id="bulk-actions">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="me-3" id="selected-count">0 pengguna dipilih</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success btn-sm" id="bulk-activate">
                                <i class="fas fa-check me-1"></i>Aktifkan
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="bulk-deactivate">
                                <i class="fas fa-ban me-1"></i>Nonaktifkan
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="bulk-delete">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="bulk-export">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-selection">
                        <i class="fas fa-times me-1"></i>Bersihkan Pilihan
                    </button>
                </div>
            </div>

            @if ($users->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="text-muted mb-2 mb-md-0">
                            <span id="pagination-info">
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari
                                {{ $users->total() }} pengguna
                            </span>
                        </div>
                        <div class="mb-2 mb-md-0">
                            <nav aria-label="Navigasi halaman">
                                {{ $users->onEachSide(1)->links() }}
                            </nav>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-2">Halaman</span>
                            <input type="number" class="form-control form-control-sm" style="width: 70px;"
                                id="page-input" min="1" max="{{ $users->lastPage() }}"
                                value="{{ $users->currentPage() }}">
                            <span class="text-muted ms-2">dari {{ $users->lastPage() }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold">Konfirmasi Penghapusan</h5>
                            <small class="text-muted">Tindakan ini akan menghapus pengguna secara permanen</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="alert alert-danger border-danger border-opacity-25">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle mt-1 me-3"></i>
                            <div>
                                <strong>Peringatan!</strong> Data yang dihapus tidak dapat dikembalikan
                            </div>
                        </div>
                    </div>
                    <div id="user-info" class="mb-3"></div>
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="confirm-delete">
                        <label class="form-check-label" for="confirm-delete">
                            Saya memahami bahwa tindakan ini tidak dapat dibatalkan
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="delete-form" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="delete-button" disabled>
                            <i class="fas fa-trash me-2"></i>Hapus Pengguna
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-file-export text-primary"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold">Export Data Pengguna</h5>
                            <small class="text-muted">Pilih format dan data yang ingin diexport</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Format Export</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="export-format" id="format-excel"
                                    value="excel" checked>
                                <label class="btn btn-outline-success w-100" for="format-excel">
                                    <i class="fas fa-file-excel me-2"></i>Excel
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="export-format" id="format-csv"
                                    value="csv">
                                <label class="btn btn-outline-primary w-100" for="format-csv">
                                    <i class="fas fa-file-csv me-2"></i>CSV
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="export-format" id="format-pdf"
                                    value="pdf">
                                <label class="btn btn-outline-danger w-100" for="format-pdf">
                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Data yang Diexport</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="export-data" id="export-all"
                                value="all" checked>
                            <label class="form-check-label" for="export-all">
                                Semua pengguna ({{ $users->total() }} data)
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="export-data" id="export-filtered"
                                value="filtered">
                            <label class="form-check-label" for="export-filtered">
                                Hasil filter saat ini
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="export-data" id="export-selected"
                                value="selected">
                            <label class="form-check-label" for="export-selected">
                                Data terpilih (<span id="export-selected-count">0</span> data)
                            </label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Kolom yang Disertakan</label>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-name" checked
                                        data-col="name">
                                    <label class="form-check-label" for="col-name">Nama Pengguna</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-email" checked
                                        data-col="email">
                                    <label class="form-check-label" for="col-email">Email</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-role" checked
                                        data-col="role">
                                    <label class="form-check-label" for="col-role">Peran</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-phone"
                                        data-col="phone">
                                    <label class="form-check-label" for="col-phone">Telepon</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-status" checked
                                        data-col="status">
                                    <label class="form-check-label" for="col-status">Status</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-joined" checked
                                        data-col="joined_at">
                                    <label class="form-check-label" for="col-joined">Tanggal Bergabung</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-last-login"
                                        data-col="last_login">
                                    <label class="form-check-label" for="col-last-login">Terakhir Login</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input export-col" type="checkbox" id="col-id"
                                        data-col="id">
                                    <label class="form-check-label" for="col-id">ID Pengguna</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="start-export">
                        <i class="fas fa-download me-2"></i>Mulai Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Columns Modal -->
    <div class="modal fade" id="columnsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-columns text-primary"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold">Kelola Kolom Tabel</h5>
                            <small class="text-muted">Tampilkan/sembunyikan kolom yang diinginkan</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih Kolom yang Ditampilkan</label>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" id="toggle-email"
                                        data-column="email" checked>
                                    <label class="form-check-label" for="toggle-email">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" id="toggle-role"
                                        data-column="role" checked>
                                    <label class="form-check-label" for="toggle-role">
                                        <i class="fas fa-user-tag me-2"></i>Peran
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" id="toggle-status"
                                        data-column="status" checked>
                                    <label class="form-check-label" for="toggle-status">
                                        <i class="fas fa-circle me-2"></i>Status
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" id="toggle-last-login"
                                        data-column="last-login" checked>
                                    <label class="form-check-label" for="toggle-last-login">
                                        <i class="fas fa-sign-in-alt me-2"></i>Terakhir Login
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" id="show-all-columns">
                            <i class="fas fa-eye me-1"></i>Tampilkan Semua
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="hide-all-columns">
                            <i class="fas fa-eye-slash me-1"></i>Sembunyikan Semua
                        </button>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
       /* ======================================================
   DESIGN SYSTEM
====================================================== */
:root {
    --primary: #2563eb;
    --success: #16a34a;
    --warning: #f59e0b;
    --danger: #dc2626;
    --info: #0891b2;

    --bg: #f8fafc;
    --card: #ffffff;
    --border: #e5e7eb;

    --text: #111827;
    --muted: #6b7280;
}

body {
    background: var(--bg);
    color: var(--text);
    font-size: 14px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* ======================================================
   HEADER
====================================================== */
h1, h2, h3, h4, h5, h6 {
    color: var(--text);
    font-weight: 600;
}

.breadcrumb {
    padding: 0;
    margin-bottom: 6px;
    background: none;
}

.breadcrumb a {
    color: var(--primary);
    text-decoration: none;
}

/* ======================================================
   CARD
====================================================== */
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: none;
}

.card-header,
.card-footer {
    background: none;
    border-color: var(--border);
}

.card-body {
    padding: 1.25rem;
}

/* ======================================================
   STATISTIC CARD
====================================================== */
.card-body h2 {
    font-size: 1.8rem;
    font-weight: 700;
}

.card-body p {
    color: var(--muted);
    font-size: 13px;
}

.progress {
    height: 3px;
    background: #e5e7eb;
    border-radius: 10px;
}

/* ======================================================
   BUTTON
====================================================== */
.btn {
    border-radius: 8px;
    font-weight: 500;
}

.btn-primary {
    background: var(--primary);
    border-color: var(--primary);
}

.btn-outline-primary:hover,
.btn-outline-danger:hover,
.btn-outline-warning:hover,
.btn-outline-success:hover {
    color: #fff;
}

/* ======================================================
   FILTER & SEARCH
====================================================== */
.input-group .form-control {
    border-radius: 8px;
}

.input-group .form-control:focus {
    border-color: var(--primary);
    box-shadow: none;
}

/* ======================================================
   TABLE
====================================================== */
.table {
    margin: 0;
}

.table thead th {
    background: #f1f5f9;
    border-bottom: 1px solid var(--border);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--muted);
    padding: 14px;
}

.table tbody td {
    padding: 14px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.table tbody tr:hover {
    background: #f8fafc;
}

/* ======================================================
   USER AVATAR
====================================================== */
.user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
}

/* ======================================================
   BADGE
====================================================== */
.badge {
    font-size: 11px;
    font-weight: 600;
    border-radius: 8px;
    padding: 6px 10px;
}

/* ======================================================
   ACTION BUTTON GROUP
====================================================== */
.btn-group .btn {
    padding: 6px 10px;
}

/* ======================================================
   BULK ACTION BAR
====================================================== */
#bulk-actions {
    background: var(--card);
    border-top: 1px solid var(--border);
}

/* ======================================================
   PAGINATION
====================================================== */
.pagination .page-link {
    border-radius: 8px;
    margin: 0 2px;
    color: var(--primary);
}

.pagination .active .page-link {
    background: var(--primary);
    border-color: var(--primary);
}

/* ======================================================
   MODAL
====================================================== */
.modal-content {
    border-radius: 14px;
    border: none;
}

.modal-header,
.modal-footer {
    border-color: var(--border);
}

/* ======================================================
   ALERT
====================================================== */
.alert {
    border-radius: 10px;
    font-size: 13px;
}

/* ======================================================
   RESPONSIVE (MOBILE)
====================================================== */
@media (max-width: 768px) {
    h1 {
        font-size: 1.4rem;
    }

    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        border: 1px solid var(--border);
        border-radius: 12px;
        margin-bottom: 12px;
        background: #fff;
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 12px;
        border-bottom: 1px solid var(--border);
    }

    .table tbody td:last-child {
        border-bottom: none;
    }
}

    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize Select2
            $('.select2-filter').select2({
                theme: 'bootstrap-5',
                width: 'style',
                placeholder: "Pilih...",
                allowClear: true
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Show columns modal
            $('#toggle-columns-btn').on('click', function() {
                $('#columnsModal').modal('show');
            });

            // Toggle column visibility
            $('.column-toggle').on('change', function() {
                var column = $(this).data('column');
                var isChecked = $(this).is(':checked');

                if (column === 'last-login') {
                    $('th:nth-child(7), td:nth-child(7)').toggle(isChecked);
                } else {
                    $('.column-' + column).toggle(isChecked);
                }

                // Store preference in localStorage
                var preferences = JSON.parse(localStorage.getItem('column-preferences') || '{}');
                preferences[column] = isChecked;
                localStorage.setItem('column-preferences', JSON.stringify(preferences));
            });

            // Show all columns
            $('#show-all-columns').on('click', function() {
                $('.column-toggle').prop('checked', true).trigger('change');
            });

            // Hide all columns
            $('#hide-all-columns').on('click', function() {
                $('.column-toggle').prop('checked', false).trigger('change');
            });

            // Load column preferences
            function loadColumnPreferences() {
                var savedPreferences = JSON.parse(localStorage.getItem('column-preferences') || '{}');
                $.each(savedPreferences, function(column, visible) {
                    $('.column-toggle[data-column="' + column + '"]').prop('checked', visible).trigger(
                        'change');
                });
            }
            loadColumnPreferences();

            // Search with debounce
            var searchTimeout;
            $('#search-input').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    filterTable();
                }, 300);
            });

            // Clear search
            $('#clear-search').on('click', function() {
                $('#search-input').val('');
                filterTable();
            });

            // Quick filter buttons
            $('#quick-filter-active').on('click', function() {
                $('#status-filter').val('1').trigger('change');
                filterTable();
                updateFilterBadge('Aktif');
            });

            $('#quick-filter-inactive').on('click', function() {
                $('#status-filter').val('0').trigger('change');
                filterTable();
                updateFilterBadge('Nonaktif');
            });

            $('#quick-filter-owner').on('click', function() {
                $('#role-filter').val('owner').trigger('change');
                filterTable();
                updateFilterBadge('Owner');
            });

            $('#quick-filter-kasir').on('click', function() {
                $('#role-filter').val('kasir').trigger('change');
                filterTable();
                updateFilterBadge('Kasir');
            });

            $('#quick-filter-gudang').on('click', function() {
                $('#role-filter').val('gudang').trigger('change');
                filterTable();
                updateFilterBadge('Gudang');
            });

            // Export quick button
            $('#export-quick').on('click', function() {
                $('#exportModal').modal('show');
            });

            // Print quick button
            $('#print-quick').on('click', function() {
                window.print();
            });

            // Filter table
            function filterTable() {
                var search = $('#search-input').val().toLowerCase();
                var role = $('#role-filter').val();
                var status = $('#status-filter').val();
                var dateFrom = $('#date-from').val();
                var dateTo = $('#date-to').val();
                var sort = $('#sort-filter').val();

                var visibleCount = 0;
                var totalCount = $('.user-row').length;

                $('.user-row').each(function() {
                    var $row = $(this);
                    var matches = true;

                    // Search filter
                    if (search) {
                        var name = $row.data('name') || '';
                        var email = $row.data('email') || '';
                        if (name.indexOf(search) === -1 && email.indexOf(search) === -1) {
                            matches = false;
                        }
                    }

                    // Role filter
                    if (role && $row.data('role') !== role) {
                        matches = false;
                    }

                    // Status filter
                    if (status !== '' && $row.data('status') !== (status === '1' ? 'active' : 'inactive')) {
                        matches = false;
                    }

                    // Date filter
                    if (dateFrom && $row.data('joined') < dateFrom) {
                        matches = false;
                    }
                    if (dateTo && $row.data('joined') > dateTo) {
                        matches = false;
                    }

                    if (matches) {
                        $row.show();
                        visibleCount++;
                    } else {
                        $row.hide();
                    }
                });

                // Sort table
                sortTable(sort);

                // Update filter info
                $('#filter-info').text('Menampilkan ' + visibleCount + ' dari ' + totalCount + ' pengguna');

                // Show/hide empty state
                if (visibleCount === 0 && totalCount > 0) {
                    $('#users-table-body').append(`
                <tr id="no-results">
                    <td colspan="8" class="text-center py-5">
                        <div class="py-4">
                            <i class="fas fa-search fa-3x text-muted mb-3 opacity-50"></i>
                            <h5 class="fw-semibold mb-2">Tidak Ditemukan</h5>
                            <p class="text-muted mb-0">Tidak ada pengguna yang sesuai dengan filter</p>
                            <button class="btn btn-outline-primary mt-3" id="clear-all-filters">
                                <i class="fas fa-redo me-1"></i>Reset Filter
                            </button>
                        </div>
                    </td>
                </tr>
            `);
                } else {
                    $('#no-results').remove();
                }
            }

            // Sort table
            function sortTable(sortType) {
                var $tbody = $('#users-table-body');
                var $rows = $tbody.find('.user-row:visible').get();

                $rows.sort(function(a, b) {
                    var $a = $(a);
                    var $b = $(b);

                    switch (sortType) {
                        case 'latest':
                            return new Date($b.data('joined')) - new Date($a.data('joined'));
                        case 'oldest':
                            return new Date($a.data('joined')) - new Date($b.data('joined'));
                        case 'name_asc':
                            return $a.data('name').localeCompare($b.data('name'));
                        case 'name_desc':
                            return $b.data('name').localeCompare($a.data('name'));
                        case 'role':
                            return $a.data('role').localeCompare($b.data('role'));
                        default:
                            return 0;
                    }
                });

                $.each($rows, function(index, row) {
                    $tbody.append(row);
                });
            }

            // Update filter badge
            function updateFilterBadge(text) {
                $('#active-filter-badge').text(text).show();
            }

            // Clear all filters
            $(document).on('click', '#clear-all-filters', function() {
                resetFilters();
            });

            // Reset filters
            function resetFilters() {
                $('#search-input').val('');
                $('#role-filter').val('').trigger('change');
                $('#status-filter').val('').trigger('change');
                $('#date-from').val('');
                $('#date-to').val('');
                $('#sort-filter').val('latest').trigger('change');
                $('#active-filter-badge').hide();
                filterTable();
            }

            $('#reset-filters').on('click', resetFilters);

            // Apply filters
            $('#apply-filters').on('click', function() {
                filterTable();
                $('#filterCollapse').collapse('hide');
            });

            // Per page selector
            $('#per-page-select').on('change', function() {
                var perPage = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', '1');
                window.location.href = url.toString();
            });

            // Page input
            $('#page-input').on('change', function() {
                var page = Math.max(1, Math.min($(this).val(), {{ $users->lastPage() }}));
                var url = new URL(window.location.href);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            });

            // Select all checkbox
            $('#select-all').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.user-checkbox').prop('checked', isChecked);
                updateBulkActions();
            });

            // Individual checkbox change
            $(document).on('change', '.user-checkbox', function() {
                var allChecked = $('.user-checkbox').length === $('.user-checkbox:checked').length;
                $('#select-all').prop('checked', allChecked);
                updateBulkActions();
            });

            // Update bulk actions
            function updateBulkActions() {
                var selectedCount = $('.user-checkbox:checked').length;
                if (selectedCount > 0) {
                    $('#selected-count').text(selectedCount + ' pengguna dipilih');
                    $('#export-selected-count').text(selectedCount);
                    $('#bulk-actions').removeClass('d-none');
                } else {
                    $('#bulk-actions').addClass('d-none');
                }
            }

            // Clear selection
            $('#clear-selection').on('click', function() {
                $('.user-checkbox').prop('checked', false);
                $('#select-all').prop('checked', false);
                updateBulkActions();
            });

            // Bulk activate
            $('#bulk-activate').on('click', function() {
                var selectedIds = $('.user-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    if (confirm('Aktifkan ' + selectedIds.length + ' pengguna terpilih?')) {
                        $.ajax({
                            url: '{{ route('users.bulk-activate') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selectedIds
                            },
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                }
            });

            // Bulk deactivate
            $('#bulk-deactivate').on('click', function() {
                var selectedIds = $('.user-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    if (confirm('Nonaktifkan ' + selectedIds.length + ' pengguna terpilih?')) {
                        $.ajax({
                            url: '{{ route('users.bulk-deactivate') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selectedIds
                            },
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                }
            });

            // Bulk export
            $('#bulk-export').on('click', function() {
                $('#exportModal').modal('show');
                $('#export-selected').prop('checked', true);
            });

            // Delete modal
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                var userName = button.data('user-name');
                var userEmail = button.data('user-email');
                var userRole = button.data('user-role');

                $('#user-info').html(`
            <div class="d-flex align-items-center p-3 bg-light rounded">
                <div class="me-3">
                    <div class="rounded-circle bg-primary bg-gradient d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <span class="text-white fw-bold fs-4">
                            ${userName.charAt(0).toUpperCase()}
                        </span>
                    </div>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">${userName}</h6>
                    <p class="text-muted mb-1">${userEmail}</p>
                    <span class="badge bg-secondary">${userRole}</span>
                </div>
            </div>
        `);

                $('#delete-form').attr('action', '/users/' + userId);
                $('#confirm-delete').prop('checked', false);
                $('#delete-button').prop('disabled', true);
            });

            // Confirm delete checkbox
            $('#confirm-delete').on('change', function() {
                $('#delete-button').prop('disabled', !$(this).prop('checked'));
            });

            // Export modal
            $('#export-users, #export-quick').on('click', function() {
                $('#exportModal').modal('show');
            });

            // Start export
            $('#start-export').on('click', function() {
                var format = $('input[name="export-format"]:checked').val();
                var dataType = $('input[name="export-data"]:checked').val();

                // Collect selected columns
                var columns = [];
                $('.export-col:checked').each(function() {
                    columns.push($(this).data('col'));
                });

                // Build export URL
                var url = new URL('{{ route('users.export') }}');
                url.searchParams.set('format', format);
                url.searchParams.set('data', dataType);
                url.searchParams.set('columns', columns.join(','));

                // Add current filter parameters
                var search = $('#search-input').val();
                var role = $('#role-filter').val();
                var status = $('#status-filter').val();

                if (search) url.searchParams.set('search', search);
                if (role) url.searchParams.set('role', role);
                if (status) url.searchParams.set('status', status);

                // Add selected IDs if exporting selected
                if (dataType === 'selected') {
                    var selectedIds = $('.user-checkbox:checked').map(function() {
                        return $(this).val();
                    }).get();
                    if (selectedIds.length > 0) {
                        url.searchParams.set('ids', selectedIds.join(','));
                    }
                }

                window.open(url.toString(), '_blank');
                $('#exportModal').modal('hide');
            });

            // Initialize table with current filters
            filterTable();

            // Make table rows clickable (except for action buttons)
            $(document).on('click', '.user-row td:not(:first-child):not(:last-child)', function() {
                var userId = $(this).closest('tr').data('user-id');
                window.location.href = '/users/' + userId;
            });
        });
    </script>
@endpush
