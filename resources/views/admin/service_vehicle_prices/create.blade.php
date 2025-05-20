@extends('admin.layout')

@section('content')
<h1>Agregar Precio Servicio - Vehículo</h1>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        <ul>
        @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('service_vehicle_prices.store') }}" method="POST" class="space-y-4 max-w-md">
    @csrf

    <div>
        <label class="block font-semibold">Servicio:</label>
        <select name="service_id" required class="w-full border rounded px-3 py-2">
            <option value="">Seleccione</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                    {{ $service->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold">Tipo de Vehículo:</label>
        <select name="vehicle_type_id" required class="w-full border rounded px-3 py-2">
            <option value="">Seleccione</option>
            @foreach ($vehicleTypes as $vehicle)
                <option value="{{ $vehicle->id }}" {{ old('vehicle_type_id') == $vehicle->id ? 'selected' : '' }}>
                    {{ $vehicle->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold">Precio (S/.):</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full border rounded px-3 py-2" />
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
</form>

<a href="{{ route('service_vehicle_prices.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Volver</a>
@endsection