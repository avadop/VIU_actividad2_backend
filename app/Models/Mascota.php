<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mascota extends Model
{
    use HasFactory;
    use SoftDeletes;
    
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

    public static function getAllMascotas()
    {
        return self::all();
    }

    public static function getMascotaById($id)
    {
        return self::findOrFail($id);
    }

    public function createMascota()
    {
        return self::save();
    }

    public function updateMascota()
    {
        return self::save();
    }

    public function deleteMascota()
    {
        return self::delete();
    }

    public function cliente()
    {
        return self::belongsTo(Cliente::class, 'dni', 'dni');
    }
}
