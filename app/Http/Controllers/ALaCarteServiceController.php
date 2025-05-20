<?php

namespace App\Http\Controllers;

use App\Models\ALaCarteService;
use Illuminate\Http\Request;

class ALaCarteServiceController extends Controller
{
    public function index()
    {
        $services = ALaCarteService::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.a_la_carte_services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_variable' => 'boolean',
            'price' => 'required|numeric|min:0',
        ]);

        // Asegurar booleano correcto (checkbox puede no enviarse)
        $data['is_variable'] = $request->has('is_variable');

        ALaCarteService::create($data);

        return redirect()->route('a_la_carte_services.index')->with('success', 'Servicio a la carta creado correctamente.');
    }

    public function update(Request $request, ALaCarteService $aLaCarteService)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_variable' => 'boolean',
            'price' => 'required|numeric|min:0',
        ]);

        $data['is_variable'] = $request->has('is_variable');

        $aLaCarteService->update($data);

        return redirect()->route('a_la_carte_services.index')->with('success', 'Servicio a la carta actualizado correctamente.');
    }

    public function destroy(ALaCarteService $aLaCarteService)
    {
        $aLaCarteService->delete();

        return redirect()->route('a_la_carte_services.index')->with('success', 'Servicio a la carta eliminado correctamente.');
    }
}