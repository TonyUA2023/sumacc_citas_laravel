@extends('admin.layout')

@section('content')
<h1>Crear Categoría</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('service_categories.store') }}" method="POST">
    @csrf
    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <button type="submit">Guardar</button>
</form>

<a href="{{ route('service_categories.index') }}">Volver</a>
@endsection