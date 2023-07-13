<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

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

}
