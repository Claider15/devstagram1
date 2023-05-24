<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request) {

        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension(); // uuid() genera un Id único para cada una de las imágenes

        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);

        $imagenPath = public_path('uploads') . "/" . $nombreImagen; // public_path apunta hacia la carpeta public
        $imagenServidor->save($imagenPath);
        
        return response()->json(['imagen' => $nombreImagen ]);
    }
}
