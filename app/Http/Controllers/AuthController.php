<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function dashboard()
    {
        $users = User::with('userProducts')->get();
        return view('dashboard', compact('users'));
    }




    public function login(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validador->errors()
            ]);
        }

        $email = $request->email;
        $pass = $request->password;
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($pass, $user->password)) {
            $request->session()->regenerate();
            Auth::login($user);
            return redirect()->route('Home');
        }

        return redirect()
            ->back()
            ->with('error', 'Error al ingrear usuario o password.')
            ->withInput();
    }

    public function registro(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/'
            ]
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validador->errors()
            ]);
        }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $request->session()->regenerate();
            Auth::login($user);

            return redirect()->route('Home');
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'errors' => $th->getMessage(),
                'message' => 'Error al registrar en la DB'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('Home');
    }


    // Mostrar usuario específico

    public function show()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado 
        return view('profilepage', compact('user'));
    }



    //Mostrar formulario de edición

    public function edit(User $user)
    {
        return view('profilepage', compact('user'));
    }

    // actualizar usuario
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/'
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el usuario: ')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];


            // Siempre actualizamos estos campos
            $user->name = $request->name;
            $user->email = $request->email;



            // Solo actualizamos la contraseña si se proporcionó una nueva
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            return redirect()
                ->back()
                ->with('success', 'Usuario actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }


    //Eliminar usuario
    public function destroy(User $user, Request $request)
    {
        try {
            // Si el usuario se está eliminando a sí mismo
            $isSelfDelete = $user->id === auth()->id();

            // Obtener todos los productos del usuario
            $products = Product::where('user_id', $user->id)->get();

            // Eliminar productos y sus imágenes
            foreach ($products as $product) {
                // Eliminar imágenes
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }

                // Eliminar producto
                $product->delete();
            }

            // Eliminar el usuario
            if ($isSelfDelete) {
                Auth::logout();
                $request->session()->invalidate();
            }

            $user->delete();

            return redirect()->route('Home')->with('success', 'Usuario con productos eliminados');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
