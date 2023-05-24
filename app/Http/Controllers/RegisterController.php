<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function index(User $user) {
        return view('auth.register', [
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        // dd($request);
        // dd($request->get('username'));

        //modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]); // convierte un string a un url
        
        // Validación
        $this->validate($request, [
            'name' => 'required|max:30',  // También pueder ser así - ['required', 'min:5'] 
            'username' => 'required|unique:users|min:3|max:20', // El username es unique porque en devstagram (como instagram) para que redireccione al usuario hacia las publicaciones de esa persona
            'email' => 'required|unique:users|email|max:60', // El email debe ser unique. La tabla que va a verificar que ese email sea único va a ser en la de users (en carpeta database/migrations existe una migración llamada usersy laravek crea automáticamente esa tabla)
            'password' => 'required|confirmed|min:6' // Al tener password_confirmation (el segundo campo debe ser igual al primero) en un for de HTML y la regla confirmed en password va a verificar que el campo de confirmación sean iguales
        ]);

        User::create([
            'name' => $request->name, // igual puede ser así $request->get('name')
            'username' => $request->username, 
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Autenticar un Usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // Otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar al Usuario
        return redirect()->route('posts.index');
    }
}
