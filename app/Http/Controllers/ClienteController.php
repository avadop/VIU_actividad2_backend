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
    public function getAll()
    {
        $clientes = Cliente::getAllClientes();        

        $resultResponse =  new ResultResponse();
        $resultResponse->setData($clientes);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function getById(string $id)
    {
        $cliente = Cliente::getClienteById($id);        

        try {
            $resultResponse =  new ResultResponse();
            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */
    public function getMascotas($id)
    {
        $resultResponse =  new ResultResponse();

        try{
            $cliente = Cliente::getClienteById($id);
            $mascotas = $cliente->mascotas;

            $resultResponse->setData($mascotas);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $resultResponse =  new ResultResponse();      
        $requestContent = json_decode($request->getContent(), true);  
        
        $this->validaCliente($request);
        try {
            $nuevoCliente = new Cliente([
                'dni' => $requestContent['dni'],
                'correo_electronico' => $requestContent['correo_electronico'],
                'direccion' => $requestContent['direccion'],
                'nombre' => $requestContent['nombre'],
                'apellidos' => $requestContent['apellidos'],
                'contrasenya' => $requestContent['contrasenya'],
                'telefono' => $requestContent['telefono']
            ]);

            // Cliente::createCliente($nuevoCliente);
            $nuevoCliente->createCliente();

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $requestContent = json_decode($request->getContent(), true);
        $this->validaCliente($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {

            $cliente = Cliente::getClienteById($id);
            if($requestContent['direccion']) {
                $cliente->direccion = $requestContent['direccion'];
            }

            if($requestContent['nombre']){
                $cliente->nombre = $requestContent['nombre'];
            }

            if($requestContent['apellidos']){
                $cliente->apellidos = $requestContent['apellidos'];
            }

            if($requestContent['telefono']){
                $cliente->telefono = $requestContent['telefono'];
            }

            if( $requestContent['correo_electronico']) {
                $cliente->correo_electronico = $requestContent['correo_electronico'];
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
    public function delete(string $id)
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

    private function validaCliente($request, $content)
    {
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
            if (isset($content[$field])) {
                $rules[$field] = $validationRule;
            }
        }

        $validatedData = $request->validate($rules);

        return $validatedData;
    }

}
