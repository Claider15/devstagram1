<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cada comentario va a almacenar el usuario y el post al que pertenece
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // constrained crea un foreign id; con respecto al id y el nombre de la tabla que usa la convención (nombreModelo_id)
            $table->string('comentario');
            $table->timestamps();
            // con onDelete('cascade) cuando elimino un post, tambien se van a eliminar sus comentarios. Lo mismo cuando un usuario elimina su cuenta (se eliminan los comentarios) 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
