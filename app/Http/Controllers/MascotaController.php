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

            $resultResponse->setData($mascota);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch(\Exception $e) {
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
                'informes_de_mascota' => $requestContent['informes_de_mascota'],
                'historial_clinico' => $requestContent['historial_clinico'],
                'dni' => $requestContent['dni']
            ]);

            $nuevaMascota->crearMascota();

            $resultResponse->setData($nuevaMascota);
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
            if( $requestContent['nombre_mascota']) {
                $mascota->nombre_mascota = $requestContent['nombre_mascota'];
            }

            if($requestContent['edad']){
                $mascota->edad = $requestContent['edad'];
            }

            if($requestContent['sexo']){
                $mascota->sexo = $requestContent['sexo'];
            }

            if($requestContent['especie']){
                $mascota->especie = $requestContent['especie'];
            }

            if( $requestContent['vacunas']) {
                $mascota->vacunas = $requestContent['vacunas'];
            }

            if( $requestContent['informes_de_mascota']) {
                $mascota->informes_de_mascota = $requestContent['informes_de_mascota'];
            }

            if( $requestContent['historial_clinico']) {
                $mascota->historial_clinico = $requestContent['historial_clinico'];
            }

            if( $requestContent['dni']) {
                $mascota->dni = $requestContent['dni'];
            }

            $mascota->actualizarMascota();

            $resultResponse->setData($mascota);
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
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

    private function validaMascota($request, $content)
    {
        $data = $request->all();
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
