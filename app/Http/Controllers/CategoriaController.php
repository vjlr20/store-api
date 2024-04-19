<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Importamos el modelo
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Lista todos los elementos de la tabla
    public function index()
    {
        // SELECT id, nombre FROM categorias;
        $categorias = Categoria::select('id', 'nombre')->get();

        return response()->json(array(
            'message' => "Listado de categorias",
            'data' => $categorias,
            'code' => 200,
        ), 200);
    }

    // Muestra un solo elemento de la tabla
    public function show(Request $request)
    {
        $id = $request->id;

        // SELECT * FROM categorias WHERE id = 1;
        $categoria = Categoria::find($id);

        return response()->json(array(
            'message' => "Categoria encontrada",
            'data' => $categoria,
            'code' => 200,
        ), 200);
    }

    // Inserta un nuevo elemento a la tabla
    public function store()
    {
        // INSERT INTO categorias (nombre, descripcion) VALUES (?, ?);
        $data = array(
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        );

        $newCategoria = new Categoria($data);
        $newCategoria->save(); // Guardar

        return response()->json(array(
            'message' => "Nueva Categoria creada",
            'data' => $newCategoria,
            'code' => 201,
        ), 201);
    }
    
    // Actualiza un elemento especifico de la tabla
    public function update(Request $request)
    {
        $id = $request->id;

        // SELECT * FROM categorias WHERE id = 1;
        $categoria = Categoria::find($id);

        // UPDATE categoria SET nombre = ?, descripcion = ? WHERE id = ?
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;

        $categoria->save();

        return response()->json(array(
            'message' => "Categoria actualizada",
            'data' => $categoria,
            'code' => 200,
        ), 200);
    }

    // Elimina un elemento especifico de la tabla
    public function delete(Request $request)
    {
        $id = $request->id;

        // SELECT * FROM categorias WHERE id = 1;
        $categoria = Categoria::find($id);

        $categoria->delete();

        return response()->json(array(
            'message' => "Categoria eliminada",
            'data' => $categoria,
            'code' => 200,
        ), 200);
    }
}
