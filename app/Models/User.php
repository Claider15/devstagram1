<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Like;
use App\Models\Post;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this->hasMany(Post::class); // hasMany = one-to-many
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    // Método que almacena los seguidores de un Usuario
    public function followers() {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); // Un usuario con el id 1 puede tener seguidores con el id 3, 5, 6, etc (pertenece a muchos esa relación)
        // en este caso nos salimos de las convenciones de laravel porque el método followers no coincide con el nombre del modelo User y por eso le pasamos la tabla de followers
        // el método followers de la tabla followers pertenece a muchos usuarios.
        // el usuario va a tener el método de followers y va a insertar en la tabla de followers; tanto el 
        // user_id como el follower_id. User_id es el usuario que estamos visitando, follower_id es la persona que le está dando seguir a la otra persona
    }

    
    // Método para almacenar los que seguimos
    public function following() {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id'); 
    }

    // Comprobar si un usuario ya sigue a otro
    public function siguiendo(User $user) {
        return $this->followers->contains($user->id); // followers() va a revisar si el usuario que está visitando el muro ya es seguidor de esa persona y retorna true o false
        // contains() sirve para iterar en toda la tabla de followers y ver si esa persona ya es seguidor
    }


}