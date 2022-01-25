@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar unidad @endslot
@endcomponent

{{-- Creamos un arreglo con los años disponibles --}}
<?php $years = range(1900, strftime("%Y", time())); ?>
<div>
    <form method="POST" action={{ route('units.update', ['unit'=> $unit->id]) }} enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('unit.partials.form')


        {{-- IMAGENES ACTUALES DEL REGISTRO --}}
        <div class="mb-3">
            <label class="form-label">Imagenes actuales:</label>
            <div class="row row-cols-2">
                @forelse ($unitImages as $image)
                <div class="col">
                    <div class="card">
                        <img src="{{ $image->image_path }}" class="card-img-top p-4">
                        <div class="card-body">
                            <label>Marque para eliminar la imagen:</label>
                            <input type="checkbox" name="deleteImageIds[]" value="{{ $image->id }}">
                        </div>

                    </div>
                </div>
                @empty
                <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                    Este registro no cuenta con imagenes
                </div>
                @endforelse
            </div>
        </div>

        {{-- CAMPO PARA NUEVAS IMAGENES --}}
        <div class="card p-2">
            <div class="mb-3">
                <label class="form-label">Imagenes de la unidad:</label>
                <div id='unit-image-fields'>
        
                </div>
                <button class="btn btn-primary" id="addUnitImageBtn">Agregar imagen</button>
                <button class="btn btn-danger" id="removeUnitImageBtn">Remover imagen</button>
            </div>
        </div>

        <input type="submit" class="btn btn-success" value="Actualizar">
    </form>
</div>
@endsection

<style>
    .invisible {
        display: none;
    }
</style>

@section('script')
<script>
    const addImageBtn = document.getElementById('addUnitImageBtn');
    const removeImageBtn = document.getElementById('removeUnitImageBtn');
    const imagesContainer = document.getElementById('unit-image-fields');

    if (imagesContainer.childElementCount < 1) {
        removeImageBtn.classList.add('invisible');
    }

    const addImageField = e => {
        e.preventDefault();

        const imageField = document.createElement('input');
        imageField.classList = 'form-control mb-3';
        imageField.setAttribute('name', 'images[]');
        imageField.setAttribute('type', 'file');
        imagesContainer.appendChild(imageField);

        if (imagesContainer.childElementCount > 0) {
            removeImageBtn.classList.remove('invisible');
        }
    }

    const removeImageField = e => {
        e.preventDefault();

        const lastField = imagesContainer.querySelector('input:last-child');
        lastField.remove();

        if (imagesContainer.childElementCount < 1) {
            removeImageBtn.classList.add('invisible');
        }
    }

    addImageBtn.addEventListener('click', addImageField);
    removeImageBtn.addEventListener('click', removeImageField);
</script>
@endsection