<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

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

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'dni', 'dni');
    }

    public function crearCliente()
    {
        return self::save();
    }

    public function actualizarCliente()
    {
        return self::save();
    }

    public function deleteCliente()
    {
        return self::delete();
    }

    public static function getAllClientes()
    {
        return self::all();
    }

    public static function getClienteById($id)
    {
        return self::findOrFail($id);
    }

    public function checkClientPassword($dni, $contrasenya)
    {
        return self::where('dni', $dni)->where('contrasenya',$contrasenya) -> get();
    }

}
