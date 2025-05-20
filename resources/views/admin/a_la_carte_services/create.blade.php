@extends('admin.layout')

@section('content')
<h1>Crear Extra a la Carta</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('a_la_carte_services.store') }}" method="POST">
    @csrf
    <label>Nombre:</label><br>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="description">{{ old('description') }}</textarea><br><br>

    <label>Variable (¿Se puede variar cantidad?):</label><br>
    <select name="is_variable" required>
        <option value="1" {{ old('is_variable') == '1' ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ old('is_variable') == '0' ? 'selected' : '' }}>No</option>
    </select><br><br>

    <label>Precio (S/.):</label><br>
    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required><br><br>

    <button type="submit">Guardar</button>
</form>

<a href="{{ route('a_la_carte_services.index') }}">Volver</a>
@endsection