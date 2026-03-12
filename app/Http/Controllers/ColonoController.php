<?php

namespace App\Http\Controllers;

use App\Models\Colono;
use Illuminate\Http\Request;


class ColonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $sort = $request->get('sort', 'nombre_completo');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = [
            'nombre_completo',
            'direccion',
            'telefono',
            'correo',
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nombre_completo';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $colonos = Colono::with('ultimoPago')
            ->when($search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('nombre_completo', 'like', "%{$search}%")
                        ->orWhere('telefono', 'like', "%{$search}%")
                        ->orWhere('correo', 'like', "%{$search}%")
                        ->orWhere('direccion', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('colonos.index', compact('colonos', 'search', 'sort', 'direction'));
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
            'telefono' => ['required', 'numeric', 'digits:10'],
            'correo' => ['nullable', 'email', 'max:255'],
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.numeric' => 'El teléfono debe ser un número.',
            'telefono.digits' => 'El teléfono debe tener 10 dígitos.',
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
        $colono->load(['pagos', 'ultimoPago']);

        return view('colonos.show', compact('colono'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colono $colono)
    {
        return view('colonos.edit', compact('colono'));
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
        $colono->delete();

        return redirect()
        ->route('colonos.index')
        ->with('success', 'Colono eliminado correctamente.');
    }
}
