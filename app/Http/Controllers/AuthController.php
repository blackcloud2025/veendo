<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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

        return response()->json([
            'success' => false,
            'error' => "Usuario o contraseña incorrectos"
        ]);
    }

    public function registro(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
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
            $user->password = Hash::make($request->password); // Usando Hash::make
            $user->save();
            $request->session()->regenerate();
            Auth::login($user);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'errors' => $th->getMessage(),
                'message' => 'Error al registrar en la DB'
            ]);
        }

        return redirect()->route('Home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("Home");
    }
// muestra la info del usuario en la pagina
    public function show()
    {
        $user = Auth::user();
        return view('profilepage', compact('user'));
    }
//funcion para editar el usuario
    public function edit()
    {
        $user = Auth::user();
        return view('profilepage', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $validador = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8'
    ]);

    if ($validador->fails()) {
        return redirect()->back()->withErrors($validador)->withInput();
    }

    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    $user->save();

    return redirect()->route('miperfil')->with('success', 'Perfil actualizado correctamente');
}
//destrutir usuario
public function destroy()
{
    $user = Auth::user();
    $user->delete();
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('Home')->with('success', 'Perfil eliminado correctamente');
}

}
