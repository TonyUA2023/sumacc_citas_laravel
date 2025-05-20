@extends('admin.layout')

@section('content')
<h1>Editar Extra a la Carta #{{ $extra->id }}</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('a_la_carte_services.update', $extra->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name', $extra->name) }}" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="description">{{ old('description', $extra->description) }}</textarea><br><br>

    <label>Variable (¿Se puede variar cantidad?):</label><br>
    <select name="is_variable" required>
        <option value="1" {{ (old('is_variable', $extra->is_variable) == '1') ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ (old('is_variable', $extra->is_variable) == '0') ? 'selected' : '' }}>No</option>
    </select><br><br>

    <label>Precio (S/.):</label><br>
    <input type="number" step="0.01" name="price" value="{{ old('price', $extra->price) }}" required><br><br>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('a_la_carte_services.index') }}">Volver</a>
@endsection