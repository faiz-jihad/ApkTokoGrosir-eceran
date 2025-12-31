@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>Dashboard Kasir</h1>
    <p>Selamat bekerja, {{ Auth::user()->name }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $todayTransactions }}</div>
                <div class="stat-label">Transaksi Hari Ini</div>
            </div>
            <div class="stat-icon orders">
                <i class="fas fa-cash-register"></i>
            </div>
        </div>
    </div>
</div>

@endsection
