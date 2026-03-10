<?php

namespace App\Http\Controllers;

use App\Models\Colono;
use Illuminate\Http\Request;

class ColonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colonos = Colono::orderBy('nombre_completo')->paginate(10);

        return view('colonos.index', compact('colonos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colonos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:30'],
            'correo' => ['nullable', 'email', 'max:255'],
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'correo.email' => 'El correo debe tener un formato válido.',
        ]);

        Colono::create($validated);

        return redirect()
            ->route('colonos.index')
            ->with('success', 'Colono registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colono $colono)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colono $colono)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colono $colono)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colono $colono)
    {
        //
    }
}
