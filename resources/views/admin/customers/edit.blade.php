@extends('admin.layout')

@section('content')
<h1>Editar Cliente #{{ $customer->id }}</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required><br><br>

    <label>Teléfono:</label><br>
    <input type="text" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email', $customer->email) }}"><br><br>

    <label>Dirección:</label><br>
    <textarea name="address">{{ old('address', $customer->address) }}</textarea><br><br>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('customers.index') }}">Volver</a>
@endsection