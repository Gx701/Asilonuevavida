<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionHabitacion extends Model
{
    use HasFactory;
    protected $table = 'ubi_habitacion';
    protected $primaryKey = 'id_ubicacion';

    protected $fillable = [
        'ubicacion'
    ];
}
