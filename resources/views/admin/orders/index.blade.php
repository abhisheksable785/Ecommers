@extends('layout.back.master')
@section('title','Order List')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Order List</h4>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $totalPending }}</h4>
                                <p class="mb-0 fw-medium">Pending Payment</p>
                            </div>
                            <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-calendar-stats text-body"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-4" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $totalCompleted }}</h4>
                                <p class="mb-0 fw-medium">Completed</p>
                            </div>
                            <span class="avatar p-2 me-lg-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-checks text-body"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                                <h4 class="mb-2">{{ $totalRefunded }}</h4>
                                <p class="mb-0 fw-medium">Refunded</p>
                            </div>
                            <span class="avatar p-2 me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-wallet text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-2">{{ $totalFailed }}</h4>
                                <p class="mb-0 fw-medium">Failed</p>
                            </div>
                            <span class="avatar p-2">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-alert-octagon text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                <div class="col-md-4 user_role">
                    <h5 class="card-title mb-0">Orders</h5>
                </div>
                <div class="col-md-8 d-flex justify-content-md-end align-items-center">
                    <form method="GET" action="{{ route('orders.index') }}" class="d-flex align-items-center me-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search Order..."
                                value="{{ request('search') }}"
                                aria-label="Search..."
                                aria-describedby="basic-addon-search31"
                            >
                        </div>
                    </form>

                    <div class="dt-buttons btn-group flex-wrap">
                        <div class="btn-group">
                            <button class="btn btn-label-secondary dropdown-toggle me-3" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><i class="ti ti-screen-share me-1 ti-xs"></i>Export</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="exportDropdown">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-2"></i>Print</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file-text me-2"></i>Csv</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file-spreadsheet me-2"></i>Excel</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file-description me-2"></i>Pdf</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy me-2"></i>Copy</a>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-order table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Method</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td></td>
                        <td>
                            <a href="{{ route('orders.view', $order->id) }}">
                                <span class="fw-medium">#{{ $order->order_number ?? $order->id }}</span>
                            </a>
                        </td>
                        <td class="text-nowrap">{{ $order->created_at->format('M d, Y, h:i A') }}</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center order-name text-nowrap">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ strtoupper(substr($order->full_name, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="m-0">
                                        <a href="javascript:void(0)" class="text-body">{{ $order->full_name }}</a>
                                    </h6>
                                    <small class="text-muted">{{ $order->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6 class="mb-0 align-items-center d-flex w-px-100 {{ $order->payment_status == 'paid' ? 'text-success' : 'text-warning' }}">
                                <i class="ti ti-circle-filled fs-tiny me-2"></i>
                                {{ ucfirst($order->payment_status) }}
                            </h6>
                        </td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'completed' => 'bg-label-success',
                                    'pending' => 'bg-label-warning',
                                    'processing' => 'bg-label-info',
                                    'failed', 'cancelled' => 'bg-label-danger',
                                    'refunded' => 'bg-label-secondary',
                                    default => 'bg-label-primary',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}" text-capitalized>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-nowrap">
                                @if($order->payment_method == 'paypal')
                                    <i class="ti ti-brand-paypal text-primary me-2"></i>
                                @elseif($order->payment_method == 'credit_card')
                                    <i class="ti ti-credit-card text-info me-2"></i>
                                @elseif($order->payment_method == 'cod')
                                    <i class="ti ti-cash text-success me-2"></i>
                                @else
                                    <i class="ti ti-wallet me-2"></i>
                                @endif
                                <span class="fw-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="javascript:;" class="text-body edit-record me-2" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                    <i class="ti ti-edit ti-sm"></i>
                                </a>
                                <div class="dropdown">
                                    <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical ti-sm"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('orders.view', $order->id) }}" class="dropdown-item">View</a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete-record text-danger" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <h4>No orders found</h4>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                </div>
                <div>
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection