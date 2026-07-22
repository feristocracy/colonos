<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Proyecto::class);

        $proyectos = Proyecto::query()
            ->with(['creador', 'lideres'])
            ->withSum([
                'movimientos as total_entradas' => fn ($query) =>
                    $query->whereIn('tipo', ['saldo_inicial', 'entrada']),
            ], 'monto')
            ->withSum([
                'movimientos as total_salidas' => fn ($query) =>
                    $query->where('tipo', 'salida'),
            ], 'monto')
            ->latest()
            ->paginate(10);

        return view('proyectos.index', compact('proyectos'));
    }

    public function create(): View
    {
        Gate::authorize('create', Proyecto::class);

        $usuarios = User::query()
            ->orderBy('name')
            ->get();

        return view('proyectos.create', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Proyecto::class);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'monto_inicial' => ['required', 'numeric', 'min:0'],

            'lideres' => [
                'required',
                'array',
                'min:1',
            ],

            'lideres.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('users', 'id'),
            ],
        ]);

        $proyecto = DB::transaction(function () use ($datos, $request) {
            $proyecto = Proyecto::create([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'monto_inicial' => $datos['monto_inicial'],
                'creado_por' => $request->user()->id,
            ]);

            $proyecto->lideres()->attach($datos['lideres']);

            $proyecto->movimientos()->create([
                'registrado_por' => $request->user()->id,
                'tipo' => 'saldo_inicial',
                'monto' => $datos['monto_inicial'],
                'concepto' => 'Saldo inicial del proyecto',
                'descripcion' => 'Monto registrado al crear el proyecto.',
            ]);

            $proyecto->auditorias()->create([
                'user_id' => $request->user()->id,
                'accion' => 'proyecto_creado',
                'descripcion' => "Creó el proyecto {$proyecto->nombre}.",
                'datos' => [
                    'nombre' => $proyecto->nombre,
                    'monto_inicial' => $proyecto->monto_inicial,
                    'lideres' => $datos['lideres'],
                ],
            ]);

            $lideres = User::query()
                ->whereIn('id', $datos['lideres'])
                ->get();

            foreach ($lideres as $lider) {
                $proyecto->auditorias()->create([
                    'user_id' => $request->user()->id,
                    'accion' => 'lider_agregado',
                    'descripcion' => "Asignó a {$lider->name} como líder del proyecto.",
                    'datos' => [
                        'lider_id' => $lider->id,
                        'lider_nombre' => $lider->name,
                    ],
                ]);
            }

            return $proyecto;
        });

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Proyecto $proyecto): View
    {
        Gate::authorize('view', $proyecto);

        $proyecto->load([
            'creador',
            'lideres',
        ]);

        $movimientos = $proyecto->movimientos()
            ->with('usuario')
            ->latest()
            ->paginate(10, ['*'], 'movimientos_page');

        $auditorias = $proyecto->auditorias()
            ->with('usuario')
            ->latest()
            ->paginate(10, ['*'], 'auditorias_page');

        $usuariosDisponibles = collect();

         if (auth()->user()->role === 'admin') {
            $usuariosDisponibles = User::query()
                ->whereNotIn('id', $proyecto->lideres->pluck('id'))
                ->orderBy('name')
                ->get();
        }

        if (Gate::allows('gestionarLideres', $proyecto)) {
            $usuariosDisponibles = User::query()
                ->whereNotIn(
                    'id',
                    $proyecto->lideres->pluck('id')
                )
                ->orderBy('name')
                ->get();
        }

        $cotizacionConceptos = $proyecto->cotizacionConceptos()
            ->withCount('cotizaciones')
            ->latest()
            ->get();

        $notas = $proyecto->notas()
            ->with(['usuario', 'archivos'])
            ->latest()
            ->paginate(10, ['*'], 'notas_page');

        return view('proyectos.show', compact(
            'proyecto',
            'movimientos',
            'auditorias',
            'usuariosDisponibles',
            'cotizacionConceptos', 
            'notas',
        ));
    }

    public function agregarLider(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        Gate::authorize('gestionarLideres', $proyecto);

        $datos = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id'),
                Rule::unique('proyecto_lideres', 'user_id')
                    ->where(
                        fn ($query) => $query->where(
                            'proyecto_id',
                            $proyecto->id
                        )
                    ),
            ],
        ]);

        $lider = User::findOrFail($datos['user_id']);

        DB::transaction(function () use ($proyecto, $lider, $request) {
            $proyecto->lideres()->attach($lider->id);

            $proyecto->auditorias()->create([
                'user_id' => $request->user()->id,
                'accion' => 'lider_agregado',
                'descripcion' => "Agregó a {$lider->name} como líder del proyecto.",
                'datos' => [
                    'lider_id' => $lider->id,
                    'lider_nombre' => $lider->name,
                ],
            ]);
        });

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Líder agregado correctamente.');
    }

    public function eliminarLider(
        Request $request,
        Proyecto $proyecto,
        User $usuario
    ): RedirectResponse {
        Gate::authorize('gestionarLideres', $proyecto);

        $esLider = $proyecto->lideres()
            ->where('users.id', $usuario->id)
            ->exists();

        abort_unless($esLider, 404);

        if ($proyecto->lideres()->count() <= 1) {
            return redirect()
                ->route('proyectos.show', $proyecto)
                ->with(
                    'error',
                    'El proyecto debe conservar al menos un líder.'
                );
        }

        DB::transaction(function () use ($proyecto, $usuario, $request) {
            $proyecto->lideres()->detach($usuario->id);

            $proyecto->auditorias()->create([
                'user_id' => $request->user()->id,
                'accion' => 'lider_retirado',
                'descripcion' => "Retiró a {$usuario->name} como líder del proyecto.",
                'datos' => [
                    'lider_id' => $usuario->id,
                    'lider_nombre' => $usuario->name,
                ],
            ]);
        });

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Líder retirado correctamente.');
    }

    public function registrarMovimiento(Request $request, Proyecto $proyecto)
    {
        Gate::authorize('alimentar', $proyecto);

        $data = $request->validate([
            'tipo' => ['required', Rule::in(['entrada', 'salida'])],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'concepto' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'comprobante' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($data['tipo'] === 'salida' && $data['monto'] > $proyecto->saldo_actual) {
            return back()
                ->withErrors([
                    'monto' => 'La salida no puede ser mayor al saldo actual del proyecto.',
                ])
                ->withInput();
        }

        $comprobantePath = null;

        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('proyectos/comprobantes', 'public');
        }

        DB::transaction(function () use ($proyecto, $data, $comprobantePath) {
            $movimiento = $proyecto->movimientos()->create([
                'registrado_por' => auth()->id(),
                'tipo' => $data['tipo'],
                'monto' => $data['monto'],
                'concepto' => $data['concepto'],
                'descripcion' => $data['descripcion'] ?? null,
                'comprobante' => $comprobantePath,
            ]);

            $proyecto->auditorias()->create([
                'user_id' => auth()->id(),
                'accion' => 'movimiento_creado',
                'descripcion' => ucfirst($data['tipo']).' registrada: '.$data['concepto'],
                'datos' => [
                    'movimiento_id' => $movimiento->id,
                    'tipo' => $movimiento->tipo,
                    'monto' => $movimiento->monto,
                ],
            ]);
        });

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Movimiento registrado correctamente.');
    }

}
