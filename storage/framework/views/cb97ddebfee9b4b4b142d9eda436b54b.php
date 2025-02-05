<?php $__env->startSection('title', 'Inicio IL Accesorios'); ?>

<?php $__env->startSection('vendor-style'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/libs/apex-charts/apex-charts.scss']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/libs/apex-charts/apexcharts.js']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/assets/js/dashboards-crm.js']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <!-- Gráfico de Gastos Mensuales -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5>Reporte de Gastos en Insumos (Mensual)</h5>
                        <small class="text-muted">Resumen de gastos de Insumos por mes</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="spendingChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Gráfico de Gastos Diarios -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5>Reporte de Gastos en Insumos (Semanal)</h5>
                        <small class="text-muted">Resumen de gastos de Insumos por día</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="dailySpendingChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Gráfico de Productos Más Comprados en el Mes -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5>Productos Más Comprados (Mes)</h5>
                        <small class="text-muted">Top 5 productos más comprados del mes</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="topProductsMonthChart" style="height: 200px;"></canvas>
                </div>
            </div>
        </div>
        <!-- Gráfico de Productos Más Comprados en el Año -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5>Productos Más Comprados (Año)</h5>
                        <small class="text-muted">Top 5 productos más comprados del año</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="topProductsYearChart" style="height: 100px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Gastos Mensuales
        var ctx = document.getElementById('spendingChart').getContext('2d');
        var spendingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months, 15, 512) ?>,
                datasets: [{
                    label: 'Gastos por Mes (Bs)',
                    data: <?php echo json_encode($spendings, 15, 512) ?>,
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

        // Gráfico de Gastos Diarios
        var ctx2 = document.getElementById('dailySpendingChart').getContext('2d');
        var dailySpendingChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($daysOfWeek, 15, 512) ?>,
                datasets: [{
                    label: 'Gastos por Día (Bs)',
                    data: <?php echo json_encode($dailySpendings, 15, 512) ?>,
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

        // Gráfico de Productos Más Comprados en el Mes
        var ctx3 = document.getElementById('topProductsMonthChart').getContext('2d');
        var topProductsMonthChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($topProductsMonth['productNames'], 15, 512) ?>,
                datasets: [{
                    label: 'Cantidad del Mes',
                    data: <?php echo json_encode($topProductsMonth['productAmounts'], 15, 512) ?>,
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

        // Gráfico de Productos Más Comprados en el Año
        var ctx4 = document.getElementById('topProductsYearChart').getContext('2d');
        var topProductsYearChart = new Chart(ctx4, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($topProductsYear['productNames'], 15, 512) ?>,
                datasets: [{
                    label: 'Cantidad Por Año',
                    data: <?php echo json_encode($topProductsYear['productAmounts'], 15, 512) ?>,
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
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/home.blade.php ENDPATH**/ ?>