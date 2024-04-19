<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Importando Request de validaciones
use App\Http\Requests\SaveInfoRequest;

class HelloController extends Controller
{
    // Método que retorna un saludo
    public function helloWorld()
    {
        // Retornamos mensaje de respuesta
        return "¡Hola Mundo!"; // -> Response
    }

    /*
        Metodo para retornar un mensaje con
        nombre
    */
    public function message()
    {
        $info = array(
            'nombre' => "Victor",
            'apellido' => "López",
            'nacimiento' => "1999-09-20"
        );

        $message = "Hola! Me llamo " . $info['nombre'] . " " . $info['apellido'];

        // Respuesta en formato JSON
        return response()->json(array(
            'message' => $message,
            'data' => $info,
            'code' => 200, // Codigo de respuesta para mostrar en pantalla
        ), 200); // Codigo de respuesta para la petición
    }

    /* 
        http://localhost:8000/api/show-info?nombre=Victor

        $request -> Obtiene la información 
        de la solicitud
    */
    public function showInfo(Request $request)
    {
        $mensaje = "¡Hola!";
        $informacion = array();

        // Validamos que se envie el nombre de la persona
        // Validamos al mismo tiempo que tenga contenido o valor
        if ($request->has('nombre') && $request->nombre != NULL) {
            $nombre = $request->nombre; // Almacenamos el nombre

            $informacion['nombre'] = $nombre;

            $mensaje = $mensaje . " " . $nombre;
        }

        if ($request->has('apellido') && $request->apellido != NULL) {
            $apellido = $request->apellido; // Almacenamos el nombre

            $informacion['apellido'] = $apellido;

            $mensaje = $mensaje . " " . $apellido;
        }

        return response()->json(array(
            'message' => $mensaje,
            'data' => $informacion,
            'code' => 200,
        ), 200);
    }

    /*
        Primer metodo POST

        Los métodos POST siempre deben de usar el parametro
        $request (Ojito)

        En los métodos POST podemos enviar parametros tanto dinamico
        como fijos (Parametro si o si requerido)
    */
    public function saveInfo(SaveInfoRequest $request)
    {
        $request->validated();

        // Simulando el guardado de información

        // 1. Obtener los datos que se están enviando
        $data = array(
            'name' => $request->name, // Nombres
            'lastname' => $request->lastname, // Apellidos
            'bornDate' => $request->bornDate, // Fecha de nacimiento
            'dui' => $request->dui,
            'age' => $request->age, // Edad
        );

        /* 
            2 y 3. Se realizan en la linea de
            $request->validated();
        */

        // 4. Proceso de guardado...

        // 5.  Retorno de confirmación de guardado.
        return response()->json(array(
            'message' => "Información procesada y guardada con exito.",
            'data' => $data, // <- Información general o guardada
            'code' => 201,
        ), 201);
    }
}
