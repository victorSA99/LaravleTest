<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;



class AuthViewController extends Controller
{
    public function index()
    {
        $data['texto'] = "prueba de variable";
        return view('auth.auth', $data);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {



            if (auth()->guard('web')->user()->rol === 'admin') {

                return response()->json(['message' => 'Inicio de sesión exitoso como administrador']);
            } else {

                Auth::guard('web')->logout();
                return response()->json(['message' => 'No tienes permisos de administrador'], 403);
            }
        } else {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }
    }

    public function logout(Request $request)
    {

        Auth::guard('web')->logout();


        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function registerView()
    {
        return view('auth.register');
    }
}
