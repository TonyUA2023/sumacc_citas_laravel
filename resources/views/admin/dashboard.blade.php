@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-8">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white shadow rounded p-6 text-center">
        <h2 class="text-lg font-semibold mb-2">Clientes</h2>
        <p class="text-4xl font-bold">{{ $totalCustomers }}</p>
    </div>
    <div class="bg-white shadow rounded p-6 text-center">
        <h2 class="text-lg font-semibold mb-2">Citas</h2>
        <p class="text-4xl font-bold">{{ $totalAppointments }}</p>
    </div>
    <div class="bg-white shadow rounded p-6 text-center">
        <h2 class="text-lg font-semibold mb-2">Servicios a la Carta</h2>
        <p class="text-4xl font-bold">{{ $totalServicesALaCarte }}</p>
    </div>
    <div class="bg-white shadow rounded p-6 text-center">
        <h2 class="text-lg font-semibold mb-2">Servicios</h2>
        <p class="text-4xl font-bold">{{ $totalServices }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4">Citas por Estado</h3>
        <canvas id="appointmentsStatusChart" class="w-full h-64"></canvas>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4">Citas por Categoría</h3>
        <canvas id="appointmentsCategoryChart" class="w-full h-64"></canvas>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4">Ingresos Mensuales (Últimos 6 meses)</h3>
        <canvas id="monthlyRevenueChart" class="w-full h-64"></canvas>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Citas por estado
    const ctxStatus = document.getElementById('appointmentsStatusChart').getContext('2d');
    const appointmentsStatusChart = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: @json($appointmentsByStatus->keys()),
            datasets: [{
                data: @json($appointmentsByStatus->values()),
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Citas por categoría
    const ctxCategory = document.getElementById('appointmentsCategoryChart').getContext('2d');
    const appointmentsCategoryChart = new Chart(ctxCategory, {
        type: 'bar',
        data: {
            labels: @json($appointmentsByCategory->keys()),
            datasets: [{
                label: 'Número de citas',
                data: @json($appointmentsByCategory->values()),
                backgroundColor: '#3B82F6',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, precision: 0 }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Ingresos mensuales
    const ctxRevenue = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyRevenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: @json($monthlyRevenueFull->keys()->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'))),
            datasets: [{
                label: 'Ingresos (S/.)',
                data: @json($monthlyRevenueFull->values()),
                fill: false,
                borderColor: '#10B981',
                backgroundColor: '#10B981',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection