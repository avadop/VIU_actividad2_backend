<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dni',
        'correo_electronico',
        'direccion',
        'nombre',
        'apellidos',
        'contrasenya',
        'telefono',
    ];

    public static function getAllClientes()
    {
        return self::all();
    }

    public static function getClienteById($id)
    {
        return self::findOrFail($id);
    }

    public function createCliente()
    {
        return self::save();
    }

    public function updateCliente()
    {
        return self::save();
    }

    public function deleteCliente()
    {
        return self::delete();
    }  

    public function mascotas()
    {
        return self::hasMany(Mascota::class, 'dni', 'dni');
    }

    public function checkClientPassword($dni, $contrasenya)
    {
        return self::where([['dni','=',$dni],['contrasenya','=',$contrasenya]])->firstOrFail();
    }

    public static function searchClientes($aBuscar)
    {
       return self::query()
            ->where('dni', 'like', "%$aBuscar%")
            ->orWhere('correo_electronico', 'like', "%$aBuscar%")
            ->orWhere('direccion', 'like', "%$aBuscar%")
            ->orWhere('nombre', 'like', "%$aBuscar%")
            ->orWhere('apellidos', 'like', "%$aBuscar%")
            ->orWhere('contrasenya', 'like', "%$aBuscar%")
            ->orWhere('telefono', 'like', "%$aBuscar%")
            ->get();
    }
}
