<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin Dashboard')</title>

        <!-- Bootstrap CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <!-- FontAwesome -->
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            rel="stylesheet">
        <!-- Google Fonts - Nunito -->
        <link
            href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
            rel="stylesheet">

        @stack('styles')

        <style>
            :root {
                --sidebar-width: 240px;
                --navbar-height: 60px;
                --primary-color: #4e73df;
                --secondary-color: #f8f9fc;
                --dark-color: #343a40;
                --light-color: #ffffff;
                --hover-color: #495057;
                --transition-speed: 0.3s;
            }

            body {
                overflow-x: hidden;
                background-color: var(--secondary-color);
                font-family: 'Nunito', sans-serif;
                min-height: 100vh;
                padding-bottom: 60px;
                /* Footer height */
            }

            #sidebar {
                height: 100vh;
                background-color: var(--dark-color);
                position: fixed;
                width: var(--sidebar-width);
                padding-top: var(--navbar-height);
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                z-index: 1000;
                transition: margin-left var(--transition-speed) ease;
            }

            #sidebar.hide {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar .nav-link {
                color: var(--light-color);
                padding: 12px 15px;
                margin-bottom: 5px;
                border-radius: 4px;
                transition: all 0.2s;
            }

            #sidebar .nav-link.active,
            #sidebar .nav-link:hover {
                background-color: var(--hover-color);
                font-weight: 600;
            }

            #sidebar .nav-link i {
                width: 20px;
                margin-right: 10px;
                text-align: center;
            }

            .navbar {
                height: var(--navbar-height);
                background-color: var(--primary-color);
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                z-index: 1030;
            }

            #content {
                margin-left: var(--sidebar-width);
                padding: calc(var(--navbar-height) + 30px) 30px 30px;
                transition: margin-left var(--transition-speed) ease;
                min-height: calc(100vh - var(--navbar-height));
            }

            #content.full {
                margin-left: 0;
            }

            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                padding: 15px;
                background-color: var(--light-color);
                color: #6e707e;
                border-top: 1px solid #e3e6f0;
                z-index: 1000;
                margin-left: var(--sidebar-width);
                transition: margin-left var(--transition-speed) ease;
            }

            #content.full ~ .footer {
                margin-left: 0;
            }

            /* Badges and buttons */
            .badge {
                font-size: 0.75em;
                padding: 0.35em 0.65em;
            }

            .btn-sm i {
                font-size: 0.85rem;
            }

            .gap-1 {
                gap: 0.25rem;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                #sidebar {
                    margin-left: calc(-1 * var(--sidebar-width));
                }

                #sidebar.show {
                    margin-left: 0;
                }

                #content,
                .footer {
                    margin-left: 0;
                }
            }
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid">
                <button class="btn btn-outline-light me-3" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    Admin Dashboard
                </a>
                <div class="d-flex align-items-center ms-auto">
                    <span class="text-white me-3">Welcome,
                        {{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button
                            class="btn btn-primary dropdown-toggle"
                            type="button"
                            id="userDropdown"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-fw"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i>
                                    Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i>
                                    Settings</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <div id="sidebar">
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('barang.index') }}"
                        class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-box"></i>
                        Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('distributor.index') }}"
                        class="nav-link {{ request()->routeIs('distributor.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-truck"></i>
                        Distributor
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('kategori.index') }}"
                        class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-tags"></i>
                        Kategori
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div id="content">

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif

            <!-- Main page content -->
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                    ©
                    {{ date('Y') }}. All rights reserved.
                </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Version 1.0.0</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const footer = document.querySelector('.footer');
            const toggleBtn = document.getElementById('toggleSidebar');

            // Initialize sidebar state from localStorage
            const isSidebarHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (isSidebarHidden) {
                sidebar
                    .classList
                    .add('hide');
                content
                    .classList
                    .add('full');
            }

            // Toggle sidebar
            toggleBtn.addEventListener('click', function () {
                const isHidden = sidebar
                    .classList
                    .toggle('hide');
                content
                    .classList
                    .toggle('full');
                localStorage.setItem(
                    'sidebarHidden',
                    isHidden
                        ? 'true'
                        : 'false'
                );
            });

            // Initialize tooltips
            const tooltipTriggerList = []
                .slice
                .call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers
            const popoverTriggerList = []
                .slice
                .call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Global SweetAlert configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Display flash messages as toasts
        @if(session('success'))
        Toast.fire({icon: 'success', title: '{{ session(' success ') }}'});
        @endif

        @if(session('error'))
        Toast.fire({icon: 'error', title: '{{ session(' error ') }}'});
        @endif
    </script>

    @stack('scripts')
</body>
</html>
