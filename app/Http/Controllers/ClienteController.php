<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ResultResponse;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::getAllClientes();        

        $resultResponse =  new ResultResponse();
        $resultResponse->setData($clientes);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        
        // return view('clientes.index', compact('clientes'));
        // return response()->json($resultResponse);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
    
        return response($json)->header('Content-Type', 'application/json');
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resultResponse =  new ResultResponse();
        
        // Validar los datos del formulario de creación
        $validatedData = $request->validate([
            'dni' => 'required|string|unique:cliente',
            'correo_electronico' => 'required|email|unique:cliente',
            'direccion' => 'required|string',
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'contrasenya' => 'required|string',
            'telefono' => 'required|integer',
        ]);

        // Crear un nuevo cliente con los datos validados
        $cliente = Cliente::createCliente($validatedData);

        // Redireccionar a la vista del cliente recién creado
        return redirect()->route('clientes.show', $cliente->dni);
    }

   /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario de edición
        $validatedData = $request->validate([
            'correo_electronico' => 'required|email|unique:cliente,correo_electronico,'.$cliente->dni.',dni',
            'direccion' => 'required|string',
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'contrasenya' => 'required|string',
            'telefono' => 'required|integer',
        ]);

        // Actualizar los datos del cliente con los datos validados
        $cliente->updateCliente($validatedData);

        // Redireccionar a la vista del cliente actualizado
        return redirect()->route('clientes.show', $cliente->dni);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Eliminar el cliente
        $cliente->deleteCliente();

        // Redireccionar a la lista de clientes
        return redirect()->route('clientes.index');
    }
}
