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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
