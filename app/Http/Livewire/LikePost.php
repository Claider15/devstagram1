<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post) { // lo mismo que un constructor pero para livewire
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes()->count();
    }

    public function like() {
        if ($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false; // el mount solo evalúa cuando monta al componente (hayque hacer código reactivo en el mpetodo like. Con base a las interacciones del usuario puede cambiar)
            $this->likes--;
            // en el $request viene el usuario y el usuario ya tiene los likes asociado al modelo (modelo de User)
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
