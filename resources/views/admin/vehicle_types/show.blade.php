@extends('admin.layout')

@section('content')
<h1>Detalle Tipo de Vehículo #{{ $vehicle->id }}</h1>

<p><strong>Nombre:</strong> {{ $vehicle->name }}</p>
<p><strong>Icono:</strong> {{ $vehicle->icon }}</p>

<a href="{{ route('vehicle_types.index') }}">Volver</a>
@endsection

