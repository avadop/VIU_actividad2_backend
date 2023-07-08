<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;
    
    protected $table = 'mascotas';
    protected $primaryKey = 'num_chip';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'num_chip',
        'nombre_mascota',
        'edad',
        'sexo',
        'especie',
        'vacunas',
        'informes_de_mascota',
        'historial_clinico',
        'dni',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'dni', 'dni');
    }

    public function crearMascota()
    {
        return self::save();
    }

    public function actualizarMascota()
    {
        return self::save();
    }


    public function deleteMascota()
    {
        return self::delete();
    }

    public static function getAllMascotas()
    {
        return self::all();
    }

    public static function getMascotaById($id)
    {
        return self::findOrFail($id);
    }
}
