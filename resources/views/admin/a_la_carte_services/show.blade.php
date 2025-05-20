@extends('admin.layout')

@section('content')
<h1>Detalle Extra a la Carta #{{ $extra->id }}</h1>

<p><strong>Nombre:</strong> {{ $extra->name }}</p>
<p><strong>Descripción:</strong> {{ $extra->description }}</p>
<p><strong>Variable:</strong> {{ $extra->is_variable ? 'Sí' : 'No' }}</p>
<p><strong>Precio:</strong> S/. {{ $extra->price }}</p>

<a href="{{ route('a_la_carte_services.index') }}">Volver</a>
@endsection