@extends('admin.layout')

@section('content')
<h1>Detalle Servicio #{{ $service->id }}</h1>

<p><strong>Nombre:</strong> {{ $service->name }}</p>
<p><strong>Categoría:</strong> {{ $service->category->name ?? 'N/A' }}</p>
<p><strong>Descripción:</strong> {{ $service->description }}</p>
<p><strong>Frecuencia recomendada:</strong> {{ $service->recommended_frequency }}</p>
<p><strong>Lema:</strong> {{ $service->tagline }}</p>
<p><strong>Duración base (minutos):</strong> {{ $service->base_duration_minutes }}</p>
<p><strong>Precio inicial:</strong> S/. {{ $service->starting_price }}</p>
<p><strong>Etiqueta de precio:</strong> {{ $service->price_label }}</p>
<p><strong>Descripción exterior:</strong> {{ $service->exterior_description }}</p>
<p><strong>Descripción interior:</strong> {{ $service->interior_description }}</p>

<a href="{{ route('services.index') }}">Volver</a>
@endsection