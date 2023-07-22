<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    // Escribimos el nombre de nuestra tabla en la base de datos
    protected $table = 'asignaciones';
}
