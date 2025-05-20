@extends('admin.layout')

@section('content')
<h1>Detalle Precio Servicio - Vehículo #{{ $price->id }}</h1>

<p><strong>Servicio:</strong> {{ $price->service->name ?? 'N/A' }}</p>
<p><strong>Tipo Vehículo:</strong> {{ $price->vehicleType->name ?? 'N/A' }}</p>
<p><strong>Precio:</strong> S/. {{ number_format($price->price, 2) }}</p>

<a href="{{ route('service_vehicle_prices.index') }}" class="text-blue-600 hover:underline">Volver</a>
@endsection