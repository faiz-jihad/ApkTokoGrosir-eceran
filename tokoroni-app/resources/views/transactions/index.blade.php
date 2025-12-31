<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POS System') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===================== CSS VARIABLES ===================== */
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --light: #f8fafc;
            --border: #e2e8f0;
            --border-dark: #334155;
            --text: #1e293b;
            --text-light: #64748b;
            --text-white: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --sidebar-width: 260px;
        }

        /* ===================== RESET & BASE ===================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: #f8fafc;
            color: var(--text);
            line-height: 1.6;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: #f8fafc;
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: white;
        }

        .logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .logo span {
            font-size: 1.125rem;
            font-weight: 700;
            color: white;
        }

        /* ===================== USER PROFILE ===================== */
        .user-profile {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--light);
        }

        .user-avatar {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 1.25rem;
            border: 3px solid white;
            box-shadow: var(--shadow);
        }

        .user-info {
            flex: 1;
        }

        .user-info h4 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }

        .role-badge.owner {
            background: var(--success);
            color: white;
        }

        .role-badge.kasir {
            background: var(--primary);
            color: white;
        }

        .role-badge.gudang {
            background: var(--warning);
            color: white;
        }

        /* ===================== NAVIGATION MENU ===================== */
        .nav-menu {
            list-style: none;
            padding: 1rem 0.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .nav-menu li {
            margin-bottom: 0.125rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link i {
            width: 1.25rem;
            text-align: center;
            font-size: 1rem;
            color: var(--secondary);
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            background: var(--light);
            color: var(--primary);
            transform: translateX(2px);
        }

        .nav-link:hover i {
            color: var(--primary);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
            color: var(--primary);
            font-weight: 600;
            border-left: 3px solid var(--primary);
        }

        .nav-link.active i {
            color: var(--primary);
        }

        /* ===================== SIDEBAR FOOTER ===================== */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border);
            background: var(--light);
        }

        .sidebar-footer form {
            width: 100%;
        }

        .logout-btn {
            width: 100%;
            background: white;
            border: 1px solid var(--border);
            color: var(--danger);
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
        }

        /* ===================== MAIN CONTENT ===================== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ===================== PAGE HEADER ===================== */
        .page-header {
            background: white;
            padding: 1.875rem 2.5rem;
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .page-header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .page-header p {
            font-size: 0.875rem;
            color: var(--text-light);
            max-width: 600px;
            line-height: 1.5;
        }

        /* ===================== CONTENT WRAPPER ===================== */
        .content-wrapper {
            flex: 1;
            padding: 2.5rem;
            background: #f8fafc;
        }

        /* ===================== FOOTER ===================== */
        .footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 1.25rem 2.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-light);
            margin-top: auto;
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 1200px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 20px 0 40px rgba(0, 0, 0, 0.1);
            }

            .main-content {
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 99;
            }

            .overlay.active {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .content-wrapper {
                padding: 1.5rem;
            }

            .footer {
                padding: 1rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .page-header h1 {
                font-size: 1.5rem;
            }
        }

        /* ===================== UTILITY CLASSES ===================== */
        .bg-white {
            background: white !important;
        }

        .shadow-sm {
            box-shadow: var(--shadow-sm) !important;
        }

        .shadow {
            box-shadow: var(--shadow) !important;
        }

        .shadow-lg {
            box-shadow: var(--shadow-lg) !important;
        }

        .rounded {
            border-radius: var(--radius) !important;
        }

        .rounded-lg {
            border-radius: var(--radius-lg) !important;
        }

        .border {
            border: 1px solid var(--border) !important;
        }

        .p-4 {
            padding: 1rem !important;
        }

        .p-6 {
            padding: 1.5rem !important;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }

        .mb-6 {
            margin-bottom: 1.5rem !important;
        }

        .mt-4 {
            margin-top: 1rem !important;
        }

        .mt-6 {
            margin-top: 1.5rem !important;
        }

        .text-sm {
            font-size: 0.875rem !important;
        }

        .text-lg {
            font-size: 1.125rem !important;
        }

        .text-xl {
            font-size: 1.25rem !important;
        }

        .font-semibold {
            font-weight: 600 !important;
        }

        .font-bold {
            font-weight: 700 !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-success {
            color: var(--success) !important;
        }

        .text-danger {
            color: var(--danger) !important;
        }

        .text-muted {
            color: var(--text-light) !important;
        }
    </style>
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

        <!-- User Profile -->
        <div class="user-profile">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
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

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <!-- OWNER -->
            @if(auth()->user()->role === 'owner')
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
                    <a href="{{ route('transactions.index') }}"
                       class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i> Riwayat Transaksi
                    </a>
                </li>
            @endif

            <!-- KASIR -->
            @if(auth()->user()->role === 'kasir')
                <li>
                    <a href="{{ route('transactions.index') }}"
                       class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                        <i class="fas fa-cash-register"></i> Transaksi
                    </a>
                </li>
            @endif

            <!-- OWNER & GUDANG -->
            @if(in_array(auth()->user()->role, ['owner','gudang']))
                <li>
                    <a href="{{ route('products.index') }}"
                       class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Produk
                    </a>
                </li>
            @endif

            <!-- PROFILE -->
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

    <!-- ================= MAIN CONTENT ================= -->
    <main class="main-content">
        <!-- Page Header -->
        <header class="page-header">
            <h1>@yield('title','Dashboard')</h1>
            <p>@yield('subtitle','Selamat datang, '.Auth::user()->name)</p>
        </header>

        <!-- 🔥 CONTENT WRAPPER YANG DIBUTUHKAN -->
        <section class="content-wrapper">
            @yield('content')
        </section>

        <!-- Footer -->
        <footer class="footer">
            © {{ date('Y') }} {{ config('app.name') }}
        </footer>
    </main>
</div>

<!-- Mobile Menu Toggle (Optional) -->
<button class="menu-toggle" style="display: none;">
    <i class="fas fa-bars"></i>
</button>

<div class="overlay"></div>

<script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');

        if (menuToggle && sidebar && overlay) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // Auto-hide sidebar on mobile
        function checkScreenSize() {
            if (window.innerWidth <= 992) {
                menuToggle.style.display = 'block';
            } else {
                menuToggle.style.display = 'none';
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        }

        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
    });
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>
