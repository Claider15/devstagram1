<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(User $user) {
        return view('auth.login', [
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'email' => 'required|email', // El email debe ser unique. La tabla que va a verificar que ese email sea único va a ser en la de users (en carpeta database/migrations existe una migración llamada usersy laravek crea automáticamente esa tabla)
            'password' => 'required' // Al tener password_confirmation (el segundo campo debe ser igual al primero) en un for de HTML y la regla confirmed en password va a verificar que el campo de confirmación sean iguales
        ]);


        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
            // back() envía a la página anterior pero con el mensaje creado con with() que lo guarda en la sesión (session)
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
