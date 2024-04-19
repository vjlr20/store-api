<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Importando modelos
use App\Models\Customer;

// Importando Validaciones (Requests)
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    // 1. Lista todos los clientes (GET)
    public function index()
    {
        // SELECT * FROM customers;
        $customers = Customer::all();

        // Validando si hay al menos 1 cliente
        if (count($customers) < 1) {
            return response()->json(array(
                'message' => "No se encontraron clientes.",
                'data' => $customers,
                'code' => 404,
            ), 404);
        }

        return response()->json(array(
            'message' => "Listado general de clientes.",
            'data' => $customers,
            'code' => 200,
        ), 200);
    }

    // 2. Obtener un cliente en especifico (GET)
    public function show(Request $request, string $dui)
    {
        // SELECT * FROM customers WHERE dui = ? LIMIT 1;
        $customer = Customer::where('dui', '=', $dui)
                            ->first();
        
        if ($customer == NULL) {
            return response()->json(array(
                'message' => "Cliente no encontrado.",
                'data' => $customer,
                'code' => 404,
            ), 404);
        }

        return response()->json(array(
            'message' => "Cliente encontrado.",
            'data' => $customer,
            'code' => 200,
        ), 200);
    }

    // 3. Registrar un nuevo cliente (POST)
    public function store(Request $request)
    {
        $data = array(
            'names' => $request->names, // Nombres
            'lastnames' => $request->lastnames, // Apellidos
            'born_date' => $request->born_date, // Fecha de nacimiento
            'dui' => $request->dui,
            'address' => $request->address, // Dirección
        );

        // INSERT INTO customer () VALUES ();
        $newCustomer = new Customer($data);

        if ($newCustomer->save() == false) {
            return response()->json(array(
                'message' => "Información no procesada.",
                'data' => $data,
                'code' => 422,
            ), 422);
        }

        return response()->json(array(
            'message' => "Cliente guardado con exito.",
            'data' => $newCustomer,
            'code' => 201,
        ), 201);
    }

    // 4. Actualizar un cliente en especifico (PUT)
    public function update(UpdateCustomerRequest $request, string $dui)
    {
        // 1. Validar los datos
        $request->validated();

        // 2. Verificar la existencia del registro a actualizar
        $customer = Customer::where('dui', '=', $dui)
                            ->first();
        
        if ($customer == NULL) {
            return response()->json(array(
                'message' => "Cliente no encontrado.",
                'data' => $customer,
                'code' => 404,
            ), 404);
        }

        // 3. Sobrescribimos la información existente

        // UPDATE customer SET names = ? WHERE dui = ?
        $customer->names = $request->names;
        $customer->lastnames = $request->lastnames;
        $customer->born_date = $request->born_date;
        $customer->dui = $request->dui;
        $customer->address = $request->address;

        if ($customer->save() == false) {
            return response()->json(array(
                'message' => "Información no actualizada.",
                'data' => $customer,
                'code' => 422,
            ), 422);
        }

        return response()->json(array(
            'message' => "Cliente actualizado con exito.",
            'data' => $customer,
            'code' => 200,
        ), 200);
    }

    // 5. Borrar un cliente en especifico (DELETE)
    public function destroy(Request $request, string $dui)
    {
        $customer = Customer::where('dui', '=', $dui)
                            ->first();
        
        if ($customer == NULL) {
            return response()->json(array(
                'message' => "Cliente no encontrado.",
                'data' => $customer,
                'code' => 404,
            ), 404);
        }

        if ($customer->delete() == false) {
            return response()->json(array(
                'message' => "Error al borrar cliente.",
                'data' => $customer,
                'code' => 400,
            ), 400);
        }

        return response()->json(array(
            'message' => "Cliente borrado con exito.",
            'data' => $customer,
            'code' => 200,
        ), 200);
    }
}
