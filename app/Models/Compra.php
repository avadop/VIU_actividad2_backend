<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'compras';
    protected $primaryKey = ['dni', 'id_producto'];
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'fecha_compra',
        'id_producto',
        'dni',
    ];

    public static function getAllCompras()
    {
        return self::all();
    }

    public static function getCompraById($id_producto, $dni) 
    {
        return self::where('id_producto', $id_producto)
                ->where('dni', $dni)
                ->firstOrFail();
    }

    public function createCompra()
    {
        return self::save();
    }

    public function updateCompra($id_producto, $dni, $requestContent)
    {
        return self::where('id_producto', $id_producto)
            ->where('dni', $dni)
            ->update($requestContent);
    }


    public function deleteCompra($id_producto, $dni)
    {
        return self::where('id_producto', $id_producto)
            ->where('dni', $dni)
            ->delete();
    }
    
    public static function findComprasByDNI($dni)
    {
        return self::where('dni', $dni)->get();
    }
}
