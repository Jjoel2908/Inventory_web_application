<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    // Escribimos el nombre de nuestra tabla en la base de datos
    public $timestamps = false;
    protected $table = 'asignaciones';
    protected $fillable = [
        'equipo_id',
        'usuario_id',
        'fecha_asignacion',
    ];

    //Funciones para trabajar con los datos que tienen las tablas equipo y empleados

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'usuario_id');
    }
}
