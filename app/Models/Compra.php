<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $primaryKey = 'id_producto';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'id_producto',
        'dni',
        'fecha_compra',
    ];

    public static function getAllCompras()
    {
        return self::all();
    }

    public function createCompra()
    {
        return self::save();
    }

    public function updateCompra()
    {
        return self::save();
    }

    public function deleteCompra()
    {
        return self::delete();
    }
    
    public static function findComprasByDNI($dni){
        return self::where('dni', $dni)->get();
    }
}
