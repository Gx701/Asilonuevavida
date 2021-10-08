<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;
    protected $table = 'religion';
    protected $primaryKey = 'id_religion';

    protected $fillable = [
        'religion',
    ];
}
