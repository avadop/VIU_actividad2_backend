<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\ResultResponse;



class ProductoController extends Controller
{
    /**
     * Devuelve todas las recordatorios disponibles.
     *
     * @return \Illuminate\Http\Response
     */

     public function getAll(Request $request)
     {
        $perPage = intval($request->input('per_page'));
        $productos = Producto::getAllProductos($perPage);
       
        $resultResponse =  new ResultResponse();
        $resultResponse->setData($productos);
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

        try {
            $this->validateProducto($request, $requestContent);

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
     * @param  \App\Models\Producto  $recordatorio
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $resultResponse =  new ResultResponse();    
        
        try {
            $this->validateProducto($request, $requestContent);

            try {

                $producto = Producto::getProductoById($id);

                if($requestContent['nombre_producto']) {
                    $producto->nombre_producto = $requestContent['nombre_producto'];
                }

                if($requestContent['marca']) {
                    $producto->marca = $requestContent['marca'];
                }

                if($requestContent['imagen']) {
                    $producto->imagen = $requestContent['imagen'];
                }

                if($requestContent['descripcion']) {
                    $producto->descripcion = $requestContent['descripcion'];
                }

                if($requestContent['ficha_tecnica']) {
                    $producto->ficha_tecnica = $requestContent['ficha_tecnica'];
                }

                if($requestContent['precio']) {
                    $producto->precio = $requestContent['precio'];
                }

                if($requestContent['cantidad_disponible']) {
                    $producto->cantidad_disponible = $requestContent['cantidad_disponible'];
                }

                if($requestContent['tipo_producto']) {
                    $producto->tipo_producto = $requestContent['tipo_producto'];
                }

                $producto->updateProducto();

                $resultResponse->setData($producto);
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

    public function patch(Request $request, $id)
    {
        $requestContent = json_decode($request->getContent(), true);

        $resultResponse =  new ResultResponse();       

        try {

            $producto = Producto::getProductoById($id);

            if(isset($requestContent['nombre_producto'])) {
                $producto->nombre_producto = $requestContent['nombre_producto'];
            }

            if(isset($requestContent['marca'])) {
                $producto->marca = $requestContent['marca'];
            }

            if(isset($requestContent['imagen'])) {
                $producto->imagen = $requestContent['imagen'];
            }

            if(isset($requestContent['descripcion'])) {
                $producto->descripcion = $requestContent['descripcion'];
            }

            if(isset($requestContent['ficha_tecnica'])) {
                $producto->ficha_tecnica = $requestContent['ficha_tecnica'];
            }

            if(isset($requestContent['precio'])) {
                $producto->precio = $requestContent['precio'];
            }

            if(isset($requestContent['cantidad_disponible'])) {
                $producto->cantidad_disponible = $requestContent['cantidad_disponible'];
            }

            if(isset($requestContent['tipo_producto'])) {
                $producto->tipo_producto = $requestContent['tipo_producto'];
            }

            $producto->updateProducto();

            $resultResponse->setData($producto);
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
     * @param  \App\Models\Producto  $recordatorio
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
            $resultResponse->setData($e->getMessage());
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
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);    
        return response($json)->header('Content-Type', 'application/json');
    }

       /**
     * Search productos by a given search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestData = $request->json()->all();
        $searchTerm = isset($requestData['search_term']) ? $requestData['search_term'] : '';
        $resultResponse = new ResultResponse();

        $productos = Producto::searchProductos($searchTerm);

        if ($productos->isEmpty()) {
            $resultResponse->setData("No existen productos para los criterios de búsqueda.");
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);            
        } else {
            $resultResponse->setData($productos);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        }       

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type', 'application/json');
    }

    private function validateProducto($request, $content)
    {
        $rules = [];

        $validationRules = [
            'nombre_producto' => 'required',
            'marca' => 'required',
            'imagen' => 'required',
            'descripcion' => 'required',
            'ficha_tecnica' => 'required',
            'precio' => 'required',
            'cantidad_disponible' => 'required',
            'tipo_producto' => 'required'
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
