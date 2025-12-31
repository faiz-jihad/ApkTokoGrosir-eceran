<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POS System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body class="bg-gray-100">
    <div class="dashboard-container">

        <!-- ================= SIDEBAR ================= -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="logo">
                    <div class="logo-icon"><i class="fas fa-store"></i></div>
                    <span>Toko Roni Juntinyuat</span>
                </a>
            </div>

            <!-- User -->
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="role-badge {{ Auth::user()->role }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>
                </div>
            </div>

            <!-- ================= MENU ================= -->
            <ul class="nav-menu">

                {{-- DASHBOARD (SEMUA ROLE) --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>

                {{-- OWNER --}}
                @if (Auth::user()->role === 'owner')
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('reports.index') }}"
                            class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i> Reports
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('transactions.history') }}"
                            class="nav-link {{ request()->routeIs('transactions.history') ? 'active' : '' }}">
                            <i class="fas fa-receipt"></i> Riwayat Transaksi
                        </a>
                    </li>
                @endif

                {{-- KASIR --}}
                @if (in_array(Auth::user()->role ,['kasir', 'owner']))
                    <li>
                        <a href="{{ route('transactions.index') }}"
                            class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                            <i class="fas fa-cash-register"></i> Transaksi
                        </a>
                    </li>
                @endif

                {{-- OWNER & GUDANG --}}
                @if (in_array(Auth::user()->role, ['owner', 'gudang']))
                    <li>
                        <a href="{{ route('products.index') }}"
                            class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i> Produk
                        </a>
                    </li>
                @endif

                {{-- PROFILE --}}
                <li>
                    <a href="{{ route('profile.edit') }}"
                        class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>

            </ul>


            <!-- Logout -->
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MAIN ================= -->
        <main class="main-content">

            <section class="content-wrapper">
                @yield('content')
                @push('styles')
            </section>


            <footer class="footer">
                © {{ date('Y') }} {{ config('app.name') }}
            </footer>
        </main>
    </div>
</body>

</html>
