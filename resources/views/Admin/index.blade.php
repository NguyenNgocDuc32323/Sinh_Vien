@extends('layouts.master-admin')
@section('page_title')
    Trang Quản Lý
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
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h1 class="fw-semibold mb-0 body-title">Quản Lý Học Sinh</h1>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{route('home')}}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="fa-solid fa-house"></i>
                        Trang Chủ
                    </a>
                </li>
                <li><span>-</span></li>
                <li class="fw-medium"><span>Người Dùng</span></li>
            </ul>
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
