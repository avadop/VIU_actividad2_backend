<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'citas';
    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'hora',
        'fecha',
        'modalidad_cita',
        'tipo_cita',
        'id_clinica',
        'num_chip'
    ];

    public static function getAllCitas() {
        return self::all();
    }

    public static function getCitaById($id) {
        return self::findOrFail($id);
    }

    public function createCita()
    {
        return self::save();
    }

    public function updateCita()
    {
        return self::save();
    }

    public function deleteCita()
    {
        return self::delete();
    }

    public static function findCitasByNumChip($numChip){
        return self::where('num_chip', $numChip)->get();
    }

    public static function findCitaByIdClinica($idClinica){
        return self::where('id_clinica', $idClinica)->get();
    }

    public static function findCitaByDateAndTime($hora, $fecha){
        return self::where('hora', $hora)->where('fecha', $fecha)->get();
    }

    public static function searchCitas($aBuscar)
    {
       return self::query()
            ->where('hora', 'like', "%$aBuscar%")
            ->orWhere('fecha', 'like', "%$aBuscar%")
            ->orWhere('modalidad_cita', 'like', "%$aBuscar%")
            ->orWhere('tipo_cita', 'like', "%$aBuscar%")
            ->orWhere('id_clinica', 'like', "%$aBuscar%")
            ->orWhere('num_chip', 'like', "%$aBuscar%")
            ->get();
    }
}
