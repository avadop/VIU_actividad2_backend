<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'nombre_producto',
        'marca' ,
        'imagen',
        'descripcion',
        'ficha_tecnica',
        'precio',
        'cantidad_disponible',
        'tipo_producto'
    ];

    
    public static function getAllProductos($perPage) {
        return self::paginate($perPage);
    }

    public static function getProductoById($id) {
        return self::findOrFail($id);
    }

    public function createProducto()
    {
        return self::save();
    }

    public function updateProducto()
    {
        return self::save();
    }

    public function deleteProducto()
    {
        return self::delete();
    }

    public static function findProductosByName($name_){
        return self::where('nombre_producto', $name_)->get();
    }

    public static function searchProductos($aBuscar)
    {
       return self::query()
            ->where('nombre_producto', 'like', "%$aBuscar%")
            ->orWhere('marca', 'like', "%$aBuscar%")
            ->orWhere('imagen', 'like', "%$aBuscar%")
            ->orWhere('descripcion', 'like', "%$aBuscar%")
            ->orWhere('ficha_tecnica', 'like', "%$aBuscar%")
            ->orWhere('precio', 'like', "%$aBuscar%")
            ->orWhere('cantidad_disponible', 'like', "%$aBuscar%")
            ->orWhere('tipo_producto', 'like', "%$aBuscar%")
            ->get();
    }
}
