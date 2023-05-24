@extends('layouts.app')

@section('titulo')
    Crea una nueva Publicación
@endsection

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>

@section('contenido')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data" 
            id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col 
            justify-center items-center">
            @csrf
            </form>
        </div>

        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{route('posts.store')}}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for='titulo' class="mb-2 block uppercase text-gray-500 font-bold">
                        Título
                    </label>

                    <input id="titulo" name="titulo" type="text" placeholder="Título de la Publicación" class="border p-3 
                    w-full rounded-lg @error('titulo') border-red-500 @enderror" value="{{old('titulo')}}">  <!-- el helper de old('valor dado en atributo titulo') es para que se mantenga el valor del input anterior cuando haya un error -->

                    @error('titulo') <!-- La dirrectiva de error funciona en conjunto con el métdodo $this->validate() en el controlador  -->
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}</p> <!-- la variable $message es de Laravel que imprime distintas clases de error -->
                    @enderror
                </div>

                <div class="mb-5">
                    <label for='descripción' class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripción
                    </label>

                    <textarea id="descripción" name="descripción" placeholder="Descripción de la Publicación" class="border p-3 
                    w-full rounded-lg @error('descripción') border-red-500 @enderror"> 
                        {{old('descripción')}}
                    </textarea>

                    @error('descripción') <!-- La dirrectiva de error funciona en conjunto con el métdodo $this->validate() en el controlador  -->
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}</p> <!-- la variable $message es de Laravel que imprime distintas clases de error -->
                    @enderror

                    <div class="mb-5">
                        <input type="hidden" name="imagen" value="{{old('imagen')}}">
                        
                        @error('imagen') <!-- La dirrectiva de error funciona en conjunto con el métdodo $this->validate() en el controlador  -->
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}</p> <!-- la variable $message es de Laravel que imprime distintas clases de error -->
                        @enderror
                    </div>


                    <input type="submit" value="Crear Publicación" class="bg-sky-600 hover:bg-sky-700 
                transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
                </div>
            </form>
        </div>
    </div>
@endsection