<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'horario';
    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'descripcion'
    ];

    public function HorarioDetalles(){
        return $this->hasMany(HorarioDetalle::class);
    }
}
