<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    /**
     * Función para obtener y listar recursos
     */
    public function index()
    {
        $assignments = Assignment::all();
        return response()->json($assignments);
    }

    /**
     * Función para crear un nuevo recurso en la base de datos
     */
    public function store(Request $request)
    {
        $assignment = new Assignment();
        $assignment->marca = $request->input('marca');
        $assignment->modelo = $request->input('modelo');
        $assignment->caracteristicas = $request->input('caracteristicas');
        $assignment->estado = 'En Resguardo'; // Estado por defecto al asignar un assignment
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
    public function update(Request $request, Assignment $assignment)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'assignment no encontrado'], 404);
        }

        $assignment->marca = $request->input('marca');
        $assignment->modelo = $request->input('modelo');
        $assignment->caracteristicas = $request->input('caracteristicas');
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
}
