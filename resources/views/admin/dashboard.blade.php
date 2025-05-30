@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<!-- Tarjetas de resumen -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Resumen General</h1>
        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Exportar Reporte
            </button>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center mb-3">
                <div class="p-3 rounded-full bg-blue-500 bg-opacity-20 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-blue-700">Total Clientes</h2>
                    <p class="text-3xl font-bold text-blue-900">{{ $totalCustomers }}</p>
                </div>
            </div>
            <div class="w-full bg-blue-200 bg-opacity-60 h-1 rounded-full overflow-hidden">
                <div class="bg-blue-600 h-1 rounded-full" style="width: 75%"></div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center mb-3">
                <div class="p-3 rounded-full bg-purple-500 bg-opacity-20 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-purple-700">Total Citas</h2>
                    <p class="text-3xl font-bold text-purple-900">{{ $totalAppointments }}</p>
                </div>
            </div>
            <div class="w-full bg-purple-200 bg-opacity-60 h-1 rounded-full overflow-hidden">
                <div class="bg-purple-600 h-1 rounded-full" style="width: 65%"></div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center mb-3">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-20 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-green-700">Servicios a la Carta</h2>
                    <p class="text-3xl font-bold text-green-900">{{ $totalServicesALaCarte }}</p>
                </div>
            </div>
            <div class="w-full bg-green-200 bg-opacity-60 h-1 rounded-full overflow-hidden">
                <div class="bg-green-600 h-1 rounded-full" style="width: 45%"></div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg shadow p-6 border-l-4 border-amber-500">
            <div class="flex items-center mb-3">
                <div class="p-3 rounded-full bg-amber-500 bg-opacity-20 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-amber-700">Servicios</h2>
                    <p class="text-3xl font-bold text-amber-900">{{ $totalServices }}</p>
                </div>
            </div>
            <div class="w-full bg-amber-200 bg-opacity-60 h-1 rounded-full overflow-hidden">
                <div class="bg-amber-600 h-1 rounded-full" style="width: 80%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Distribución de citas por día y hora -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Gráfico de citas por día de la semana -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Citas por Día de la Semana</h3>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Días más ocupados</span>
        </div>
        <canvas id="appointmentsByDayChart" class="w-full h-72"></canvas>
    </div>

    <!-- Gráfico de citas por hora -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Citas por Hora del Día</h3>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Horas pico</span>
        </div>
        <canvas id="appointmentsByHourChart" class="w-full h-72"></canvas>
    </div>
</div>

<!-- Gráficos principales -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Citas por estado -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Citas por Estado</h3>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $appointmentsByStatus->sum() }} Total</span>
        </div>
        <canvas id="appointmentsStatusChart" class="w-full h-64"></canvas>
    </div>

    <!-- Citas por categoría -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Citas por Categoría</h3>
            <div class="flex space-x-1">
                <button class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Mensual</button>
                <button class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">Anual</button>
            </div>
        </div>
        <canvas id="appointmentsCategoryChart" class="w-full h-64"></canvas>
    </div>

    <!-- Ingresos mensuales -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Ingresos Mensuales</h3>
            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">Últimos 6 meses</span>
        </div>
        <canvas id="monthlyRevenueChart" class="w-full h-64"></canvas>
    </div>
</div>

