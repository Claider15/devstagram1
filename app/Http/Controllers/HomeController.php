<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'auth'); // para que puedan ver la página principal, primero deben estar autenticados
    }

    public function __invoke() { // invoke es un método que se manda a llamar automáticamente.
        // Recomendado para controladores con un sólo métdodo
        
        // Obtener a quienes seguimos
        $ids = auth()->user()->following->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20); // whereIn es para arreglos
        // estamos filtrando por posts de las personas que seguimos y los estamos ordenando por el último; primero


        return view('home', [
            'posts' => $posts
        ]);
    }
}
