<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alerta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'alertas';
    protected $primaryKey = 'id_alerta';
    protected $keyType = 'integer';

    protected $fillable = [
        'mensaje',
        'stock_restante',
        'fecha_alerta',
        'id_producto'
    ];

    public static function getAllAlertas() 
    {
        return self::all();
    }

    public static function getAlertaById($id) {
        return self::findOrFail($id);
    }

    public function createAlerta()
    {
        return self::save();
    }

    public function updateAlerta()
    {
        return self::save();
    }

    public function deleteAlerta()
    {
        return self::delete();
    }

    public static function findAlertasByidProducto($id_producto){
        return self::where('id_producto', $id_producto)->get();
    }

    public static function searchAlertas($aBuscar)
    {
       return self::query()
            ->where('mensaje', 'like', "%$aBuscar%")
            ->orWhere('stock_restante', 'like', "%$aBuscar%")
            ->orWhere('fecha_alerta', 'like', "%$aBuscar%")
            ->orWhere('id_producto', 'like', "%$aBuscar%")
            ->get();
    }

}
