<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title> {{ $title ?? ' '}} | Sistem Informasi Paramadina</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistem Informasi Paramadina" name="description" />
    <meta content="Themesbrand" name="author" />
    
    <link rel="shortcut icon" href="{{ asset(config('velzon.theme') . '/images/favicon.ico') }}">

    <script src="{{ asset(config('velzon.theme') . '/js/layout.js') }}"></script>
    
    <link href="{{ asset(config('velzon.theme') . '/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset(config('velzon.theme') . '/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset(config('velzon.theme') . '/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset(config('velzon.theme') . '/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    @stack('styles')

    <style>
        /* Menyembunyikan wrapper utama sampai CSS termuat untuk mencegah FOUC */
        #layout-wrapper { opacity: 0; }
        .no-fouc #layout-wrapper { opacity: 1; transition: opacity 0.2s ease-in; }
        
        /* Memperjelas warna link tanpa merusak sidebar active */
        .main-content a:not(.btn) { color: #353535; }
        .main-content a:not(.btn):hover { color: #3d78e3; }


        /* Meratakan Search Box ke Kanan */
        .dataTables_filter {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Meratakan Pagination ke Kanan */
        .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
        }

        /* Memberi jarak atas bawah agar tidak menempel ke tabel */
        .dataTables_wrapper .row {
            margin-top: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        /* Merapikan tampilan pagination agar terlihat seperti tombol Bootstrap */
        .pagination {
            margin-bottom: 0;
            justify-content: flex-end;
        }

        /* Custom Soft UI Colors */
        .btn-soft-primary { background-color: #e0ebff; color: #0d6efd; border: none; }
        .btn-soft-success { background-color: #d1f2e4; color: #198754; border: none; }
        .btn-soft-warning { background-color: #fff3cd; color: #856404; border: none; }
        .btn-soft-danger  { background-color: #f8d7da; color: #721c24; border: none; }
        .btn-soft-info    { background-color: #e0f7fa; color: #006064; border: none; }

        /* Efek Hover */
        .btn-soft-primary:hover { background-color: #0d6efd; color: white; }
    </style>
    
    <script>
        // Script instan untuk menampilkan konten segera setelah DOM siap
        document.documentElement.className += ' no-fouc';
    </script>
</head>

<body class="no-fouc">

    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="/" class="logo logo-dark">
                                <span class="logo-lg"><img src="{{ asset('logo-label.svg') }}" alt="" height="30"></span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon"><span></span><span></span><span></span></span>
                        </button>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{ session('google_avatar') ?? asset('images/users/user-dummy-img.jpg') }}">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">{{ Auth::user()->name ?? 'User' }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Administrator</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Welcome {{ Auth::user()->name ?? '' }}!</h6>
                                <a class="dropdown-item" href="{{ route('gate') }}"><i class="ri-apps-line fs-16 align-middle me-1"></i> <span class="align-middle">Menu Utama</span></a>
                                <a class="dropdown-item" href="#"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="app-menu navbar-menu border-end">
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm"><img src="{{ asset('logo-label.svg') }}" alt="" height="30"></span>
                    <span class="logo-lg"><img src="{{ asset('logo-label.svg') }}" alt="" height="60"></span>
                </a>
            </div>

            @include('layouts.partials.sidebar')
            <div class="sidebar-background"></div>
        </div>

        <div class="vertical-overlay"></div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @include('layouts.partials.breadcrumb')
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><script>document.write(new Date().getFullYear())</script> © Paramadina.</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset(config('velzon.theme') . '/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset(config('velzon.theme') . '/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset(config('velzon.theme') . '/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset(config('velzon.theme') . '/libs/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset(config('velzon.theme') . '/js/app.js') }}"></script>

    @yield('scripts')

    <script>
        $(document).ready(function() {
            $('#topnav-hamburger-icon').on('click', function() {
                var windowWidth = $(window).width();
                if (windowWidth > 1025) {
                    $('html').attr('data-sidebar-size') == 'sm' ? $('html').attr('data-sidebar-size', 'lg') : $('html').attr('data-sidebar-size', 'sm');
                } else {
                    $('html').toggleClass('vertical-sidebar-enable');
                }
            });
        });
    </script>
</body>
</html>