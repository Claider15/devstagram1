<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user) {
        return view('perfil.index', [
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        //modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]); // convierte un string a un url
        
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'] // cuando son más de 3 reglas de validación, laravel recomienda que estén dentro de un arreglo
        ]);

        if($request->imagen) {
            $imagen = $request->imagen;
 
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
    
            $imagenPath = public_path('perfiles') . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar cambios
        $usuario = User::find(auth()->user()->id); // usuario actual que está modificando su inf.
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save(); // para almacenar en una BD

        // Redireccionar al usuario
        return redirect()->route('posts.index', $usuario->username); // no se usa el auth()->user() porque puede ser que hayan modificado el username 
    }
}
