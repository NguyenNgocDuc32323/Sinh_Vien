@extends('layouts.master-admin')
@section('page_title')
    Home Admin
@endsection
@section('content')
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.success('{{ session('success') }}');
        });
    </script>
    @endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.error('{{ session('error') }}');
    });
</script>
@endif
    <div class="dashboard-main-body">
        @php
            $properties = [
                'users_difference' => [
                    'label' => 'Users',
                    'icon' => 'fa-users',
                    'cardIcon' => 'bg-card-icon-1',
                    'value' => $thisWeekData['users'],
                    'comparison' => $comparison['users_difference'],
                ],
                'totalSales_difference' => [
                    'label' => 'Sales',
                    'icon' => 'fa-dollar-sign',
                    'cardIcon' => 'bg-card-icon-2',
                    'value' => $thisWeekData['totalSales'] . '$',
                    'comparison' => $comparison['totalSales_difference'] . '$',
                ],
                'orders_difference' => [
                    'label' => 'Orders',
                    'icon' => 'fa-brands fa-shopify',
                    'cardIcon' => 'bg-card-icon-5',
                    'value' => $thisWeekData['orders'],
                    'comparison' => $comparison['orders_difference'],
                ],
                'contacts_difference' => [
                    'label' => 'Contacts',
                    'icon' => 'fa-solid fa-message',
                    'cardIcon' => 'bg-card-icon-5',
                    'value' => $thisWeekData['contacts'],
                    'comparison' => $comparison['contacts_difference'],
                ],

            ];
        @endphp
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h1 class="fw-semibold mb-0 body-title">Dashboard</h1>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{route('home')}}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li><span>-</span></li>
                <li class="fw-medium"><span>User</span></li>
            </ul>
        </div>
        <div class="row">
            @foreach ($properties as $key => $details)
                @php
                    $textClass = 'text-success-main';
                    $iconClass = 'fa-up-long';
                    if ($details['comparison'] == 0) {
                        $textClass = 'text-neutral-main';
                        $iconClass = '';
                    } elseif ($details['comparison'] < 0) {
                        $textClass = 'text-danger-main';
                        $iconClass = 'fa-down-long';
                    }
                @endphp
                <div class="col col-xxl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="card card-block">
                        <div class="card-header text-center">
                            <p class="card-body-name mb-0">Thisweek : <span class="card-body-name-span">{{ $details['label'] }}</span></p>
                        </div>
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="this-week-title">{{ $details['value'] }}</p>
                                </div>
                                <div
                                    class="cart-body-icon {{ $details['cardIcon'] }} d-flex justify-content-center align-items-center">
                                    <i class="fa-solid {{ $details['icon'] }}"></i>
                                </div>
                            </div>
                            <p class="card-body-text-info fw-medium d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center gap-1 {{ $textClass }}">
                                    <i class="fa-solid {{ $iconClass }}"></i> {{ $details['comparison'] }}
                                </span>
                                Last week
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col-xl-6 col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-0">Total Today</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Register Users</td>
                                        <td>{{ $todayData['users_today'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Products</td>
                                        <td>{{ $todayData['products_today'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sales</td>
                                        <td>{{ $todayData['totalSales_today'] }} $</td>
                                    </tr>
                                    <tr>
                                        <td>Orders</td>
                                        <td>{{ $todayData['orders_today'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contacts</td>
                                        <td>{{ $todayData['contacts_today'] }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="chart-block col-xl-6 col-12 mb-4">
                <div class="card card-chart">
                    <div class="card-header header-elements d-flex align-items-center">
                        <h5 class="card-title mb-0">Revenue Statistics</h5>
                        <div class="card-action-element ms-auto py-0">
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" id="timeRangeMenu">
                                    <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                            data-time="0">Today</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                            data-time="yesterday">Yesterday</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                            data-time="current_week">Current Week</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                            data-time="last_week">Last Week</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                            data-time="current_month">Current Month</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                            data-time="last_month">Last Month</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" class="chartjs"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('barChart').getContext('2d');
            let chart;
            let currentTimeLabel = 'Today';
            function resizeCanvas() {
            const canvas = document.getElementById('barChart');
            canvas.width = canvas.parentElement.clientWidth;
            canvas.height = canvas.parentElement.clientHeight;
            }
            window.addEventListener('load', resizeCanvas);
            window.addEventListener('resize', resizeCanvas);

            const itemColors = [
                '#96ED89',
                '#45BF55',
                '#168039',
                '#044D29',
                '#00261C'
            ];

            function updateChart(data, timeLabel) {
                const adjustedTotalSales = data.total_sales / 100;
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Users', 'Sales(X100$)', 'Orders', 'Contacts'],
                        datasets: [{
                            label: timeLabel,
                            data: [
                                data.users,
                                adjustedTotalSales,
                                data.orders,
                                data.contacts
                            ],
                            backgroundColor: itemColors,
                            borderColor: itemColors.map(color => color.replace('0.2', '1')),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        let value = context.raw;
                                        if (context.label === 'Sales(X100$)') {
                                            value = (context.raw * 1000).toLocaleString();
                                            label += `: $${value}`;
                                        } else {
                                            label += `: ${value.toLocaleString()}`;
                                        }
                                        return label;
                                    }
                                },
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14,
                                    weight: 'normal'
                                }
                            }
                        }
                    }
                });
            }
            function fetchDataAndUpdateChart(time) {
                fetch(`/admin/chart-data?time=${time}`)
                    .then(response => response.json())
                    .then(data => {
                        const timeLabel = document.querySelector(`#timeRangeMenu a[data-time="${time}"]`)
                            .textContent;
                        updateChart(data, timeLabel);
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }
            var data =fetchDataAndUpdateChart(0);
            document.getElementById('timeRangeMenu').addEventListener('click', function(event) {
                if (event.target && event.target.matches('a[data-time]')) {
                    const time = event.target.getAttribute('data-time');
                    fetchDataAndUpdateChart(time);
                }
            });
        });
    </script>
@endpush
