<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

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

    public static function createCliente($datos)
    {
        return self::create($datos);
    }

    public function updateCliente($datos)
    {
        return $this->update($datos);
    }

    public function deleteCliente()
    {
        return $this->delete();
    }

    public static function getAllClientes()
    {
        return self::all();
    }

}
