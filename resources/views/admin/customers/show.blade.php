@extends('admin.layout')

@section('content')
<h1>Detalle Cliente #{{ $customer->id }}</h1>

<p><strong>Nombre:</strong> {{ $customer->name }}</p>
<p><strong>Teléfono:</strong> {{ $customer->phone_number }}</p>
<p><strong>Email:</strong> {{ $customer->email }}</p>
<p><strong>Dirección:</strong> {{ $customer->address }}</p>

<a href="{{ route('customers.index') }}">Volver</a>
@endsection