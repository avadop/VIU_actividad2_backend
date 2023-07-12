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
        $this->validaCliente($request);

        $resultResponse =  new ResultResponse();        

        try {
            $nuevoCliente = new Cliente([
                'dni' => $request->get('dni'),
                'correo_electronico' => $request->get('correo_electronico'),
                'direccion' => $request->get('direccion'),
                'nombre' => $request->get('nombre'),
                'apellidos' => $request->get('apellidos'),
                'contrasenya' => $request->get('contrasenya'),
                'telefono' => $request->get('telefono')
            ]);

            // Cliente::createCliente($nuevoCliente);
            $nuevoCliente->crearCliente();

            $resultResponse->setData($nuevoCliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

   /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $resultResponse =  new ResultResponse();

        try {
            $cliente = Cliente::getClienteById($id);

            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch(\Exception $e) {
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
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
        $this->validaCliente($request);

        $resultResponse =  new ResultResponse();       

        try {

            $cliente = Cliente::getClienteById($id);
            if( $request->get('direccion')) {
                $cliente->direccion = $request->get('direccion');
            }

            if($request->get('nombre')){
                $cliente->nombre = $request->get('nombre');
            }

            if($request->get('apellidos')){
                $cliente->apellidos = $request->get('apellidos');
            }

            if($request->get('telefono')){
                $cliente->telefono = $request->get('telefono');
            }

            if( $request->get('correo_electronico')) {
                $cliente->correo_electronico = $request->get('correo_electronico');
            }

            $cliente->actualizarCliente();

            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    
    /**
     * Put the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, string $id)
    {
        $this->validaCliente($request);
        
        $resultResponse =  new ResultResponse();

        try {
            $cliente = Cliente::getClienteById($id);
            if( $request->get('direccion')) {
                $cliente->direccion = $request->get('direccion');
            }

            if($request->get('nombre')){
                $cliente->nombre = $request->get('nombre');
            }

            if($request->get('apellidos')){
                $cliente->apellidos = $request->get('apellidos');
            }

            if($request->get('telefono')){
                $cliente->telefono = $request->get('telefono');
            }

            if( $request->get('correo_electronico')) {
                $cliente->correo_electronico = $request->get('correo_electronico');
            }


            $cliente->actualizarCliente();

            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $resultResponse =  new ResultResponse();

        try{
            $cliente = Cliente::getClienteById($id);
            $cliente->deleteCliente();
            
            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    public function logIn($dni, $password) {
        $resultResponse =  new ResultResponse();

        try{
            $cliente = Cliente::getClienteById($dni);
            $cliente->checkClientPassword($dni, $password);
            
            $resultResponse->setData($cliente['dni']);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    private function validaCliente($request)
    {
        $data = $request->all();
        $rules = [];

        $validationRules = [
            'dni' => 'required',
            'correo_electronico' => 'required|email',
            'direccion' => 'required',
            'nombre' => 'required',
            'apellidos' => 'required',
            'contrasenya' => 'required',
            'telefono' => 'required'
        ];

        foreach ($validationRules as $field => $validationRule) {
            if (isset($data[$field])) {
                $rules[$field] = $validationRule;
            }
        }

        $validatedData = $request->validate($rules);

        return $validatedData;
    }

}
