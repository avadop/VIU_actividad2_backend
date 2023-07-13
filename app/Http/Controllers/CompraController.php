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
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */

     public function getById($id)
    {
        $resultResponse =  new ResultResponse();

        try {
            $compra = Compra::getCompraById($id);

            $resultResponse->setData($compra);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch(\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

     public function create(Request $request)
     {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse =  new ResultResponse();  

        $this->validateCompra($request, $requestContent);
        try {
            $newCompra = new Compra([
                'id_producto' => $requestContent['id_producto'],
                'dni' => $requestContent['dni'],
                'fecha_compra' => $requestContent['fecha_compra'],
            ]);

            $newCompra->createCompra();

            $resultResponse->setData($newCompra);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        

        } catch(\Exception $e){
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        $resultResponse->setMessage($requestContent);



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

     public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $this->validateCompra($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {

            $compra = Compra::getCompraById($id);

            if($requestContent['id_producto']) {
                $compra->id_producto = $requestContent['id_producto'];
            }

            if($requestContent['dni']) {
                $compra->dni = $requestContent['dni'];
            }

            if($requestContent['fecha_compra']) {
                $compra->fecha_compra = $requestContent['fecha_compra'];
            }

            $compra->updateCompra();

            $resultResponse->setData($compra);
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
     * @param  \App\Models\Compra  $recordatorio
     * @return \Illuminate\Http\Response
     */

    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $compra = Compra::getCompraById($id);
            $compra->deleteCompra();
            
            $resultResponse->setData($compra);
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

    public function getComprasDNI($dni) {
        $resultResponse =  new ResultResponse();

        try {
            $compra = Compra::findComprasByDNI($dni);

            $resultResponse->setData($compra);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch(\Exception $e) {
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
