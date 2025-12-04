<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | BMT-Fashion</title>

    <meta name="description" content="" />

    {{-- --- CDN & Custom Styles (Keep these in the HEAD) --- --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        /* Smaller height for Bootstrap small inputs (Select2 customization) */
        .select2-container--default .select2-selection--single {
            height: 32px;
            padding: 4px 6px;
            font-size: 0.875rem;
            border-radius: 0.2rem;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 30px;
            right: 6px;
        }

        .select2-dropdown {
            font-size: 0.875rem;
        }
    </style>

    {{-- --- Core Fonts & Icons --- --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    {{-- --- Core CSS (Theme) --- --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    {{-- --- Vendors CSS (Common) --- --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />

    {{-- --- Page CSS (Common) --- --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    
    {{-- 🌟 CRITICAL FIX: STYLES STACK 🌟 --}}
    {{-- This allows child pages to push unique CSS files (like Datatables Responsive CSS) --}}
    @stack('styles') 


    {{-- --- Helpers & Config --- --}}
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <span class="app-brand-text demo menu-text fw-bold">BMT-Fashion</span>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Menu</span>
                    </li>
                    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-home"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <div data-i18n="Products">Products</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('products.index') }}" class="menu-link">
                                    <div data-i18n="Product list">Product list</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('products.create') }}" class="menu-link">
                                    <div data-i18n="Add Product">Add Product</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('category.index') }}" class="menu-link">
                                    <div data-i18n="Category list">Category List</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <div data-i18n="Order">Order</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('orders.index') }}" class="menu-link">
                                    <div data-i18n="Order list">Order list</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Order Details">Order Details</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <div data-i18n="Customer">Customer</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.customer.all.index') }}" class="menu-link">
                                    <div data-i18n="All Customers">All Customers</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link menu-toggle">
                                    <div data-i18n="Customer Details">Customer Details</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="{{ route('admin.customer.show') }}" class="menu-link">
                                            <div data-i18n="Overview">Overview</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-ecommerce-customer-details-security.html" class="menu-link">
                                            <div data-i18n="Security">Security</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-ecommerce-customer-details-billing.html" class="menu-link">
                                            <div data-i18n="Address & Billing">Address & Billing</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-ecommerce-customer-details-notifications.html" class="menu-link">
                                            <div data-i18n="Notifications">Notifications</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ request()->routeIs('all_questions.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.sliders') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-shopping-cart"></i> <div data-i18n="App Slider ">App Slider</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.reviews.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.reviews.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-star"></i>
                            <div data-i18n="Reviews">Reviews</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <div data-i18n="Settings">Settings</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item active">
                                <a href="app-ecommerce-settings-detail.html" class="menu-link">
                                    <div data-i18n="Store details">Store details</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-ecommerce-settings-payments.html" class="menu-link">
                                    <div data-i18n="Payments">Payments</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-ecommerce-settings-checkout.html" class="menu-link">
                                    <div data-i18n="Checkout">Checkout</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-ecommerce-settings-shipping.html" class="menu-link">
                                    <div data-i18n="Shipping & delivery">Shipping & delivery</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-ecommerce-settings-locations.html" class="menu-link">
                                    <div data-i18n="Locations">Locations</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.notifications')}}" class="menu-link">
                                    <div data-i18n="Notifications">Notifications</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        @php
                            $hour = now()->format('H');
                            if ($hour < 12) {
                                $greeting = 'Good Morning';
                                $icon = 'ti ti-sun';
                            } elseif ($hour < 18) {
                                $greeting = 'Good Afternoon';
                                $icon = 'ti ti-cloud-sun';
                            } else {
                                $greeting = 'Good Evening';
                                $icon = 'ti ti-moon';
                            }
                        @endphp
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-greeting-wrapper mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="{{ $icon }} text-warning me-2" style="font-size: 1.75rem;"></i>
                                    <div class="d-none d-md-inline-block">
                                        <span class="text-primary fw-semibold" style="font-size: 1.2rem;">
                                            {{ $greeting ?? 'Welcome' }},
                                        </span>
                                        <span class="fw-medium text-dark" style="font-size: 1.2rem;">
                                            @if (auth('admin')->check())
                                                {{ auth('admin')->user()->name }} 👋
                                            @else
                                                Guest 👋
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-md"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i class="ti ti-sun me-2"></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i class="ti ti-moon me-2"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i
                                                    class="ti ti-device-desktop me-2"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="ti ti-bell ti-md"></i>
                                    <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end py-0">
                                    {{-- Notification content here --}}
                                </ul>
                            </li>

                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div>
                                        @auth('admin')
                                            @if (Auth::guard('admin')->user()->photo)
                                                <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}"
                                                    style="width:40px; height:40px; object-fit:cover; border-radius:50%;"
                                                    alt="Admin Avatar">
                                            @else
                                                <img src="{{ asset('assets/img/avatars/1.png') }}"
                                                    style="width:40px; height:40px; object-fit:cover; border-radius:50%;"
                                                    alt="Admin Avatar">
                                            @endif
                                        @endauth
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar ">
                                                        @auth('admin')
                                                            @if (Auth::guard('admin')->user()->photo)
                                                                <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}"
                                                                    style="width:50px; height:50px; object-fit:cover; border-radius:50%;"
                                                                    alt="Admin Avatar">
                                                            @else
                                                                <img src="{{ asset('assets/img/avatars/1.png') }}"
                                                                    alt="Default Avatar"
                                                                    class="h-auto rounded-circle" />
                                                            @endif
                                                        @endauth
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-medium d-block">{{ Auth::guard('admin')->user()->name ?? 'N/A' }}</span>
                                                    <small
                                                        class="text-muted">{{ Auth::guard('admin')->user()->email ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                            <i class="ti ti-user-check me-2 ti-sm"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="ti ti-logout me-2 ti-sm"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            </ul>
                    </div>

                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-xxl border-0"
                            placeholder="Search..." aria-label="Search..." />
                        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
                    </div>
                </nav>
                {{-- --- CONTENT WRAPPER START --- --}}
                <div class="content-wrapper">
                    {{-- 🌟 CRITICAL FIX: CONTENT YIELD 🌟 --}}
                    @yield('content') 
                    {{-- --- CONTENT WRAPPER END --- --}}

                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤ by <a href="" target="_blank" class="fw-medium">Shani
                                        Devops</a>
                                    Developers
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <div class="footer-link d-none d-sm-inline-block">Version 1.0</div>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
                </div>
            </div>

        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="drag-target"></div>
    </div>
    {{-- --- Core JS (JQUERY, POPPER, BOOTSTRAP, ETC.) --- --}}
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    {{-- --- Vendors JS (Common) --- --}}
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    
    {{-- --- Quill/Form Related JS (Common) --- --}}
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    
    {{-- --- CDN JS (Toastr, Axios) --- --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- Redundant jQuery, but often useful --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> {{-- Redundant Select2 JS, but harmless --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    {{-- --- Main & Dashboard JS --- --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>




     <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <script src="../../assets/js/app-ecommerce-customer-all.js"></script>


    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "3000"
        };
    </script>
    
    {{-- 🌟 CRITICAL FIX: SCRIPTS STACK 🌟 --}}
    {{-- This allows child pages to push unique JS files (like DataTables initialization scripts) --}}
    @stack('scripts') 

</body>

</html>