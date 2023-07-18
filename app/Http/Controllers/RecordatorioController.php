<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recordatorio;
use App\Models\ResultResponse;
use Illuminate\Validation\Rule;

class RecordatorioController extends Controller
{
     /**
     * Devuelve todas las recordatorios disponibles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $recordatorios = Recordatorio::getAllRecordatorios();
       
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($recordatorios);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
    
        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * Devuelve los detalles de una recordatorio encontrada a través de su id.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $resultResponse =  new ResultResponse();

        try {
            $recordatorio = Recordatorio::getRecordatorioById($id);

            $resultResponse->setData($recordatorio);
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
     * Crea una nueva recordatorio validando que los campos necesarios están rellenados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse =  new ResultResponse();  

        $this->validateRecordatorio($request, $requestContent);
        try {
            $newRecordatorio = new Recordatorio([
                'fecha_inicio' => $requestContent['fecha_inicio'],
                'periodicidad' => $requestContent['periodicidad'],
                'motivo' => $requestContent['motivo'],
                'metodo_envio' => $requestContent['metodo_envio'],
                'num_chip' => $requestContent['num_chip'],
                'id_clinica' => $requestContent['id_clinica'],
            ]);

            $newRecordatorio->createRecordatorio();

            $resultResponse->setData($newRecordatorio);
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
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);
        $this->validateRecordatorio($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {

            $recordatorio = Recordatorio::getRecordatorioById($id);

            if(isset($requestContent['fecha_inicio'])) {
                $recordatorio->fecha_inicio = $requestContent['fecha_inicio'];
            }

            if(isset($requestContent['periodicidad'])){
                $recordatorio->periodicidad = $requestContent['periodicidad'];
            }

            if(isset($requestContent['motivo'])) {
                $recordatorio->motivo = $requestContent['motivo'];
            }

            if(isset($requestContent['metodo_envio'])) {
                $recordatorio->metodo_envio = $requestContent['metodo_envio'];
            }

            if(isset($requestContent['num_chip'])) {
                $recordatorio->num_chip = $requestContent['num_chip'];
            }

            if(isset($requestContent['id_clinica'])) {
                $recordatorio->id_clinica = $requestContent['id_clinica'];
            }

            $recordatorio->updateRecordatorio();

            $resultResponse->setData($recordatorio);
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
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $recordatorio = Recordatorio::getRecordatorioById($id);
            $recordatorio->deleteRecordatorio();
            
            $resultResponse->setData($recordatorio);
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

    public function getRecordatoriosMascota($num_chip) {
        $resultResponse =  new ResultResponse();

        try {
            $recordatorios = Recordatorio::findRecordatoriosByNumChip($num_chip);

            $resultResponse->setData($recordatorios);
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

    public function getRecordatoriosClinica($id_clinica) {
        $resultResponse =  new ResultResponse();

        try {
            $recordatorio = Recordatorio::findRecordatoriosByIdClinica($id_clinica);

            $resultResponse->setData($recordatorio);
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

    private function validateRecordatorio($request, $content)
    {
        $rules = [];

        $validationRules = [
            'fecha_inicio' => 'required',
            'periodicidad' => 'required',
            'motivo' => 'required',
            'metodo_envio' => 'required',
            'num_chip' => 'required',
            'id_clinica' => 'required'
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
