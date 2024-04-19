<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::get();

        if (count($customers) < 1) {
            return response()->json(array(
                'message' => "No se encontraron productos.",
                'data' => $products,
                'code' => 404,
            ), 404);
        }

        return response()->json(array(
            'message' => "Listado de productos.",
            'data' => $products,
            'code' => 200,
        ), 200);
    }    

    public function show(Request $request, int $id)
    {
        // $product = Product::find($id);
        // $product = Product::where('id', $id)->get();
        $product = Product::where('id', '=', $id)->get();

        if ($product == NULL) {
            return response()->json(array(
                'message' => "Producto no encontrado.",
                'data' => $product,
                'code' => 404,
            ), 404);
        }

        return response()->json(array(
            'message' => "Producto encontrado.",
            'data' => $product,
            'code' => 200,
        ), 200);
    }

    public function store(Request $request)
    {
        // $request->validated();

        $data = array(
            'product_name' => $request->product_name,
            'description' => $request->description,
            'unit_price' => $request->unit_price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
        );

        $newProduct = new Product($data);

        
        if ($newProduct->save() == false) {
            return response()->json(array(
                'message' => "Información no procesada.",
                'data' => $data,
                'code' => 422,
            ), 422);
        }

        return response()->json(array(
            'message' => "Producto guardado con exito.",
            'data' => $newProduct,
            'code' => 201,
        ), 201);
    }

    public function update(Request $request, int $id)
    {
        // $request->validated();

        $product = Product::where('id', '=', $id)->get();

        if ($product == NULL) {
            return response()->json(array(
                'message' => "Producto no encontrado.",
                'data' => $product,
                'code' => 404,
            ), 404);
        }

        $product->product_name = $requests->product_name;
        $product->description = $requests->description;
        $product->unit_price = $requests->unit_price;
        $product->sale_price = $requests->sale_price;
        $product->stock = $requests->stock;

        if ($product->save() == false) {
            return response()->json(array(
                'message' => "Información no actualizada.",
                'data' => $product,
                'code' => 422,
            ), 422);
        }

        return response()->json(array(
            'message' => "Producto actualizado con exito.",
            'data' => $product,
            'code' => 200,
        ), 200);
    }

    public function destroy(Request $request, int $id)
    {
        $product = Product::where('id', '=', $id)->get();

        if ($product == NULL) {
            return response()->json(array(
                'message' => "Producto no encontrado.",
                'data' => $product,
                'code' => 404,
            ), 404);
        }

        if ($product->delete() == false) {
            return response()->json(array(
                'message' => "Error al borrar producto.",
                'data' => $product,
                'code' => 400,
            ), 400);
        }

        return response()->json(array(
            'message' => "Producto borrado con exito.",
            'data' => $product,
            'code' => 200,
        ), 200);
    }

    public function restore(Request $request, int $id)
    {
        $product = Product::withTrashed()
                        ->where('id', '=', $id)
                        ->get();

        if ($product == NULL) {
            return response()->json(array(
                'message' => "Producto no encontrado.",
                'data' => $product,
                'code' => 404,
            ), 404);
        }

        if ($product->restore() == false) {
            return response()->json(array(
                'message' => "Error al restaurar producto.",
                'data' => $product,
                'code' => 400,
            ), 400);
        }

        return response()->json(array(
            'message' => "Producto restaurado con exito.",
            'data' => $product,
            'code' => 200,
        ), 200);
    }
}
