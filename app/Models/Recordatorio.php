<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recordatorio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'recordatorios';
    protected $primaryKey = 'id_recordatorio';

    protected $fillable = [
        'fecha_inicio',
        'periodicidad' ,
        'motivo',
        'metodo_envio',
        'num_chip',
        'id_clinica'
    ];


    public static function getAllRecordatorios() {
        return self::all();
    }

    public static function getRecordatorioById($id) {
        return self::findOrFail($id);
    }

    public function createRecordatorio()
    {
        return self::save();
    }

    public function updateRecordatorio()
    {
        return self::save();
    }

    public function deleteRecordatorio()
    {
        return self::delete();
    }

    public static function findRecordatoriosByNumChip($numChip){
        return self::where('num_chip', $numChip)->get();
    }

    public static function findRecordatoriosByIdClinica($idClinica){
        return self::where('id_clinica', $idClinica)->get();
    }
}
