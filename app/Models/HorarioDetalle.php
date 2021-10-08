<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_horario',
        'id_turno',
        'id_dia'
    ];
    
    public function horario()
    {
    	$this->belongsTo(Horario::class);
    }

    public function turno()
    {
    	$this->belongsTo(Turno::class);
    }
    public function dia()
    {
    	$this->belongsTo(Dia::class);
    }
}
