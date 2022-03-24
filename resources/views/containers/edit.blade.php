@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar contenedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('containers.update', ['container'=> $contenedor->id]) }}
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('containers.partials.form')

        <label class="form-label">Imagenes actuales:</label>
        <div class="row row-cols-2">
            @forelse ($contanerImages as $image)
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



        <div class="card p-2">
            <div class="mb-3">
                <label class="form-label">Imagenes del contenedor:</label>
                <div id='container-image-fields'>

                </div>
                <button class="btn btn-primary" id="addContainerImageBtn">Agregar imagen</button>
                <button class="btn btn-danger" id="removeContainerImageBtn">Remover imagen</button>
            </div>
        </div>

        <button type="submit" class="btn btn-success" id="editBtn">Guardar cambios</button>
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
    const addImageBtn = document.getElementById('addContainerImageBtn');
        const removeImageBtn = document.getElementById('removeContainerImageBtn');
        const imagesContainer = document.getElementById('container-image-fields');

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

<script>
    const editBtn = document.getElementById('editBtn');

    window.onload = function() {
        sessionStorage.removeItem('containers-edit-message');
    }

    const submitHandler = e => {
        e.preventDefault();

        TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: "Verifique que los datos sean correctos",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('containers-edit-message', 'Contenedor editado correctamente');
                    e.target.parentNode.submit();
                }
            });
    }

    editBtn.addEventListener('click', submitHandler);
</script>
@endsection