<!-- Fila inferior con próximas citas y tendencia semanal -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Próximas citas -->
    <div class="bg-white shadow-md rounded-lg p-6 lg:col-span-1">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Próximas Citas</h3>
            <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver todas</a>
        </div>
        
        <div class="space-y-4">
            @forelse($upcomingAppointments as $appointment)
            <div class="flex items-start p-3 rounded-lg {{ $loop->first ? 'bg-blue-50 border-l-4 border-blue-500' : 'hover:bg-gray-50' }}">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mr-3">
                    {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $appointment->customer->name }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $appointment->serviceVehiclePrice->service->name }}
                    </p>
                    <div class="flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }}</span>
                        <span class="mx-1 text-gray-300">|</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}</span>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                       ($appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
            @empty
            <div class="text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-500 text-sm">No hay citas próximas programadas</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Tendencia de citas por semana -->
    <div class="bg-white shadow-md rounded-lg p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tendencia de Citas</h3>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">Últimas 12 semanas</span>
        </div>
        <canvas id="appointmentsTrendChart" class="w-full h-64"></canvas>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Colores para gráficos
    const colors = {
        blue: '#3B82F6',
        green: '#10B981',
        amber: '#F59E0B',
        red: '#EF4444',
        purple: '#8B5CF6',
        indigo: '#6366F1',
        pink: '#EC4899',
        gray: '#6B7280'
    };
    
    const gradients = {
        blue: ['rgba(59, 130, 246, 0.8)', 'rgba(37, 99, 235, 0.2)'],
        green: ['rgba(16, 185, 129, 0.8)', 'rgba(5, 150, 105, 0.2)'],
        amber: ['rgba(245, 158, 11, 0.8)', 'rgba(217, 119, 6, 0.2)'],
        purple: ['rgba(139, 92, 246, 0.8)', 'rgba(124, 58, 237, 0.2)'],
        indigo: ['rgba(99, 102, 241, 0.8)', 'rgba(79, 70, 229, 0.2)'],
    };

    // Configuración común para tooltips
    const tooltipConfig = {
        backgroundColor: 'rgba(17, 24, 39, 0.9)',
        titleFont: { size: 13, weight: 'bold' },
        bodyFont: { size: 12 },
        padding: 12,
        cornerRadius: 6,
        displayColors: false,
        borderColor: 'rgba(255, 255, 255, 0.1)',
        borderWidth: 1
    };

    // Citas por día de la semana
    const ctxDays = document.getElementById('appointmentsByDayChart').getContext('2d');
    const daysData = @json($appointmentsByDayOfWeek);
    // Reordenar para que comience en lunes
    const orderedDays = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    const appointmentsByDayChart = new Chart(ctxDays, {
        type: 'bar',
        data: {
            labels: orderedDays,
            datasets: [{
                label: 'Número de citas',
                data: orderedDays.map(day => daysData[day] || 0),
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const { ctx, chartArea } = chart;
                    if (!chartArea) return colors.blue;
                    
                    // Destacar el día con más citas
                    const max = Math.max(...Object.values(daysData));
                    const dayValue = daysData[orderedDays[context.dataIndex]] || 0;
                    
                    if (dayValue === max) {
                        return colors.indigo;
                    }
                    return colors.blue;
                },
                borderRadius: 6,
                maxBarThickness: 40,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: '#f3f4f6'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    }
                }
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    ...tooltipConfig,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function(context) {
                            const value = context.raw;
                            const percentage = (value / Object.values(daysData).reduce((a, b) => a + b, 0) * 100).toFixed(1);
                            return `${value} citas (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Citas por hora del día
    const ctxHours = document.getElementById('appointmentsByHourChart').getContext('2d');
    const appointmentsByHourChart = new Chart(ctxHours, {
        type: 'line',
        data: {
            labels: Object.keys(@json($appointmentsByHour)),
            datasets: [{
                label: 'Número de citas',
                data: Object.values(@json($appointmentsByHour)),
                fill: {
                    target: 'origin',
                    above: 'rgba(99, 102, 241, 0.1)'
                },
                borderColor: colors.indigo,
                backgroundColor: colors.indigo,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: colors.indigo,
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: '#f3f4f6'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    }
                }
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    ...tooltipConfig,
                    callbacks: {
                        title: function(tooltipItems) {
                            return `Hora: ${tooltipItems[0].label}`;
                        },
                        label: function(context) {
                            return `${context.raw} citas`;
                        }
                    }
                }
            }
        }
    });

    // Citas por estado
    const ctxStatus = document.getElementById('appointmentsStatusChart').getContext('2d');
    const statusColors = [colors.blue, colors.green, colors.amber, colors.red, colors.purple];
    const appointmentsStatusChart = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: @json($appointmentsByStatus->keys()),
            datasets: [{
                data: @json($appointmentsByStatus->values()),
                backgroundColor: statusColors,
                borderWidth: 1,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        padding: 20, 
                        usePointStyle: true,
                        font: {
                            size: 11
                        }
                    } 
                },
                tooltip: {
                    ...tooltipConfig,
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '65%',
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
                backgroundColor: colors.purple,
                borderRadius: 6,
                maxBarThickness: 35,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true, 
                    precision: 0,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    ...tooltipConfig,
                    callbacks: {
                        label: function(context) {
                            return `${context.raw} citas`;
                        }
                    }
                }
            }
        }
    });

    // Ingresos mensuales
    const ctxRevenue = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyRevenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: @json($monthlyRevenueFull->keys()->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'))),
            datasets: [{
                label: 'Ingresos ($)',
                data: @json($monthlyRevenueFull->values()),
                fill: {
                    target: 'origin',
                    above: 'rgba(16, 185, 129, 0.1)'
                },
                borderColor: colors.green,
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: colors.green,
                pointBorderWidth: 2,
                pointRadius: 5,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: '#f3f4f6'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$ ' + value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    }
                }
            },
            plugins: {
                tooltip: {
                    ...tooltipConfig,
                    callbacks: {
                        label: function(context) {
                            return '$ ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Tendencia de citas por semana
    const ctxTrend = document.getElementById('appointmentsTrendChart').getContext('2d');
    const appointmentsTrendChart = new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: Object.keys(@json($appointmentsByWeek)),
            datasets: [{
                label: 'Citas por semana',
                data: Object.values(@json($appointmentsByWeek)),
                fill: {
                    target: 'origin',
                    above: function(context) {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) return 'rgba(99, 102, 241, 0.1)';
                        
                        const gradient = ctx.createLinearGradient(0, 0, 0, chartArea.height);
                        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
                        gradient.addColorStop(0.8, 'rgba(99, 102, 241, 0.02)');
                        return gradient;
                    }
                },
                borderColor: colors.indigo,
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: colors.indigo,
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: '#f3f4f6'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    }
                }
            },
            plugins: {
                tooltip: {
                    ...tooltipConfig,
                    callbacks: {
                        title: function(tooltipItems) {
                            return `Semana del ${tooltipItems[0].label}`;
                        },
                        label: function(context) {
                            return `${context.raw} citas`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection