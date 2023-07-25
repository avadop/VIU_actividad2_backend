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

    
    public static function getAllProductos() {
        return self::all();
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
}
