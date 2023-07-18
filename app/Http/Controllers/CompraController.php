<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use App\Models\ResultResponse;
use Illuminate\Console\Command;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $compras = Compra::getAllCompras();
        
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($compras);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $id_producto
     * @param  \Illuminate\Http\Request  $dni
     * @return \Illuminate\Http\Response
     */

    public function getById($id_producto, $dni)
    {
        $resultResponse =  new ResultResponse();

        try {
            $compra = Compra::getCompraById($id_producto, $dni);

            $resultResponse->setData($compra);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e) {
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
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse =  new ResultResponse();  

        $this->validateCompra($request, $requestContent);

        try {
            $newCompra = new Compra([
                'fecha_compra' => $requestContent['fecha_compra'],
                'id_producto' => $requestContent['id_producto'],
                'dni' => $requestContent['dni'],
            ]);

            //var_dump($newCompra);

            $newCompra->createCompra();

            $resultResponse->setData($newCompra);
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
     * @param  \App\Models\Compra  $recordatorio
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id_producto, $dni)
    {
        $requestContent = json_decode($request->getContent(), true);
        $this->validateCompra($request, $requestContent);

        $resultResponse =  new ResultResponse();

        try {

            $compra = Compra::getCompraById($id_producto, $dni);

            if(isset($requestContent['id_producto'])) {
                $compra->id_producto = $requestContent['id_producto'];
            }

            if(isset($requestContent['dni'])) {
                $compra->dni = $requestContent['dni'];
            }

            if(isset($requestContent['fecha_compra'])) {
                $compra->fecha_compra = $requestContent['fecha_compra'];
            }

            $compra->updateCompra($id_producto, $dni, $requestContent);

            $resultResponse->setData($compra);
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
     * @param  \App\Models\Compra  $recordatorio
     * @return \Illuminate\Http\Response
     */

    public function delete(string $id_producto, string $dni)
    {
       $resultResponse =  new ResultResponse();

        try{
            $compra = Compra::getCompraById($id_producto, $dni);
            $compra->deleteCompra($id_producto, $dni);
            
            $resultResponse->setData($compra);
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
     * Display a listing of the resource.
     *
     * @param  \App\Models\Compra  $dni
     * @return \Illuminate\Http\Response
     */
    public function getComprasDNI(string $dni) 
    {
        $resultResponse = new ResultResponse();

        try {
            $compra = Compra::findComprasByDNI($dni);

            if ($compra->isEmpty()) {
                throw new \Exception('No query results for model [App\\Models\\Compra].');
            }

            $resultResponse->setData($compra);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        } catch(\Exception $e) {
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    private function validateCompra($request, $content)
    {
        $rules = [];

        $validationRules = [
            'id_producto' => 'required',
            'dni' => 'required',
            'fecha_compra' => 'required'
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
