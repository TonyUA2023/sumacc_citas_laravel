@extends('admin.layout')

@section('content')
<h1>Editar Tipo de Vehículo #{{ $vehicle->id }}</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('vehicle_types.update', $vehicle->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name', $vehicle->name) }}" required><br><br>

    <label>Icono (opcional):</label><br>
    <input type="text" name="icon" value="{{ old('icon', $vehicle->icon) }}"><br><br>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('vehicle_types.index') }}">Volver</a>
@endsection