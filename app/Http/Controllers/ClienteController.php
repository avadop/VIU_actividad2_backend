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
        $resultResponse = new ResultResponse();
        
        try {
            $cliente = Cliente::getClienteById($id);        

            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setData($e->getMessage());
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
            $resultResponse->setData($e->getMessage());
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
        
        try {
            $this->validaCliente($request, $requestContent);

            $nuevoCliente = new Cliente([
                'dni' => $requestContent['dni'],
                'correo_electronico' => $requestContent['correo_electronico'],
                'direccion' => $requestContent['direccion'],
                'nombre' => $requestContent['nombre'],
                'apellidos' => $requestContent['apellidos'],
                'contrasenya' => $requestContent['contrasenya'],
                'telefono' => $requestContent['telefono']
            ]);

            $nuevoCliente->createCliente();

            $resultResponse->setData($nuevoCliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e->getMessage());
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

        $resultResponse =  new ResultResponse();   

        try {
            $this->validaCliente($request, $requestContent);

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

                if($requestContent['correo_electronico']) {
                    $cliente->correo_electronico = $requestContent['correo_electronico'];
                }

                $cliente->updateCliente();

                $resultResponse->setData($cliente);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

            } catch(\Exception $e){
                $resultResponse->setData($e->getMessage());
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
            }
        } catch(\Exception $e){
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_MISSING_DATA);
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
    public function patch(Request $request, string $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $resultResponse =  new ResultResponse();   

        try {
            $cliente = Cliente::getClienteById($id);

            if(isset($requestContent['direccion'])) {
                $cliente->direccion = $requestContent['direccion'];
            }

            if(isset($requestContent['nombre'])){
                $cliente->nombre = $requestContent['nombre'];
            }

            if(isset($requestContent['apellidos'])){
                $cliente->apellidos = $requestContent['apellidos'];
            }

            if(isset($requestContent['telefono'])){
                $cliente->telefono = $requestContent['telefono'];
            }

            if(isset($requestContent['correo_electronico'])) {
                $cliente->correo_electronico = $requestContent['correo_electronico'];
            }

            $cliente->updateCliente();

            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e){
            $resultResponse->setData($e->getMessage());
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
            $resultResponse->setData($e->getMessage());
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
        
            try{
                $cliente->checkClientPassword($dni, $password);

                $resultResponse->setData($cliente['dni']);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

            } catch(\Exception $e){
                $resultResponse->setData($e->getMessage());
                $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
                $resultResponse->setMessage('La contraseña introducida es incorrecta');
            }

        } catch(\Exception $e){
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage('El usuario no existe');
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    
     /**
     * Search clientes by a given search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestData = $request->json()->all();
        $searchTerm = isset($requestData['search_term']) ? $requestData['search_term'] : '';
        $resultResponse = new ResultResponse();

        $clientes = Cliente::searchClientes($searchTerm);

        if ($clientes->isEmpty()) {
            $resultResponse->setData("No existen clientes para los criterios de búsqueda.");
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);            
        } else {
            $resultResponse->setData($clientes);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
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
            if ($content[$field]) {
                $rules[$field] = $validationRule;
            }
        }

        $validatedData = $request->validate($rules);

        return $validatedData;
    }

}
