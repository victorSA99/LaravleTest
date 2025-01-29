<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {

        $name = $request->get('name');
        $rol = $request->get('rol');


        $users = User::query();

        if ($name) {
            $users->where('name', 'like', '%' . $name . '%');
        }

        if ($rol) {
            $users->where('rol', $rol);
        }

        $users = $users->paginate(10);


        $roles = ['admin', 'user'];

        return view('usuarios.index', compact('users', 'roles'));
    }
}
