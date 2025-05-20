<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = ServiceCategory::paginate(10);
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        ServiceCategory::create($request->all());

        return redirect()->route('service_categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('admin.service_categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('admin.service_categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = ServiceCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('service_categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('service_categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}