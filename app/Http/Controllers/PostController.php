<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct() // el constructor es lo que se ejecuta cuando es instanciada la clase PostController
    {
        $this->middleware('auth')->except(['show', 'index']); //un miidleware se va a ejecutar un poco antes que el index() y le pasamos la autenticación por lo que va a revisar antes de que se muestre el index que el usuario esté autenticado
        // Te permite crear URL's protegidas para que los usuarios estén autenticados y evitarles el acceso a ciertas áreas
    }

    public function index(User $user) {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(2); // sin get es "yo quiero esa consulta", pero con get() se trae los resultados

        return view('layouts.dashboards', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(User $user) {
        return view('posts.create', [
            'user' => $user
        ]);
    }

    public function store(Request $request) { // store es el que almacena en la BD, create es que nos permite tener el formulario de tipo get para visualizar la página
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripción' => 'required',
            'imagen' => 'required'
        ]);

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripción' => $request->descripción,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // Otra forma de crear registros
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripción = $request->descripción;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // Guardar registros en la BD usando las relaciones
        $request->user()->posts()->create([ // $request->user() es el usuario actual; posts() se refiere a la relación dentro del modelo de User y creamos un registro en esa relación
        'titulo' => $request->titulo,
        'descripción' => $request->descripción,
        'imagen' => $request->imagen,
        'user_id' => auth()->user()->id
        ]); 
        // La ventaja del tercer método es que no se requiere el uso de where() para filtrar los posts que son autoría de este usuario. Con la relación ya se está haciendo automáticamente

        // Redireccionar al Usuario
        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post) {
        // show es la convención para mostrar un solo recurso. Para mostrar todos los recursos, se usa index
        return view('posts.show', [
            'user' => $user,
            'post' => $post
        ]);
    }

    public function destroy(Post $post) {
        $this->authorize('delete', $post); // ese $post se toma de la URL (del RoundModelBinding), se pasa a la autorización y es el $post de aquí
        $post->delete();

        // Eliminando la imagen
        $imagen_path = public_path('uploads/' . $post->imagen); // public_path() marca la ruta al archivo public
        
        if (File::exists($imagen_path)) {
            unlink($imagen_path); // unlink() es una función de php que elimina un archivo
        }
        
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
