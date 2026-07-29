<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Stunting - Puskesmas Losari</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='32' fill='%230B2545'/%3E%3Cpath d='M14 34 L24 34 L28 24 L36 44 L40 34 L50 34' fill='none' stroke='%237AA9D6' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">

    <!-- Google Fonts: Plus Jakarta Sans (display) + Inter (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            /* ---- Color tokens ---- */
            --deep-teal: #0B2545;
            --teal: #14487F;
            --teal-light: #4C7EB5;
            --sage: #E9EFF7;
            --sand: #F6F8FB;
            --gold: #7AA9D6;
            --gold-soft: #EAF3FC;
            --ink: #1F2937;
            --ink-soft: #6B7280;
            --line: #E4E9F0;
            --white: #FFFFFF;

            /* ---- Radius / shadow tokens ---- */
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-soft: 0 4px 16px rgba(11, 37, 69, 0.06);
            --shadow-lift: 0 12px 28px rgba(11, 37, 69, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--sand);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6,
        .display-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        a { text-decoration: none; }

        /* ---------------------------------- */
        /* Sidebar                             */
        /* ---------------------------------- */
        .sidebar {
            width: 264px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(175deg, var(--deep-teal) 0%, var(--teal) 100%);
            color: white;
            padding-top: 8px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Signature element: a faint growth-curve arc etched into the sidebar,
           nodding to the child-growth charts this system is built around. */
        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 264 900' fill='none'%3E%3Cpath d='M-20 780 C 60 760, 90 640, 130 560 C 175 470, 170 360, 230 300 C 270 260, 280 200, 300 140' stroke='%23FFFFFF' stroke-opacity='0.05' stroke-width='3'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: bottom left;
            background-size: cover;
            pointer-events: none;
        }

        .sidebar-brand {
            position: relative;
            padding: 22px 26px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand .brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(122, 169, 214, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text {
            line-height: 1.2;
        }

        .sidebar-brand .brand-sub {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.6px;
            color: rgba(255, 255, 255, 0.55);
            text-transform: uppercase;
        }

        .sidebar-menu {
            position: relative;
            list-style: none;
            padding: 0 14px;
            margin: 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-menu-item + .sidebar-menu-item {
            margin-top: 3px;
        }

        .sidebar-menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            color: rgba(255, 255, 255, 0.72);
            font-weight: 500;
            font-size: 0.92rem;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .sidebar-menu-item a i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-menu-item a:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.08);
        }

        .sidebar-menu-item.active a {
            color: var(--deep-teal);
            background-color: var(--gold);
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(122, 169, 214, 0.3);
        }

        .sidebar-section-label {
            padding: 16px 14px 6px;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
        }

        /* ---------------------------------- */
        /* Sidebar footer: user info + logout  */
        /* ---------------------------------- */
        .sidebar-footer {
            position: relative;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(122, 169, 214, 0.18);
            border: 1px solid rgba(122, 169, 214, 0.3);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            min-width: 0;
            line-height: 1.3;
        }

        .sidebar-user-name {
            display: block;
            font-size: 0.86rem;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        .sidebar-role-tag {
            display: inline-block;
            margin-top: 2px;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 1px 8px;
            border-radius: 999px;
            background-color: rgba(122, 169, 214, 0.2);
            color: var(--gold);
        }

        .sidebar-logout-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(255, 255, 255, 0.14);
            background-color: transparent;
            color: rgba(255, 255, 255, 0.75);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar-logout-btn:hover {
            background-color: #C4413C;
            border-color: #C4413C;
            color: white;
        }

        /* ---------------------------------- */
        /* Main content                        */
        /* ---------------------------------- */
        .main-content {
            margin-left: 264px;
            padding: 28px 32px 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background-color: var(--white);
            box-shadow: var(--shadow-soft);
            padding: 16px 26px;
            margin-bottom: 28px;
            border-radius: var(--radius-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--line);
        }

        .page-title {
            margin: 0;
            font-weight: 700;
            color: var(--deep-teal);
            font-size: 1.3rem;
        }

        .page-eyebrow {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: var(--teal-light);
            margin-bottom: 2px;
        }

        /* ---------------------------------- */
        /* Cards                               */
        /* ---------------------------------- */
        .card-custom {
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            background-color: var(--white);
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lift);
        }

        /* ---------------------------------- */
        /* Buttons                             */
        /* ---------------------------------- */
        .btn-primary-custom {
            background-color: var(--teal);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: background-color 0.2s ease;
        }
        .btn-primary-custom:hover {
            background-color: var(--deep-teal);
            color: white;
        }

        /* ---------------------------------- */
        /* Alerts                              */
        /* ---------------------------------- */
        .alert {
            border-radius: var(--radius-md);
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background-color: #E7F5EC;
            color: #1E6B3E;
        }

        .alert-danger {
            background-color: #FBEAEA;
            color: #A32C2C;
        }

        /* ---------------------------------- */
        /* Scrollbar polish (sidebar)          */
        /* ---------------------------------- */
        .sidebar-menu::-webkit-scrollbar { width: 5px; }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        /* ---------------------------------- */
        /* Responsive                          */
        /* ---------------------------------- */
        @media (max-width: 991.98px) {
            .sidebar {
                width: 220px;
            }
            .main-content {
                margin-left: 220px;
                padding: 20px;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            .navbar-custom {
                padding: 12px 16px;
            }
        }

        /* ---------------------------------- */
        /* Mobile sidebar toggle & overlay     */
        /* ---------------------------------- */
        .sidebar-toggle-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            background-color: var(--white);
            color: var(--deep-teal);
            font-size: 1.2rem;
            flex-shrink: 0;
            cursor: pointer;
        }

        .sidebar-toggle-btn:hover {
            background-color: var(--sage);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11, 37, 69, 0.45);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        @media (max-width: 767.98px) {
            .sidebar-toggle-btn {
                display: inline-flex;
            }
        }

        /* Respect reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            .card-custom, .sidebar-menu-item a, .user-menu-btn, .sidebar {
                transition: none !important;
            }
        }

        /* Visible keyboard focus */
        a:focus-visible, button:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 2px;
        }

        /* ---------------------------------- */
        /* Footer                              */
        /* ---------------------------------- */
        .app-footer {
            margin-top: auto;
            padding: 18px 0 4px;
            border-top: 1px solid var(--line);
            text-align: center;
            font-size: 0.82rem;
            color: var(--ink-soft);
        }

        @yield('styles')
    </style>
</head>
<body>

    <!-- Overlay untuk mobile: klik di luar sidebar akan menutupnya -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <span class="brand-icon"><i class="bi bi-activity"></i></span>
            <span class="brand-text">
                SPK Stunting
                <span class="brand-sub">Puskesmas Losari</span>
            </span>
        </div>

        @auth
            @php $role = auth()->user()->role; @endphp
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item {{ Request::is($role . '/dashboard') ? 'active' : '' }}">
                    <a href="{{ route($role . '.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>

                @if($role === 'admin')
                    <li class="sidebar-menu-item {{ Request::is('admin/user*') ? 'active' : '' }}">
                        <a href="{{ route('admin.user.index') }}">
                            <i class="bi bi-people-fill"></i> Kelola User
                        </a>
                    </li>
                @endif

                <li class="sidebar-menu-item {{ Request::is($role . '/balita*') ? 'active' : '' }}">
                    <a href="{{ route($role . '.balita.index') }}">
                        <i class="bi bi-person-fill"></i> Data Balita
                    </a>
                </li>

                @if($role === 'admin')
                    <div class="sidebar-section-label">Penilaian</div>

                    <li class="sidebar-menu-item {{ Request::is('admin/kriteria*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kriteria.index') }}">
                            <i class="bi bi-list-stars"></i> Data Kriteria
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('admin/sub-kriteria*') ? 'active' : '' }}">
                        <a href="{{ route('admin.sub-kriteria.index') }}">
                            <i class="bi bi-diagram-3-fill"></i> Sub Kriteria
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('admin/nilai*') ? 'active' : '' }}">
                        <a href="{{ route('admin.nilai.index') }}">
                            <i class="bi bi-pencil-square"></i> Input Nilai
                        </a>
                    </li>
                @endif

                <li class="sidebar-menu-item {{ Request::is($role . '/hasil*') ? 'active' : '' }}">
                    <a href="{{ route($role . '.hasil.index') }}">
                        <i class="bi bi-bar-chart-line-fill"></i> Hasil Ranking
                    </a>
                </li>
            </ul>

            <!-- Info user & tombol logout -->
            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <span class="sidebar-user-avatar"><i class="bi bi-person-fill"></i></span>
                    <div class="sidebar-user-info">
                        <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                        <span class="sidebar-role-tag">{{ strtoupper($role) }}</span>
                    </div>
                </div>
                <form action="{{ route($role . '.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn" title="Keluar (Logout)" aria-label="Keluar">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        @endauth
    </div>

    <!-- Main Content Wrapper -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="navbar-custom">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle-btn" type="button" onclick="toggleSidebar()" aria-label="Buka menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <span class="page-eyebrow">@yield('page_eyebrow', 'Sistem Pendukung Keputusan')</span>
                    <h4 class="page-title">@yield('page_title', 'Dashboard')</h4>
                </div>
            </div>
        </div>

        <!-- Success & Error Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Page Content -->
        @yield('content')

        <!-- Footer -->
        <footer class="app-footer">
            &copy; 2026 Puskesmas Losari. Seluruh hak cipta dilindungi.
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const appSidebar = document.getElementById('appSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            appSidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            document.body.style.overflow = appSidebar.classList.contains('show') ? 'hidden' : '';
        }

        function closeSidebar() {
            appSidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Tutup sidebar otomatis saat memilih menu (khusus tampilan mobile)
        document.querySelectorAll('.sidebar-menu-item a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 767.98) {
                    closeSidebar();
                }
            });
        });

        // Reset state sidebar saat layar di-resize kembali ke ukuran desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth > 767.98) {
                closeSidebar();
            }
        });
    </script>

    @yield('scripts')
</body>
</html>