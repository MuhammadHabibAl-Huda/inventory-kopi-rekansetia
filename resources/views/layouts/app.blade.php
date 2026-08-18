<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory - Kedai Kopi Rekan Setia')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --sidebar-width: 272px; --sidebar-bg: #0f172a; --sidebar-hover: #1e293b;
            --sidebar-active: linear-gradient(135deg, #b45309, #d97706); --accent: #d97706;
            --accent-light: #fbbf24; --bg-main: #f1f5f9; --card-bg: #ffffff;
            --text-primary: #0f172a; --text-secondary: #475569; --text-muted: #94a3b8;
            --border: #e2e8f0; --success: #10b981; --success-bg: #d1fae5;
            --danger: #ef4444; --danger-bg: #fee2e2; --warning: #f59e0b;
            --warning-bg: #fef3c7; --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.05);
            --radius: 12px; --radius-sm: 8px; --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-primary); min-height: 100vh; overflow-x: hidden; }
        .app-layout { display: flex; min-height: 100vh; }
        
        /* Sidebar Styling */
        .sidebar { width: var(--sidebar-width); background: var(--sidebar-bg); position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; display: flex; flex-direction: column; transition: transform 0.3s ease; overflow-y: auto; }
        .sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .sidebar-brand-icon { width: 44px; height: 44px; background: linear-gradient(135deg, #b45309, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px; }
        .sidebar-brand h1 { color: #ffffff; font-size: 17px; font-weight: 700; line-height: 1.3; }
        .sidebar-brand p { color: #64748b; font-size: 12px; margin-top: 4px; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-nav-label { color: #475569; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; padding: 8px 14px 10px; }
        
        /* Menu Link Item */
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 10px; color: #94a3b8; font-size: 14px; font-weight: 500; cursor: pointer; transition: var(--transition); text-decoration: none; border: none; background: none; width: 100%; text-align: left; margin-bottom: 2px; }
        .nav-item:hover { background: var(--sidebar-hover); color: #e2e8f0; }
        .nav-item.active { background: var(--sidebar-active); color: #ffffff; font-weight: 600; }
        .nav-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); flex-shrink: 0; }
        .nav-item.active .nav-icon { background: rgba(255,255,255,0.2); }
        .nav-item-text { display: flex; flex-direction: column; }
        .nav-item-text span:last-child { font-size: 11px; color: #64748b; margin-top: 1px; }
        .nav-item.active .nav-item-text span:last-child { color: rgba(255,255,255,0.7); }
        
        .sidebar-footer { padding: 16px 14px; border-top: 1px solid rgba(255,255,255,0.06); }
        .user-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px; display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #b45309, #d97706); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #ffffff; flex-shrink: 0; }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 13px; font-weight: 600; color: #e2e8f0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 20px; margin-top: 3px; text-transform: uppercase; }
        .role-admin { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .role-barista { background: rgba(96, 165, 250, 0.15); color: #60a5fa; }
        .btn-logout { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px 14px; background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; color: #fca5a5; font-size: 13px; font-weight: 600; cursor: pointer; transition: var(--transition); }
        .btn-logout:hover { background: rgba(239, 68, 68, 0.15); color: #f87171; }
        .sidebar-copyright { color: #334155; font-size: 10px; text-align: center; margin-top: 10px; }

        /* Content Styling */
        .main-content { flex: 1; margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: rgba(255,255,255,0.92); border-bottom: 1px solid var(--border); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; backdrop-filter: blur(8px); }
        .topbar-title h2 { font-size: 20px; font-weight: 700; color: var(--text-primary); }
        .topbar-title p { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }
        .topbar-date { display: flex; align-items: center; gap: 8px; background: var(--bg-main); padding: 8px 16px; border-radius: 10px; font-size: 13px; color: var(--text-secondary); font-weight: 500; }
        .page-content { padding: 28px 32px 40px; }

        /* Generic Components */
        .toast { padding: 14px 20px; border-radius: var(--radius-sm); margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 500; }
        .toast-success { background: var(--success-bg); color: #065f46; border: 1px solid #a7f3d0; }
        .toast-error { background: var(--danger-bg); color: #991b1b; border: 1px solid #fca5a5; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: var(--card-bg); border-radius: var(--radius); padding: 22px 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); position: relative; overflow: hidden; }
        .stat-card-label { font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
        .stat-card-value { font-size: 28px; font-weight: 800; color: var(--text-primary); }
        .data-card { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--border); overflow: hidden; }
        .data-card-header { padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); }
        .data-card-header h3 { font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th { padding: 12px 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); background: #f8fafc; border-bottom: 1px solid var(--border); text-align: left; }
        .data-table tbody td { padding: 14px 20px; font-size: 14px; color: var(--text-secondary); border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .form-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--border); overflow: hidden; max-width: 560px; }
        .form-card-header { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
        .form-body { padding: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .form-select, .form-input, .form-textarea { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 14px; font-family: inherit; outline: none; }
        .btn-primary { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px 20px; background: linear-gradient(135deg, #b45309, #d97706); color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: var(--radius-sm); cursor: pointer; }
        .btn-danger-submit { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px 20px; background: linear-gradient(135deg, #b91c1c, #ef4444); color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: var(--radius-sm); cursor: pointer; }
        /* Header Icon — digunakan di card header seluruh halaman */
        .header-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .header-icon.amber  { background: rgba(217,119,6,0.12); color: #b45309; }
        .header-icon.green  { background: rgba(16,185,129,0.12); color: #059669; }
        .header-icon.blue   { background: rgba(59,130,246,0.12); color: #2563eb; }
        .header-icon.orange { background: rgba(234,88,12,0.12);  color: #ea580c; }
        /* Cell & Table Utilities */
        .cell-bold { font-weight: 600; color: var(--text-primary); }
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; background: var(--bg-main); border: 1px solid var(--border); border-radius: 20px; font-size: 12px; font-weight: 600; color: var(--text-secondary); }
        /* Form Utilities */
        .form-label-sub { font-weight: 400; color: var(--text-muted); font-size: 12px; }
        .mobile-toggle { display: none; position: fixed; top: 16px; left: 16px; z-index: 200; width: 42px; height: 42px; border-radius: 10px; background: var(--sidebar-bg); color: #fff; border: none; font-size: 20px; cursor: pointer; align-items: center; justify-content: center; }
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 90; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: flex; }
            .overlay.active { display: block; }
            .topbar { padding: 16px 20px 16px 64px; }
            .page-content { padding: 20px 16px 32px; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <button class="mobile-toggle" onclick="toggleSidebar()" id="menuToggle">☰</button>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="app-layout">
        <!-- SIDEBAR NAVIGASI -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Rekan Setia" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                </div>
                <h1>Kedai Kopi<br>Rekan Setia</h1>
                <p>Inventory Management System</p>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-nav-label">Menu Utama</div>

                {{-- 1. Live Monitoring / Dashboard --}}
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Live Monitoring</span>
                        <span>Pantau stok real-time</span>
                    </div>
                </a>

                {{-- 2. Kelola Bahan Baku --}}
                <a href="{{ route('bahan-baku.index') }}" class="nav-item {{ request()->routeIs('bahan-baku.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Kelola Bahan Baku</span>
                        <span>Restock &amp; penyusutan</span>
                    </div>
                </a>

                {{-- 3. Laporan (Riwayat & Unduh PDF) --}}
                <a href="{{ route('riwayat.index') }}" class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Laporan</span>
                        <span>Riwayat &amp; unduh PDF</span>
                    </div>
                </a>

                {{-- 4. Produk & Resep --}}
                <a href="{{ route('produk.index') }}" class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Produk & Resep</span>
                        <span>Daftar menu & komposisi</span>
                    </div>
                </a>

                @if(Auth::user()->isAdmin())
                <div class="sidebar-nav-label" style="margin-top: 12px;">Admin Only</div>

                {{-- 5. Manajemen User --}}
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Manajemen User</span>
                        <span>Kelola akun barista</span>
                    </div>
                </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                @auth
                <div class="user-card">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <span class="user-role-badge {{ Auth::user()->role === 'admin' ? 'role-admin' : 'role-barista' }}">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
                @endauth
                <p class="sidebar-copyright">© {{ date('Y') }} Kedai Kopi Rekan Setia</p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <header class="topbar">
                <div class="topbar-title">
                    <h2 id="page-title">@yield('page_title', 'Live Monitoring Stok')</h2>
                    <p id="page-subtitle">@yield('page_subtitle', 'Pantau kondisi stok bahan baku gudang secara real-time')</p>
                </div>
                <div class="topbar-date">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </header>

            <div class="page-content">
                @if(session('success'))
                <div class="toast toast-success" id="toast-notif">
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="toast toast-error" id="toast-error">
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- WADAH UTAMA HALAMAN -->
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('active');
        }

        setTimeout(() => {
            const toast = document.getElementById('toast-notif');
            if (toast) toast.style.opacity = '0', setTimeout(() => toast.remove(), 500);
            const toastErr = document.getElementById('toast-error');
            if (toastErr) toastErr.style.opacity = '0', setTimeout(() => toastErr.remove(), 500);
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>