@extends('admin.layout')

@section('content')
<h1>Crear Cliente</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <label>Teléfono:</label><br>
    <input type="text" name="phone_number" value="{{ old('phone_number') }}"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}"><br><br>

    <label>Dirección:</label><br>
    <textarea name="address">{{ old('address') }}</textarea><br><br>

    <button type="submit">Guardar</button>
</form>

<a href="{{ route('customers.index') }}">Volver</a>
@endsection