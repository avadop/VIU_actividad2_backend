<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\ResultResponse;

class MascotaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $mascotas = Mascota::getAllMascotas();
        foreach ($mascotas as $mascota) {
            $informes = json_decode($mascota->informes_de_mascota, true);
            $mascota->informes_de_mascota = $informes;
        }
       
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($mascotas);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
    
        return response($json)->header('Content-Type', 'application/json');
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $resultResponse =  new ResultResponse();

        try {
            $mascota = Mascota::getMascotaById($id);
            $informes = json_decode($mascota->informes_de_mascota, true);
            $mascota->informes_de_mascota = $informes;

            $resultResponse->setData($mascota);
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
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */
    public function getCliente($id)
    {
        $resultResponse =  new ResultResponse();

        try{
            $mascota = Mascota::getMascotaById($id);
            $mascotas = $mascota->cliente;
            foreach ($mascotas as $mascota) {
                $informes = json_decode($mascota->informes_de_mascota, true);
                $mascota->informes_de_mascota = $informes;
            }

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
        $requestContent = json_decode($request->getContent(), true);
        $this->validaMascota($request, $requestContent);

        $resultResponse =  new ResultResponse();    

        try {
            $nuevaMascota = new Mascota([
                'num_chip' => $requestContent['num_chip'],
                'nombre_mascota' => $requestContent['nombre_mascota'],
                'edad' => $requestContent['edad'],
                'sexo' => $requestContent['sexo'],
                'especie' => $requestContent['especie'],
                'vacunas' => $requestContent['vacunas'],
                'informes_de_mascota' => json_encode($requestContent['informes_de_mascota']),
                'historial_clinico' => $requestContent['historial_clinico'],
                'dni' => $requestContent['dni']
            ]);

            $nuevaMascota->implode('informes_de_mascota', ', ');
            $nuevaMascota->createMascota();

            $resultResponse->setData($nuevaMascota);
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
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $requestContent = json_decode($request->getContent(), true);
        $this->validaMascota($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {
            $mascota = Mascota::getMascotaById($id);

            if(isset($requestContent['nombre_mascota'])) {
                $mascota->nombre_mascota = $requestContent['nombre_mascota'];
            }

            if(isset($requestContent['edad'])){
                $mascota->edad = $requestContent['edad'];
            }

            if(isset($requestContent['sexo'])){
                $mascota->sexo = $requestContent['sexo'];
            }

            if(isset($requestContent['especie'])){
                $mascota->especie = $requestContent['especie'];
            }

            if(isset($requestContent['vacunas'])) {
                $mascota->vacunas = $requestContent['vacunas'];
            }

            if(isset($requestContent['informes_de_mascota'])) {
                $mascota->informes_de_mascota = $requestContent['informes_de_mascota'];
            }

            if(isset($requestContent['historial_clinico'])) {
                $mascota->historial_clinico = $requestContent['historial_clinico'];
            }

            if(isset($requestContent['dni'])) {
                $mascota->dni = $requestContent['dni'];
            }

            $mascota->updateMascota();

            $resultResponse->setData($mascota);
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
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $mascota = Mascota::getMascotaById($id);
            $mascota->deleteMascota();
            
            $resultResponse->setData($mascota);
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
     * Search mascotas by a given search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestData = $request->json()->all();
        $searchTerm = isset($requestData['search_term']) ? $requestData['search_term'] : '';
        $resultResponse = new ResultResponse();

        $mascotas = Mascota::searchMascotas($searchTerm);

        if ($mascotas->isEmpty()) {
            $resultResponse->setData("No existen mascotas para los criterios de búsqueda.");
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);            
        } else {
            $resultResponse->setData($mascotas);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type', 'application/json');
    }


    private function validaMascota($request, $content)
    {
        $rules = [];

        $validationRules = [
            'num_chip' => 'required',
            'nombre_mascota' => 'required',
            'edad' => 'required',
            'sexo' => 'required',
            'especie' => 'required',
            'vacunas' => 'required',
            'informes_de_mascota' => 'required',
            'historial_clinico' => 'required',
            'dni' => 'required'
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
