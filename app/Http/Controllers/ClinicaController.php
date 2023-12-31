<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinica;
use App\Models\ResultResponse;

class ClinicaController extends Controller
{
    /**
     * Devuelve todas las citas disponibles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $clinicas = Clinica::getAllClinicas();
       
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($clinicas);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
    
        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * Devuelve los detalles de una cita encontrada a través de su id.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $resultResponse =  new ResultResponse();

        try {
            $clinica = Clinica::getClinicaById($id);

            $resultResponse->setData($clinica);
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
     * Crea una nueva cita validando que los campos necesarios están rellenados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse =  new ResultResponse();  

        try {
            $this->validateClinica($request, $requestContent);

            $newClinica = new Clinica([
                'id_clinica' => $requestContent['id_clinica'],
                'nombre' => $requestContent['nombre']
            ]);

            $newClinica->createClinica();

            $resultResponse->setData($newClinica);
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
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $resultResponse =  new ResultResponse();       

        try {
            $this->validateClinica($request, $requestContent);

            try {
                $clinica = Clinica::getClinicaById($id);
                if($requestContent['id_clinica']) {
                    $clinica->id_clinica = $requestContent['id_clinica'];
                }

                if($requestContent['nombre']) {
                    $clinica->nombre = $requestContent['nombre'];
                }

                $clinica->updateClinica();

                $resultResponse->setData($clinica);
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
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $resultResponse =  new ResultResponse();       

        try {
            $clinica = Clinica::getClinicaById($id);
            if(isset($requestContent['id_clinica'])) {
                $clinica->id_clinica = $requestContent['id_clinica'];
            }

            if(isset($requestContent['nombre'])) {
                $clinica->nombre = $requestContent['nombre'];
            }

            $clinica->updateClinica();

            $resultResponse->setData($clinica);
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
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $clinica = Clinica::getClinicaById($id);
            $clinica->deleteClinica();
            
            $resultResponse->setData($clinica);
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
     * Search clinica by a given search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestData = $request->json()->all();
        $searchTerm = isset($requestData['search_term']) ? $requestData['search_term'] : '';
        $resultResponse = new ResultResponse();

        $clinicas = Clinica::searchClinicas($searchTerm);

        if ($clinicas->isEmpty()) {
            $resultResponse->setData("No existen clinicas para los criterios de búsqueda.");
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);            
        } else {
            $resultResponse->setData($clinicas);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type', 'application/json');
    }



    private function validateClinica($request, $content)
    {
        $rules = [];

        $validationRules = [
            'id_clinica' => 'required',
            'nombre' => 'string|nullable'
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
