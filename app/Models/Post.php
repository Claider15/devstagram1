<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [ // el fillable es la información que se va a llenar en la BD para que Laravel sepaque inf. tiene que leer antes de enviarla a la BD
        'titulo',
        'descripción',
        'imagen',
        'user_id'
    ];

    public function user() {
    return $this->belongsTo(User::class)->select(['name', 'username']); // un post pertenece a un usuario
    }

    public function comentarios() { // un post tiene múltiples comentarios
        return $this->hasMany(Comentario::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user) {
        return $this->likes->contains('user_id', $user->id);
    }
}
