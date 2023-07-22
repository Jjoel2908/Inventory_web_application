<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Función para obtener y listar recursos
     */
    public function index()
    {
        return Equipment::orderBy('id', 'desc')->get();
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
    public function show(Equipment $equipment)
    {
        return $equipment;
    }

    /**
    * Función para actualizar
    */
    public function update(Request $request, Equipment $equipment)
    {
        $equipment = Equipo::find($id);
        if (!$equipment) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        $equipment->marca = $request->input('marca');
        $equipment->modelo = $request->input('modelo');
        $equipment->caracteristicas = $request->input('caracteristicas');
        $equipment->save();

        return response()->json($$equipment);
    }


    /**
     * Función para eliminar
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
    }
}
