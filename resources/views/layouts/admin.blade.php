<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        {{-- <div class="navbar-brand-box horizontal-logo">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="17">
                                </span>
                            </a>
                        </div> --}}

                        {{-- <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button> --}}
                        <div id="page-title" class="page-title h4 fw-bold ms-3 mt-1">@yield('page-title', 'Dashboard')</div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-1 topbar-head-dropdown header-item">
                            <button type="button" class="btn" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user"
                                        src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name ?? 'Tên Người Dùng' }}</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle" data-key="t-logout">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <h2 class="mt-4 text-white">Admin Panel</h2>
            </div>
            <div id="scrollbar" class="mt-4">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <!-- Dashboards -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarDashboard" data-title="Dashboard">
                                <i class="ri-dashboard-2-line"></i> <span class="fs-4">Dashboards</span>
                            </a>
                        </li>

                        <!-- Categories -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarCategories" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarCategories">
                                <i class="ri-dashboard-2-line"></i> <span class="fs-4">Categories</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarCategories">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link fs-5" data-key="t-analytics"
                                            data-title="Categories > List Categories">List Categories</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link fs-5" data-key="t-crm"
                                            data-title="Categories > Add Category">Add Category</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Products -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarProducts">
                                <i class="ri-dashboard-2-line"></i> <span class="fs-4">Products</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarProducts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{route('admin.product.listProducts')}}" class="nav-link fs-5" data-key="t-analytics"
                                            data-title="Products > List Products">List Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.products.create')}}" class="nav-link fs-5" data-key="t-crm"
                                            data-title="Products > Add Product">Add Product</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                         <!-- user -->
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarProducts">
                                <i class="ri-dashboard-2-line"></i> <span class="fs-4">User</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarProducts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="" class="nav-link fs-5" data-key="t-analytics"
                                            data-title="Products > List Products">List User</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const titleElement = document.getElementById("page-title");

            document.querySelectorAll('[data-title]').forEach(link => {
                link.addEventListener("click", function(e) {
                    const title = this.getAttribute("data-title");
                    if (titleElement && title) {
                        titleElement.textContent = title;
                    }
                });
            });
        });
    </script>


    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
