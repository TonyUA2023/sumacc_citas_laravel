@extends('admin.layout')

@section('content')
<h1>Detalle Categoría #{{ $category->id }}</h1>

<p><strong>Nombre:</strong> {{ $category->name }}</p>

<a href="{{ route('service_categories.index') }}">Volver</a>
@endsection