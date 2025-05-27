<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href={{ asset('assets/img/kaiadmin/favicon.ico') }} type="image/x-icon" />

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-y: auto;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        nav.w-5 {
            display: none;
        }
    </style>

    <!-- Fonts and icons -->
    <script src={{ asset('assets/js/plugin/webfont/webfont.min.js') }}></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: [{{ asset('assets/css/fonts.min.css') }}],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap.min.css') }} />
    <link rel="stylesheet" href={{ asset('assets/css/plugins.min.css') }} />
    <link rel="stylesheet" href={{ asset('assets/css/kaiadmin.min.css') }} />
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.min.css') }}">
</head>

<body>
    < class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src={{ asset('assets/img/kaiadmin/logo_light.svg') }} alt="navbar brand"
                            class="navbar-brand" height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                    <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active"><a href="/dashboard"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Components</h4></li>
                        <li class="nav-item active"><a href="contact_list"><i class="fas fa-phone"></i><p>Contact</p></a></li>
                        <li class="nav-item active"><a href="users"><i class="fas fa-user"></i><p>Users</p></a></li>
                        <li class="nav-item active"><a href="products"><i class="fas fa-user"></i><p>Products</p></a></li>
                        <li class="nav-item active"><a href="category"><i class="fas fa-user"></i><p>Category</p></a></li>
                        <li class="nav-item active"><a href="{{ route('coupons.index') }}"><i class="fa-solid fa-user"></i><p>Coupon</p></a></li>
                        <li class="nav-item active"><a href="{{ route('orders.index') }}"><i class="fa-solid fa-user"></i><p>Order</p></a></li>
                    </ul>
                </div>
            </div>
        </div>
    
        <!-- End Sidebar -->

        <!-- Main Panel -->
        <div class="main-panel">
            <!-- Header -->
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src={{ asset('assets/img/kaiadmin/logo_light.svg') }} alt="navbar brand"
                                class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                            <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                        </div>
                        <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                    </div>
                </div>

                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1"><i class="fa fa-search search-icon"></i></button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                                    <div class="avatar-sm">
                                        <img src={{ asset('assets/img/profile.jpg') }} alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username"><span class="op-7">Hi,</span> <span class="fw-bold">Abhishek</span></span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src={{ asset('assets/img/profile.jpg') }} alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>Hizrian</h4>
                                                    <p class="text-muted">hello@example.com</p>
                                                    <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">My Profile</a>
                                            <a class="dropdown-item" href="#">My Balance</a>
                                            <a class="dropdown-item" href="#">Inbox</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Logout</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- End Header -->

            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer" style="background-color: #f8f9fa; z-index: 1000;">
                <div class="container-fluid d-flex justify-content-between py-2">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="#">BMT Fashion </a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Licenses</a></li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        2025, made with <i class="fa fa-heart heart text-danger"></i> by <a href="#">Abhishek Sabale</a>
                    </div>
                    <div>Distributed by <a target="_blank" href="#">ThemeWagon</a>.</div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src={{ asset('assets/js/core/bootstrap.min.js') }}></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="assets/js/kaiadmin.min.js"></script>
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
</body>

</html>
