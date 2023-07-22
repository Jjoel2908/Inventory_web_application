<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    // Escribimos el nombre de nuestra tabla en la base de datos
    public $timestamps = false;
    protected $table = 'equipos';
    protected $fillable = [
        'marca',
        'modelo',
        'caracteristicas',
        'estado',
    ];
}
