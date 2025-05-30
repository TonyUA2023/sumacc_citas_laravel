@extends('admin.layout')

@section('content')
<h1>Precios Servicio - Vehículo</h1>

@if(session('success'))
    <p class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</p>
@endif

<a href="{{ route('service_vehicle_prices.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">Agregar Precio</a>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200 text-gray-700">
        <tr>
            <th class="py-2 px-4 text-left">ID</th>
            <th class="py-2 px-4 text-left">Servicio</th>
            <th class="py-2 px-4 text-left">Tipo Vehículo</th>
            <th class="py-2 px-4 text-left">Precio ($)</th>
            <th class="py-2 px-4 text-left">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prices as $price)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $price->id }}</td>
            <td class="py-2 px-4">{{ $price->service->name ?? 'N/A' }}</td>
            <td class="py-2 px-4">{{ $price->vehicleType->name ?? 'N/A' }}</td>
            <td class="py-2 px-4">{{ number_format($price->price, 2) }}</td>
            <td class="py-2 px-4 space-x-2">
                <a href="{{ route('service_vehicle_prices.show', $price->id) }}" class="text-blue-600 hover:underline">Ver</a>
                <a href="{{ route('service_vehicle_prices.edit', $price->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                <form action="{{ route('service_vehicle_prices.destroy', $price->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este precio?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $prices->links() }}
</div>
@endsection