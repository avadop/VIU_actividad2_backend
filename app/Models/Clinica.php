<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinica extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clinicas';
    protected $primaryKey = 'id_clinica';

    public $incrementing = false;

    protected $fillable = [
        'id_clinica',
        'nombre'
    ];

    public static function getAllClinicas() {
        return self::all();
    }

    public static function getClinicaById($id) {
        return self::findOrFail($id);
    }

    public function createClinica()
    {
        return self::save();
    }

    public function updateClinica()
    {
        return self::save();
    }

    public function deleteClinica()
    {
        return self::delete();
    }

}
