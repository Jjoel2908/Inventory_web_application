<?php

namespace App\Http\Controllers;


use App\Models\Assignment;
use App\Models\Equipo;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssignmentController extends Controller
{

    /**
     * Función para obtener y listar recursos
     */
    public function index()
    {
        $assignment = Assignment::with('equipo', 'empleado')->get();
        return response()->json($assignment);
    }

    /**
     * Función para crear un nuevo recurso en la base de datos
     */
    public function store(Request $request)
    {
        $assignment = new Assignment();
        $assignment->equipo_id = $request->input('equipo_id');
        $assignment->usuario_id = $request->input('usuario_id');
        $assignment->fecha_asignacion = $request->input('fecha_asignacion');
        $assignment->save();

        return response()->json($assignment, 201);
    }

    /**
     * Función para mostrar los registros
     */
    public function show($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'asignacion no encontrado'], 404);
        }

        return response()->json($assignment);
    }

    /**
     * Función para actualizar
     */

    public function update(Request $request, Assignment $assignment, $id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
        return response()->json(['message' => 'assignment no encontrado'], 404);
        }

        $assignment->equipo_id = $request->input('equipo_id');
        $assignment->usuario_id = $request->input('usuario_id');

        // Obtén la fecha y hora desde el formulario o cualquier otra fuente
        $fechaAsignacion = $request->input('fecha_asignacion');

        // Formatea la fecha y hora utilizando Carbon
        $fechaFormateada = Carbon::parse($fechaAsignacion)->format('Y-m-d H:i:s');

        // Asigna la fecha y hora formateada al modelo Assignment
        $assignment->fecha_asignacion = $fechaFormateada;

        $assignment->save();

        return response()->json($assignment);
    }



    /**
     * Función para eliminar
     */
    public function destroy($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'assignment no encontrado'], 404);
        }

        $assignment->delete();

        return response()->json(['message' => 'assignment eliminado']);
    }

    //Método para poder obtener todos la información de equipos
    public function getEquipos()
    {
        $equipos = Equipo::all();
        return response()->json($equipos);
    }
    //Método para poder obtener todos la información de empleados
    public function getEmpleados()
    {
        $empleados = Employee::all();
        return response()->json($empleados);
    }
}
