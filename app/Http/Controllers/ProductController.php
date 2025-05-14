<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $auth;

    public function __construct(AuthService $auth)
    {

        $this->auth = $auth;
    }

    public function index(Request $request)
    {
        $token = $request->bearerToken();

        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'no autorizado'
            ], 401);
        }

        $products = Product::all();
        return response()->json([

            'productos' => $products
        ], 200);
    }

    public function store(ProductRequest $request)
    {


        $token = $request->bearerToken();

        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'sin autorizacion'
            ], 401);
        }

        if ($user['rol'] !== 'Administrador') {
            return response()->json([
                'message' => 'Solo el administrador puede agregar productos'
            ], 401);
        }

        $product = Product::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'talla' => $request->talla,
            'stock' => $request->stock,
            'precio' => $request->precio,
            'categoria' => $request->categoria,
            'año' => $request->año
        ]);


        return response()->json([
            'message' => 'Producto agregado correctamente',
            'producto' => $product
        ], 201);
    }


    public function show(Request $request, string $id)
    {


        $token = $request->bearerToken();

        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'producto no encontrado'
            ], 404);
        }
        return response()->json($product, 200);
    }

    public function update(ProductRequest $request, string $id)
    {

        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        if ($user['rol'] !== 'Administrador') {
            return response()->json([
                'message' => 'solo los administradores pueden editar productos'
            ], 401);
        }


        $product = Product::find($id);

        $product->nombre = $request->nombre;
        $product->descripcion = $request->descripcion;
        $product->talla = $request->talla;
        $product->stock = $request->stock;
        $product->precio = $request->precio;
        $product->categoria = $request->categoria;
        $product->año = $request->año;
        $product->save();


        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'producto' => $product
        ], 200);
    }

    public function updateStock(Request $request, string $id)
    {


        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'producto no encontrado'
            ], 404);
        }

        $product->stock = $request->stock;
        $product->save();

        return response()->json([
            'message' => 'Stock actualizado correctamente',
            'producto' => $product
        ], 200);
    }


    public function destroy(Request $request, string $id)
    {
        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        if ($user['rol'] != 'Administrador') {
            return response()->json([
                'message' => 'Solos los adminstradores pueden eliminar un producto'

            ]);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();
        return response()->json([
            'message' => 'Producto eliminado correctamente'

        ], 200);
    }


    public function restoreStock(Request $request, $id)
    {
        $producto = Product::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->stock += $request->cantidad;
        $producto->save();

        return response()->json(['message' => 'Stock restaurado correctamente']);
    }
}
