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
    // Mostrar formulario dashboard
    public function dashboard()
    {
        $users = User::with('userProducts')->get();
        return view('dashboard', compact('users'));
    }

<<<<<<< HEAD
<<<<<<< HEAD
    // Mostrar formulario de inicio de sesión
=======



>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
=======



>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
    public function login(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'face_descriptor' => 'string'
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

            if ($request->face_descriptor && $user->face_descriptor) {
                $savedDescriptor = json_decode($user->face_descriptor);
                $newDescriptor = json_decode($request->face_descriptor);

                $distance = $this->calculateFaceDistance($savedDescriptor, $newDescriptor);
                $threshold = 0.6;

                if ($distance >= $threshold) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Verificación facial fallida'
                    ]);
                }
            }

            $request->session()->regenerate();
            Auth::login($user);
            return redirect()->route('Home');
        }

        return redirect()
            ->back()
            ->with('error', 'Error al ingrear usuario o password.')
            ->withInput();
    }

    // Función para calcular la distancia entre dos vectores
    private function calculateFaceDistance($descriptor1, $descriptor2)
{
    if (!is_array($descriptor1) || !is_array($descriptor2)) {
        return 1.0; // Distancia máxima si los descriptores no son válidos
    }

    $sum = 0;
    for ($i = 0; $i < count($descriptor1); $i++) {
        $diff = $descriptor1[$i] - $descriptor2[$i];
        $sum += $diff * $diff;
    }
    return sqrt($sum);
}
    //funcion de registro de usuario
    public function registro(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
                $validador = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

=======
        $validador = Validator::make($request->all(), [
            'name' => 'required',
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
=======
        $validador = Validator::make($request->all(), [
            'name' => 'required',
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/'
<<<<<<< HEAD
<<<<<<< HEAD
            ],

            'phone' => [
                'required',
                'min:10',
                'regex:/^(\(\d{3}\) |\d{3}-)\d{3}-\d{4}$/' // Formato de teléfono (123) 456-7890 o 123-456-7890
            ],

            'adress' => [
                'required',
                'string',
                'max:255'
            ],

            'identificacion' => [
                'required',
                'max:255',
                'regex:/^[0-9]+$/' // Solo números
            ],
            'face_descriptor' => ['nullable', function ($attribute, $value, $fail) {
                if ($value !== null) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail('The face descriptor must be a valid JSON string.');
                    }
                }
            }]
=======
=======
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
            ]
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
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
<<<<<<< HEAD
<<<<<<< HEAD
            $user->phone = $request->phone;
            $user->adress = $request->adress;
            $user->identificacion = $request->identificacion;
            $user->face_descriptor = $request->face_descriptor;
=======
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
=======
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
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
