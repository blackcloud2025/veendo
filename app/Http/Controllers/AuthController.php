<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    if($user){

      if ($user->password == $pass) {
        $request->session()->regenerate();
        Auth::login($user);
      } else {
        return response()->json([
          'success' => false,
          'error' => "user or password isn't correct"
        ]);
      }
    } else {
      return response()->json([
        'success' => false,
        'error' => "user or password isn't correct"
      ]);
    }


    return redirect()->route('Home');
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
      $user->password = $request->password;
      $user->user_id = 1;
      $user->save();

      $request->session()->regenerate();
      Auth::login($user);
    } catch (\Throwable $th) {
      return response()->json([
        'success' => false,
        'errors' => $th->getMessage(),
        'message' => 'error al registrar en la DB'
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
}
