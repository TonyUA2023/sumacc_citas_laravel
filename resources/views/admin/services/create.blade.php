<div
    x-show="createModalOpen"
    x-transition
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-auto p-4"
>
    <div @click.away="closeCreateModal()" class="bg-white rounded p-6 w-full max-w-4xl shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Crear Servicio</h2>
        <form method="POST" action="{{ route('services.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Nombre</label>
                    <input type="text" name="name" required class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="font-semibold">Categoría</label>
                    <select name="category_id" required class="w-full border rounded px-3 py-2">
                        <option value="">Seleccione categoría</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Tagline</label>
                    <input type="text" name="tagline" class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="font-semibold">Duración base (minutos)</label>
                    <input type="number" name="base_duration_minutes" min="0" class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="font-semibold">Frecuencia recomendada (días)</label>
                    <input type="number" name="recommended_frequency" min="0" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold">Descripción</label>
                    <textarea name="description" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div>
                    <label class="font-semibold">Precio inicial</label>
                    <input type="number" name="starting_price" min="0" step="0.01" class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="font-semibold">Etiqueta de precio</label>
                    <input type="text" name="price_label" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold">Descripción exterior</label>
                    <textarea name="exterior_description" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold">Descripción interior</label>
                    <textarea name="interior_description" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                </div>
            </div>

            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" @click="closeCreateModal()" class="px-4 py-2 border rounded hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-wavraBlue text-white rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>