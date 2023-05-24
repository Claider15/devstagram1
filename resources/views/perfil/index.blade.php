@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{auth()->user()->username}}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6s">
            <form class="mt-10 md:mt-0" method="POST" enctype="multipart/form-data" action="{{route('perfil.store')}}">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input id="username" name="username" type="text" placeholder="Tu Nombre de Usuario" class="border p-3 
                    w-full rounded-lg @error('username') border-red-500 @enderror" value="{{auth()->user()->username}}">  <!-- el helper de old('valor dado en atributo name') es para que se mantenga el valor del input anterior cuando haya un error -->

                    @error('username') <!-- La dirrectiva de error funciona en conjunto con el métdodo $this->validate() en el controlador  -->
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}</p> <!-- la variable $message es de Laravel que imprime distintas clases de error -->
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input id="imagen" name="imagen" type="file" class="border p-3 
                    w-full rounded-lg" value=""
                    accept=".jpg, .jpeg, .png">  
                </div>

                <input type="submit" value="Guardar Cambios" class="bg-sky-600 hover:bg-sky-700 
                transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection