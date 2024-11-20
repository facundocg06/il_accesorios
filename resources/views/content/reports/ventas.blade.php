@extends('layouts/layoutMaster')

@section('title', 'eCommerce Order List - Apps')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/app-ecommerce-order-list.js'])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Gráfico de Ventas Diarias -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5>Ventas Diarias</h5>
                            <small class="text-muted">Ventas por día de la semana</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="dailySalesChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Gráfico de Ventas Mensuales -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5>Ventas Mensuales</h5>
                            <small class="text-muted">Ventas por mes del año</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlySalesChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Gráfico de Productos Más Vendidos en el Mes -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5>Productos Más Vendidos (Mes)</h5>
                            <small class="text-muted">Producto más vendidos del mes</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="topProductsMonthChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Gráfico de Productos Más Vendidos en el Año -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5>Productos Más Vendidos (Año)</h5>
                            <small class="text-muted">Top 5 productos más vendidos del año</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="topProductsYearChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfico de Productos Más Vendidos en el Mes
            var ctx3 = document.getElementById('topProductsMonthChart').getContext('2d');
            var topProductsMonthChart = new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: @json($topProductsMonth['productNames']),
                    datasets: [{
                        label: 'Cantidad del Mes',
                        data: @json($topProductsMonth['productAmounts']),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

            // Gráfico de Productos Más Vendidos en el Año
            var ctx4 = document.getElementById('topProductsYearChart').getContext('2d');
            var topProductsYearChart = new Chart(ctx4, {
                type: 'pie',
                data: {
                    labels: @json($topProductsYear['productNames']),
                    datasets: [{
                        label: 'Cantidad Por Año',
                        data: @json($topProductsYear['productAmounts']),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

            // Gráfico de Ventas Diarias
            var ctx5 = document.getElementById('dailySalesChart').getContext('2d');
            var dailySalesChart = new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: @json($dailySales['labels']),
                    datasets: [{
                        label: 'Ventas por Día (Bs)',
                        data: @json($dailySales['data']),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de Ventas Mensuales
            var ctx6 = document.getElementById('monthlySalesChart').getContext('2d');
            var monthlySalesChart = new Chart(ctx6, {
                type: 'bar',
                data: {
                    labels: @json($monthlySales['labels']),
                    datasets: [{
                        label: 'Ventas por Mes (Bs)',
                        data: @json($monthlySales['data']),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
