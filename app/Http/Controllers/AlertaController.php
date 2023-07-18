<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alerta;
use App\Models\ResultResponse;
class AlertaController extends Controller
{
    /**
     * Devuelve todas las alertas disponibles.
     *
     * @return \Illuminate\Http\Response
     */

     public function getAll()
    {
        $alertas = Alerta::getAllAlertas();
       
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($alertas);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
    
        return response($json)->header('Content-Type', 'application/json');
    }
    
    /**
     * Devuelve los detalles de una alerta encontrada a través de su id.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */

     public function getById($id)
    {
        $resultResponse =  new ResultResponse();

        try {
            $alertas = Alerta::getAlertaById($id);

            $resultResponse->setData($alertas);
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
     * Crea una nueva alerta validando que los campos necesarios están rellenados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function create(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse =  new ResultResponse();  

        $this->validateAlerta($request, $requestContent);

        try {
            $newAlerta = new Alerta([
                'mensaje' => $requestContent['mensaje'],
                'stock_restante' => $requestContent['stock_restante'],
                'fecha_alerta' => $requestContent['fecha_alerta'],
                'id_producto' => $requestContent['id_producto'],
            ]);

            $newAlerta->createAlerta();

            $resultResponse->setData($newAlerta);
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
     * @param  \App\Models\Alerta  $alerta
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $this->validateAlerta($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {

            $alerta = Alerta::getAlertaById($id);
            if(isset($requestContent['mensaje'])) {
                $alerta->mensaje = $requestContent['mensaje'];
            }

            if(isset($requestContent['stock_restante'])) {
                $alerta->stock_restante = $requestContent['stock_restante'];
            }

            if(isset($requestContent['fecha_alerta'])){
                $alerta->fecha_alerta = $requestContent['fecha_alerta'];
            }

            if(isset($requestContent['id_producto'])) {
                $alerta->id_producto = $requestContent['id_producto'];
            }

            $alerta->updateAlerta();

            $resultResponse->setData($alerta);
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
     * @param  \App\Models\Alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $alerta = Alerta::getAlertaById($id);
            $alerta->deleteAlerta();
            
            $resultResponse->setData($alerta);
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

    public function getAlertasProducto($id_producto) {
        $resultResponse =  new ResultResponse();

        try {
            $alerta = Alerta::findAlertasByidProducto($id_producto);

            $resultResponse->setData($alerta);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch(\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    private function validateAlerta($request, $content)
    {
        $rules = [];

        $validationRules = [
            'mensaje' => 'required',
            'stock_restante' => 'required',
            'fecha_alerta' => 'required',
            'id_producto' => 'required'
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
