<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    /**
     * Función para obtener y listar recursos
     */
    public function index()
    {
        return Employee::orderBy('id', 'desc')->get();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Función para crear un nuevo recurso en la base de datos
     */
    public function store(Request $request)
    {
        $empleado = new Employee();
        $empleado->nombre = $request->input('nombre');
        $empleado->departamento = $request->input('departamento');
        $empleado->save();

        return response()->json($empleado, 201);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Función para mostrar los registros
     */
    public function show($id)
    {
        $empleado = Employee::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json($empleado);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Función para actualizar
     */
    public function update(Request $request, $id)
    {
        $empleado = Employee::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->nombre = $request->input('nombre');
        $empleado->departamento = $request->input('departamento');
        $empleado->save();

        return response()->json($empleado);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Función para eliminar
     */
    public function destroy($id)
    {
        $empleado = Employee::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado']);
    }
}







