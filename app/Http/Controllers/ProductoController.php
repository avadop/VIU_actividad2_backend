<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Recordatorio;
use App\Models\ResultResponse;
use Illuminate\Validation\Rule;


class ProductoController extends Controller
{
    /**
     * Devuelve todas las recordatorios disponibles.
     *
     * @return \Illuminate\Http\Response
     */

     public function getAll()
     {
        $producto = Producto::getAllProductos();
       
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($producto);
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
             $producto = Producto::getProductoById($id);
 
             $resultResponse->setData($producto);
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
     * Crea una nueva recordatorio validando que los campos necesarios están rellenados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function create(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse =  new ResultResponse();  

        $this->validateProducto($request, $requestContent);
        try {
            $newProducto = new Producto([
                'nombre_producto' => $requestContent['nombre_producto'],
                'marca' => $requestContent['marca'],
                'imagen' => $requestContent['imagen'],
                'descripcion' => $requestContent['descripcion'],
                'ficha_tecnica' => $requestContent['ficha_tecnica'],
                'precio' => $requestContent['precio'],
                'cantidad_disponible' => $requestContent['cantidad_disponible'],
                'tipo_producto' => $requestContent['tipo_producto'],

            ]);

            $newProducto->createProducto();

            $resultResponse->setData($newProducto);
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
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $this->validateProducto($request, $requestContent);

        $resultResponse =  new ResultResponse();       

        try {

            $producto = Producto::getProductoById($id);

            if($requestContent['nombre_producto']) {
                $producto->fecha_inicio = $requestContent['nombre_producto'];
            }

            if($requestContent['marca']) {
                $producto->fecha_inicio = $requestContent['marca'];
            }

            if($requestContent['imagen']) {
                $producto->fecha_inicio = $requestContent['imagen'];
            }

            if($requestContent['descripcion']) {
                $producto->fecha_inicio = $requestContent['descripcion'];
            }

            if( $requestContent['ficha_tecnica']) {
                $producto->fecha_inicio = $requestContent['ficha_tecnica'];
            }

            if( $requestContent['precio']) {
                $producto->fecha_inicio = $requestContent['precio'];
            }

            if($requestContent['cantidad_disponible']) {
                $producto->fecha_inicio = $requestContent['cantidad_disponible'];
            }

            if($requestContent['tipo_producto']) {
                $producto->fecha_inicio = $requestContent['tipo_producto'];
            }

            $producto->updateProducto();

            $resultResponse->setData($producto);
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
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
       $resultResponse =  new ResultResponse();

        try{
            $producto = Producto::getProductoById($id);
            $producto->deleteProducto();
            
            $resultResponse->setData($producto);
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
    public function getProductosNombre($name_) {
        $resultResponse =  new ResultResponse();

        try {
            $producto = Producto::findProductosByName($name_);

            $resultResponse->setData($producto);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);


        } catch(\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }
}
