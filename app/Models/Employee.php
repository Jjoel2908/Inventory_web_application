<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    // Escribimos el nombre de nuestra tabla en la base de datos
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'departamento',
    ];
}
