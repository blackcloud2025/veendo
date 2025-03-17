<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('loggeo'); // Redirige a la página de inicio de sesión si no está autenticado
        }


        $validador = Validator::make($request->all(),[
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images' => 'required|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'banner_type' => 'required|in:horizontal,vertical_left,vertical_right'
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validador->errors()
            ]);
        }


        $paths = [];
        foreach ($request->file('images') as $image) {
            $paths[] = $image->store('ads_images', 'public');
        }

        $ad = Ad::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $paths[0], // Asumiendo que quieres usar la tercera imagen como principal
            'banner_type' => $request->banner_type,
            'user_id' => Auth::id(), // Asegúrate de que el user_id se proporciona
        ]);


        return redirect()->back()->with('success', 'Publicidad subida exitosamente');
    }
}