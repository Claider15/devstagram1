import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: '.png, .jpg, .jpeg, .gif',
    addRemoveLinks: true, // Permite al Usuario remover imágenes
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {}
            imagenPublicada.size = 1234; // el valor no importa, es un valor que requieres (es obligatorio porque la imagen tiene que ser un objeto que tenga un size y un name)
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            
            this.options.addedfile.call(this, imagenPublicada); // this.options son las opciones de dropzone (addedfile es más interno de dropzone)
            // la diferencia entre call y bind es que con call, cuando se inicia la función, se llama automáticamente el call y con bind tu tienes que mandar a llamar la función
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`); // thumbnail o la imagen pequeña
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete'); // dz-success es una clase de dropzone
        }
    }
})

dropzone.on('success', function(file, response) {
    console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
});

dropzone.on('error', function(file, message) {
    console.log(message);
});

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = ''; // resetear el value de imagen cuando quite el archivp
});