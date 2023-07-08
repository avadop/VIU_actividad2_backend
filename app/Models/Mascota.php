<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;
    
    protected $table = 'mascota';
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
}
