<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Función para obtener y listar recursos
     */
    public function index()
    {
        return Equipo::orderBy('id', 'desc')->get();
    }

    /**
     * Función para crear un nuevo recurso en la base de datos
     */
    public function store(Request $request)
    {
        $equipo = new Equipo();
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->caracteristicas = $request->input('caracteristicas');
        $equipo->estado = $request->input('estado');
        $equipo->save();

        return response()->json($equipo, 201);
    }

    /**
     * Función para mostrar los registros
     */
    public function show(Equipo $equipo)
    {
        return $equipo;
    }

    /**
    * Función para actualizar
    */
    public function update(Request $request, Equipo $equipo, $id)
    {
        $equipo = Equipo::find($id);
        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->caracteristicas = $request->input('caracteristicas');
        $equipo->estado = $request->input('estado');
        $equipo->save();

        return response()->json($equipo);
    }


    /**
     * Función para eliminar
     */
    public function destroy($id)
    {
        $equipo = Equipo::find($id);
        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        $equipo->delete();

        return response()->json(['message' => 'Equipo eliminado']);
    }
}
