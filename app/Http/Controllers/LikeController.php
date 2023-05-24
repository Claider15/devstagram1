<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post) {
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back(); // para que nos regrese al mismo post
    }

    public function destroy(Request $request, Post $post) {
        $request->user()->likes()->where('post_id', $post->id)->delete();
        // en el $request viene el usuario y el usuario ya tiene los likes asociado al modelo (modelo de User)
        return back();
    }
}
