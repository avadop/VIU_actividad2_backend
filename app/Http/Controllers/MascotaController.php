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
    public function index()
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mascotas.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validaMascota($request);

        $resultResponse =  new ResultResponse();    

        try {
            $nuevaMascota = new Mascota([
                'num_chip' => $request->get('num_chip'),
                'nombre_mascota' => $request->get('nombre_mascota'),
                'edad' => $request->get('edad'),
                'sexo' => $request->get('sexo'),
                'especie' => $request->get('especie'),
                'vacunas' => $request->get('vacunas'),
                'informes_de_mascota' => $request->get('informes_de_mascota'),
                'historial_clinico' => $request->get('historial_clinico'),
                'dni' => $request->get('dni')
            ]);

            // Cliente::createCliente($nuevoCliente);
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
     * Display the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        return view('mascotas.edit', compact('mascota'));
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
        $this->validaMascota($request);

        $resultResponse =  new ResultResponse();       

        try {

            $mascota = Mascota::getMascotaById($id);
            if( $request->get('nombre_mascota')) {
                $mascota->nombre_mascota = $request->get('nombre_mascota');
            }

            if($request->get('edad')){
                $mascota->edad = $request->get('edad');
            }

            if($request->get('sexo')){
                $mascota->sexo = $request->get('sexo');
            }

            if($request->get('especie')){
                $mascota->especie = $request->get('especie');
            }

            if( $request->get('vacunas')) {
                $mascota->vacunas = $request->get('vacunas');
            }

            if( $request->get('informes_de_mascota')) {
                $mascota->informes_de_mascota = $request->get('informes_de_mascota');
            }

            if( $request->get('historial_clinico')) {
                $mascota->historial_clinico = $request->get('historial_clinico');
            }

            if( $request->get('dni')) {
                $mascota->dni = $request->get('dni');
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
     * Put the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, string $id)
    {
        $this->validaMascota($request);
        
        $resultResponse =  new ResultResponse();

        try {
            $mascota = Mascota::getMascotaById($id);

            if( $request->get('nombre_mascota')) {
                $mascota->nombre_mascota = $request->get('nombre_mascota');
            }

            if($request->get('edad')){
                $mascota->edad = $request->get('edad');
            }

            if($request->get('sexo')){
                $mascota->sexo = $request->get('sexo');
            }

            if($request->get('especie')){
                $mascota->especie = $request->get('especie');
            }

            if( $request->get('vacunas')) {
                $mascota->vacunas = $request->get('vacunas');
            }

            if( $request->get('informes_de_mascota')) {
                $mascota->informes_de_mascota = $request->get('informes_de_mascota');
            }

            if( $request->get('historial_clinico')) {
                $mascota->historial_clinico = $request->get('historial_clinico');
            }

            if( $request->get('dni')) {
                $mascota->dni = $request->get('dni');
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
    public function destroy(string $id)
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

    private function validaMascota($request)
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
            if (isset($data[$field])) {
                $rules[$field] = $validationRule;
            }
        }

        $validatedData = $request->validate($rules);

        return $validatedData;
    }

}
