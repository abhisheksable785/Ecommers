<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Smaller height for Bootstrap small inputs */
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

    <!-- Add before closing body tag -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{-- In <head> section --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Before </body> or in a script section --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
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

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

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
                      <a href="{{route('products.create')}}" class="menu-link">
                        <div data-i18n="Add Product">Add Product</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="{{ route("category.index") }}" class="menu-link">
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
                      <a href="app-ecommerce-customer-all.html" class="menu-link">
                        <div data-i18n="All Customers">All Customers</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Customer Details">Customer Details</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item">
                          <a href="app-ecommerce-customer-details-overview.html" class="menu-link">
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




                    {{-- <li class="menu-item {{ request()->routeIs('products.index', '') ? ' open' : '' }}">
                        <a href="{{ route('products.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-confetti"></i> <!-- Festival icon -->
                            <div data-i18n="Product ">Product </div>
                        </a>
                        
                    </li>

                    <li
                        class="menu-item {{ request()->routeIs('syllabus.index', 'syllabus-list.index') ? 'active open' : '' }} }}">
                        <a href="{{ route('category.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-sitemap"></i> <!-- Category icon -->
                            <div data-i18n="Category">Category</div>
                        </a>

                    </li>

                    <li
                        class="menu-item {{ request()->routeIs('affair.index', 'affair-post.index') ? 'active open' : '' }}">
                        <a href="{{ route('coupons.index') }}" class="menu-link ">
                            <i class="menu-icon tf-icons ti ti-discount"></i> <!-- Custom icon -->
                            <div data-i18n="Coupons">Coupons</div>
                        </a>

                    </li>

                    <li class="menu-item {{ request()->routeIs('all_questions.index') ? 'active' : '' }}">
                        <a href="{{ route('orders.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-shopping-cart"></i> <!-- All Questions icon -->
                            <div data-i18n="Order List">Order List</div>
                        </a>
                    </li> --}}



                    {{-- <li
                        class="menu-item {{ request()->routeIs('subject.index', 'subject-topic.index') ? ' open' : '' }}">
                        <a href="" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-confetti"></i> <!-- Festival icon -->
                            <div data-i18n="Users Info">Users Info</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item  {{ request()->routeIs('subject.index') ? 'active' : '' }}">
                                <a href="religionlist" class="menu-link">
                                    <div data-i18n="Religion List">Religion List</div>
                                </a>


                            <li class="menu-item {{ request()->routeIs('subject-topic.index') ? 'active' : '' }}">
                                <a href="castelist" class="menu-link">
                                    <div data-i18n="Caste List">Caste List</div>
                                </a>
                            </li>

                    </li>
                    <li class="menu-item {{ request()->routeIs('subject-topic.index') ? 'active' : '' }}">
                        <a href="mothertonguelist" class="menu-link">
                            <div data-i18n="Mother Tonguelist">Mother Tonguelist</div>
                        </a>
                    </li>


                    <li class="menu-item {{ request()->routeIs('subject-topic.index') ? 'active' : '' }}">
                        <a href="subcaste" class="menu-link">
                            <div data-i18n="Subcaste List">Subcaste List</div>
                        </a>
                    </li> --}}




                    {{-- <li class="menu-item {{ request()->routeIs('subject-topic.index') ? 'active' : '' }}">
                        <a href="country" class="menu-link">
                            <div data-i18n="countries">countries</div>
                        </a>
                    </li> --}}
                    {{-- </ul>
                </li> --}}




                    {{-- <li
                    class="menu-item {{ request()->routeIs('subject.index', 'subject-topic.index') ? ' open' : '' }}">
                    <a href="" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-confetti"></i> <!-- Festival icon -->
                        <div data-i18n="States">States</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item  {{ request()->routeIs('subject.index') ? 'active' : '' }}">
                            <a href="states" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-book"></i> <!-- Subject Wise icon -->
                                <div data-i18n="States">States</div>
                            </a>


                        <li class="menu-item  {{ request()->routeIs('subject.index') ? 'active' : '' }}">
                            <a href="districs" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-book"></i> <!-- Subject Wise icon -->
                                <div data-i18n="Distric">Distric</div>
                            </a>




                        <li class="menu-item {{ request()->routeIs('subject-topic.index') ? 'active' : '' }}">
                            <a href="talukas" class="menu-link">
                                <div data-i18n="Taluka List">Taluka List</div>
                            </a>
                        </li>

                </li> --}}
                    {{-- <li class="menu-item {{ request()->routeIs('subject-topic.index') ? 'active' : '' }}">
                    <a href="mothertonguelist" class="menu-link">
                        <div data-i18n="Mother Tonguelist">Mother Tonguelist</div>
                    </a>
                </li> --}}



                    {{-- </ul>
                </li> --}}





                    {{-- <li class="menu-item  {{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
                        <a href= "" class="menu-link">
                            <i class="menu-icon fa-solid fa-user-tie"></i>
                            <div data-i18n="Employee List"> Employee List </div>
                        </a>
                    </li>

                    <li
                        class="menu-item {{ request()->routeIs('admin.leads.index') || request()->routeIs('admin.leads.create') ? 'active' : '' }}">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i> <!-- Leads icon -->
                            <div data-i18n="All Leads"> All Leads</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('admin.leads.overdue') ? 'active' : '' }}">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i> <!-- Leads icon -->
                            <div data-i18n="Overdue Leads"> Overdue Leads</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('admin.leads.today') ? 'active' : '' }}">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i> <!-- Leads icon -->
                            <div data-i18n="Todays Leads"> Todays Leads</div>
                        </a>
                    </li> --}}
{{--
                    <li class="menu-item {{ request()->routeIs('admin.todaysleads.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.todaysleads.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i> <!-- Leads icon -->
                            <div data-i18n="Todays Leads">Todays Leads</div>
                        </a>
                    </li> --}}
                    {{-- <li class="menu-item {{ request()->routeIs('admin.overdeuleads.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.overdeuleads.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i> <!-- Leads icon -->
                            <div data-i18n="Overdeu Leads">Overdeu Leads</div>
                        </a>
                    </li> --}}

                    {{-- <li class="menu-item {{ request()->routeIs('leadnotifications.index') ? 'active' : '' }}">
                        <a href="{{ route('leadnotifications.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i> <!-- Leads icon -->
                            <div data-i18n="Leads Notification">Lead Notification</div>
                        </a>
                    </li> --}}


                    {{-- <li class="menu-item {{ request()->routeIs('call-logs.index') ? 'active' : '' }}">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-phone"></i> <!-- Leads icon -->
                            <div data-i18n="Employee-Call-Logs">Employee-Call-Logs</div>
                        </a>
                    </li>


                     <li class="menu-item {{ request()->routeIs('admin.calllogs.index') ? 'active' : '' }}">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-phone"></i> <!-- Leads icon -->
                            <div data-i18n="Admin-Call-Logs">Admin-Call-Logs</div>
                        </a>
                    </li> --}}


                    {{-- <li
                    class="menu-item {{ request()->routeIs('advertizes.index') || request()->routeIs('advertizes.create') || request()->routeIs('advertizes.edit') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-bullhorn"></i> <!-- Updated: Advertizes icon -->
                        <div data-i18n="Advertizes">Advertizes</div>
                    </a>
                </li> --}}
                    {{-- <li
                    class="menu-item {{ request()->routeIs('users_photos') || request()->routeIs('photos_by_user') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-bullhorn"></i> <!-- Updated: Advertizes icon -->
                        <div data-i18n="User Photos">User Photos</div>
                    </a>
                </li> --}}



                    {{-- <li class="menu-item {{ request()->routeIs('question_paper_pdf_exam_type.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-file-text"></i> <!-- Question Paper PDF icon -->
                        <div data-i18n="Question Paper PDF">Question Paper PDF</div>
                    </a>
                </li> --}}

                    {{-- <li class="menu-item {{ request()->routeIs('study_videos.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-video"></i> <!-- Study Videos icon -->
                        <div data-i18n="Study Videos">Study Videos</div>
                    </a>
                </li> --}}
                    {{-- <li class="menu-item {{ request()->routeIs('daily_quiz.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-question-mark"></i> <!-- Daily Quiz icon -->
                        <div data-i18n="Daily Quiz">Daily Quiz</div>
                    </a>
                </li>


                <li class="menu-item {{ request()->routeIs('contact_us.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-phone-call"></i> <!-- Contact Us icon -->
                        <div data-i18n="Contact Us">Contact Us</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('write_to_us.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-mail"></i> <!-- Write To Us icon -->
                        <div data-i18n="Write To Us">Write To Us</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('subscription_model.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-currency-dollar"></i> <!-- Subscription Models icon -->
                        <div data-i18n="Subscription Models">Subscription Models</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('subscription_history.index') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-history"></i> <!-- Subscription History icon -->
                        <div data-i18n="Subscription History">Subscription History</div>
                    </a>
                </li> --}}







                    {{-- <li class="menu-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-home"></i>
                        <div data-i18n="Setings">Setings</div>
                    </a>
                </li> --}}


                </ul>
            </aside>
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Greeting -->
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
                        <!-- /Greeting -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">


                            <!-- Style Switcher -->
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
                            <!-- / Style Switcher-->



                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="ti ti-bell ti-md"></i>
                                    <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end py-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h5 class="text-body mb-0 me-auto">Notification</h5>
                                            <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Mark all as read"><i class="ti ti-mail-opened fs-4"></i></a>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container">
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/1.png" alt
                                                                class="h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Congratulation Lettie 🎉</h6>
                                                        <p class="mb-0">Won the monthly best seller gold badge</p>
                                                        <small class="text-muted">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Charles Franklin</h6>
                                                        <p class="mb-0">Accepted your connection</p>
                                                        <small class="text-muted">12hr ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/2.png" alt
                                                                class="h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">New Message ✉</h6>
                                                        <p class="mb-0">You have new message from Natalie</p>
                                                        <small class="text-muted">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-success"><i
                                                                    class="ti ti-shopping-cart"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Whoo! You have new order 🛒</h6>
                                                        <p class="mb-0">ACME Inc. made new order $1,154</p>
                                                        <small class="text-muted">1 day ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/9.png" alt
                                                                class="h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Application has been approved 🚀</h6>
                                                        <p class="mb-0">Your ABC project application has been
                                                            approved.</p>
                                                        <small class="text-muted">2 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-success"><i
                                                                    class="ti ti-chart-pie"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Monthly report is generated</h6>
                                                        <p class="mb-0">July monthly financial report is generated
                                                        </p>
                                                        <small class="text-muted">3 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/5.png" alt
                                                                class="h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Send connection request</h6>
                                                        <p class="mb-0">Peter sent you connection request</p>
                                                        <small class="text-muted">4 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/6.png" alt
                                                                class="h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">New message from Jane</h6>
                                                        <p class="mb-0">Your have new message from Jane</p>
                                                        <small class="text-muted">5 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-warning"><i
                                                                    class="ti ti-alert-triangle"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">CPU is running high</h6>
                                                        <p class="mb-0">CPU Utilization Percent is currently at
                                                            88.63%,</p>
                                                        <small class="text-muted">5 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-menu-footer border-top">
                                        <a href="javascript:void(0);"
                                            class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                                            View all notifications
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    {{-- class="avatar avatar-online" --}}
                                    <div >
                                        @auth('admin')
                                           @if (Auth::guard('admin')->user()->photo)
                                                <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}"
                                                    style="width:40px; height:40px; object-fit:cover; border-radius:50%;"
                                                    alt="Admin Avatar">
                                            @else
                                                {{-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Default Avatar"
                                                    class="h-auto rounded-circle" /> --}}
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
                                                                    alt="Default Avatar" class="h-auto rounded-circle" />
                                                            @endif
                                                        @endauth

                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-medium d-block">{{ Auth::guard('admin')->user()->name ?? 'N/A' }}</span>
                                                    <small
                                                        class="text-muted">{{ Auth::guard('admin')->user()->email  ?? 'N/A' }}</small>
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
                                    {{-- <li>
                      <a class="dropdown-item" href="pages-account-settings-account.html">
                        <i class="ti ti-settings me-2 ti-sm"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li> --}}
                                    
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
                            </li>


                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-xxl border-0"
                            placeholder="Search..." aria-label="Search..." />
                        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
                    </div>
                </nav>
                <!-- / Menu -->

                <div class="content-wrapper">
                    @yield('content')
                    <!-- Content wrapper -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤ by <a href="" target="_blank"
                                        class="fw-medium">Shani Devops</a>
                                    Developers
                                </div>
                                <div class="d-none d-lg-inline-block">

                                    <div class="footer-link d-none d-sm-inline-block">Version 1.0</div>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->



    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    {{-- fine --}}
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (Required by Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "3000"
        };
    </script>
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>

    
        @stack('scripts')

</body>

</html>
