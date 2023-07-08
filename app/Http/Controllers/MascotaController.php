<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;

class MascotaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mascotas = Mascota::all();
        return view('mascotas.index', compact('mascotas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mascotas.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario de creación
        $validatedData = $request->validate([
            'num_chip' => 'required|integer|unique:mascota',
            'nombre_mascota' => 'required|string',
            'edad' => 'required|integer',
            'sexo' => 'required|string',
            'especie' => 'required|string',
            'vacunas' => 'required|string',
            'informes_de_mascota' => 'required|json',
            'historial_clinico' => 'nullable|string',
            'dni' => 'required|string|exists:cliente',
        ]);

        // Crear una nueva mascota con los datos validados
        $mascota = Mascota::create($validatedData);

        // Redireccionar a la vista de la mascota recién creada
        return redirect()->route('mascotas.show', $mascota->num_chip);
    }

   /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return view('mascotas.show', compact('mascota'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        return view('mascotas.edit', compact('mascota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
         // Validar los datos del formulario de edición
         $validatedData = $request->validate([
            'nombre_mascota' => 'required|string',
            'edad' => 'required|integer',
            'sexo' => 'required|string',
            'especie' => 'required|string',
            'vacunas' => 'required|string',
            'informes_de_mascota' => 'required|json',
            'historial_clinico' => 'nullable|string',
            'dni' => 'required|string|exists:cliente',
        ]);

        // Actualizar los datos de la mascota con los datos validados
        $mascota->update($validatedData);

        // Redireccionar a la vista de la mascota actualizada
        return redirect()->route('mascotas.show', $mascota->num_chip);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Eliminar la mascota
        $mascota->delete();

        // Redireccionar a la lista de mascotas
        return redirect()->route('mascotas.index');
    }
}
