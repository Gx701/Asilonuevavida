<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;
    protected $table = 'dia';
    protected $primaryKey = 'id_dia';

    protected $fillable = [
        'dia'
    ];

    public function HorarioDetalles(){
        return $this->hasMany(HorarioDetalle::class);
    }
}
