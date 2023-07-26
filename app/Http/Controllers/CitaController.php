<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\ResultResponse;

class CitaController extends Controller
{
    /**
     * Devuelve todas las citas disponibles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $citas = Cita::getAllCitas();
       
        $resultResponse = new ResultResponse();
        $resultResponse->setData($citas);
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
            $cita = Cita::getCitaById($id);

            $resultResponse->setData($cita);
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

        $this->validateCita($request, $requestContent);
        try {
            $newCita = new Cita([
                'hora' => $requestContent['hora'],
                'fecha' => $requestContent['fecha'],
                'modalidad_cita' => $requestContent['modalidad_cita'],
                'tipo_cita' => $requestContent['tipo_cita'],
                'num_chip' => $requestContent['num_chip'],
                'id_clinica' => $requestContent['id_clinica'],
            ]);

            $newCita->createCita();

            $resultResponse->setData($newCita);
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
     * @param  \App\Models\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $this->validateCita($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {

            $cita = Cita::getCitaById($id);
            if(isset($requestContent['hora'])) {
                $cita->hora = $requestContent['hora'];
            }

            if(isset($requestContent['fecha'])) {
                $cita->fecha = $requestContent['fecha'];
            }

            if(isset($requestContent['modalidad_cita'])) {
                $cita->modalidad_cita = $requestContent['modalidad_cita'];
            }

            if(isset($requestContent['tipo_cita'])) {
                $cita->tipo_cita = $requestContent['tipo_cita'];
            }

            if(isset($requestContent['num_chip'])) {
                $cita->num_chip = $requestContent['num_chip'];
            }

            if(isset($requestContent['id_clinica'])) {
                $cita->id_clinica = $requestContent['id_clinica'];
            }

            $cita->updateCita();

            $resultResponse->setData($cita);
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
     * @param  \App\Models\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $cita = Cita::getCitaById($id);
            $cita->deleteCita();
            
            $resultResponse->setData($cita);
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

    public function getCitasMascota($num_chip) {
        $resultResponse =  new ResultResponse();

        try {
            $cita = Cita::findCitasByNumChip($num_chip);

            $resultResponse->setData($cita);
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

    public function getCitasClinica($id_clinica) {
        $resultResponse =  new ResultResponse();

        try {
            $cita = Cita::findCitaByIdClinica($id_clinica);

            $resultResponse->setData($cita);
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

    public function getCitaHoraYFecha($hora, $fecha) {
        $resultResponse =  new ResultResponse();

        try {
            $cita = Cita::findCitaByDateAndTime($hora, $fecha);

            $resultResponse->setData($cita);
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
     * Search citas by a given search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestData = $request->json()->all();
        $searchTerm = isset($requestData['search_term']) ? $requestData['search_term'] : '';
        $resultResponse = new ResultResponse();

        $citas = Cita::searchCitas($searchTerm);

        if ($citas->isEmpty()) {
            $resultResponse->setData("No existen citas para los criterios de búsqueda.");
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);            
        } else {
            $resultResponse->setData($citas);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type', 'application/json');
    }

    private function validateCita($request, $content)
    {
        $rules = [];

        $validationRules = [
            'hora' => 'required',
            'fecha' => 'required',
            'modalidad_cita' => 'required',
            'tipo_cita' => 'required',
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
