<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

Product::whereNull('user_id')->update(['user_id' => 1]); // Usa el ID de un usuario existente

class ProductController extends Controller
{
    public function show($id)
    {   //muestra producto que se ha seleccionado para comprar
        $product = Product::with('images')->findOrFail($id);

        // Obtén otros productos, excluyendo el principal en este caso toma 48 prosuctos a parte
        $relatedProducts = Product::with('images')->where('id', '!=', $id)->take(48)->get();

        return view('Productpage', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function index()
    {
        $products = Product::with('images')->get();
        return view('Homepage', ['products' => $products]);
    }

    public function store(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('loggeo'); // Redirige a la página de inicio de sesión si no está autenticado
        }

        $validador = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'offer' => 'nullable|numeric', // Permite que la oferta sea nula
            'category' => 'required|string|max:255',
            'color' => 'nullable|string|max:255', // Permite que el color sea nulo
            'size' => 'nullable|string|max:255', // Permite que el tamaño sea nulo
            'model' => 'nullable|string|max:255', // Permite que el modelo sea nulo
            'version' => 'nullable|string|max:255', // Permite que la versión sea nula
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validador->errors()
            ]);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'offer' => $request->offer,
            'category'=>$request->category,
            'color'=>$request->color,
            'size'=>$request->size,
            'model'=>$request->model,
            'version'=>$request->version,
            'user_id' => Auth::id(), // Asegúrate de que el user_id se proporciona
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('product.show', $product->id);
    }


    //destruir producto
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $currentUserId = Auth::id();

        // Depuración
        if ($product->user_id !== $currentUserId) {
            return response()->json([
                'error' => 'No autorizado',
                'product_user_id' => $product->user_id,
                'current_user_id' => $currentUserId
            ], 403);
        }

        // Eliminar las imágenes asociadas al producto
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();
        return redirect()->route('misventas');
        //return response()->json(['message' => 'Producto eliminado con éxito']);
    }

    //editar producto
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('misventas')->with('error', 'No autorizado');
        }
        return view('edit', ['product' => $product]);
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Verificación de propiedad
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('misventas')->with('error', 'No autorizado');
        }

        $validador = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'offer' => 'numeric',
            'category' => 'required|string|max:255',
            'color' => 'string|max:255',
            'size' => 'string|max:255',
            'model' => 'string|max:255',
            'version' => 'string|max:255',
            'images' => 'array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validador->errors()
            ]);
        }

        $product->update($request->only(['name', 'description', 'price', 'offer', 'category', 'color', 'size', 'model', 'version']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('misventas')->with('success', 'Producto actualizado con éxito');
    }
}
