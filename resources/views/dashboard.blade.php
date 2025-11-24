@extends('layouts.admin')

@section('title','Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($todaySales ?? 1250) }}</h3>
                <p>Today's Sales</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="/orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stockValue ?? 532 }}</h3>
                <p>Total Stock</p>
            </div>
            <div class="icon"><i class="fas fa-boxes"></i></div>
            <a href="/products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $openOrders ?? 12 }}</h3>
                <p>Open Orders</p>
            </div>
            <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <a href="/orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $suppliers ?? 8 }}</h3>
                <p>Suppliers</p>
            </div>
            <div class="icon"><i class="fas fa-truck"></i></div>
            <a href="/suppliers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Sales (Last 12 months)</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Stock by Category</h3>
            </div>
            <div class="card-body">
                <canvas id="stockChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sales chart (line)
        const salesCtx = document.getElementById('salesChart')?.getContext('2d');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($months ?? []) !!},
                    datasets: [{
                        label: 'Sales',
                        data: {!! json_encode($monthlySales ?? []) !!},
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0,123,255,0.08)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        // Stock chart (bar)
        const stockCtx = document.getElementById('stockChart')?.getContext('2d');
        if (stockCtx) {
            new Chart(stockCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topProducts ?? []) !!},
                    datasets: [{
                        label: 'Stock',
                        data: {!! json_encode($productStock ?? []) !!},
                        backgroundColor: ['#17a2b8','#28a745','#ffc107','#dc3545','#6f42c1','#20c997']
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });
        }
    });
</script>
@endpush
