@extends('admin.layout')

@section('content')
<h1>Crear Tipo de Vehículo</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('vehicle_types.store') }}" method="POST">
    @csrf
    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <label>Icono (opcional):</label><br>
    <input type="text" name="icon" value="{{ old('icon') }}"><br><br>

    <button type="submit">Guardar</button>
</form>

<a href="{{ route('vehicle_types.index') }}">Volver</a>
@endsection