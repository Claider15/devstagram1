<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    //
    public function store(Request $request, User $user, Post $post) {
        // Validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        // Almacenar el resultado
        Comentario::create([
            'user_id' => auth()->user()->id, // solamente usuarios autenticados pueden comentar (estoy tomando el usuario autenticado que comentó)
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]); 

        // Imprimir un mensaje
        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }
}
