@extends('admin.layout')

@section('content')
<h1>Editar Categoría #{{ $category->id }}</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('service_categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name', $category->name) }}" required><br><br>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('service_categories.index') }}">Volver</a>
@endsection