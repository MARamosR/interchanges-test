@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar contenedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('containers.store') }} enctype="multipart/form-data">
        @csrf
        @include('containers.partials.form')

        <div class="card p-2">
            <div class="mb-3">
                <label class="form-label">Imagenes del contenedor:</label>
                <div id='container-image-fields'>
        
                </div>
                <button class="btn btn-primary" id="addContainerImageBtn">Agregar imagen</button>
                <button class="btn btn-danger" id="removeContainerImageBtn">Remover imagen</button>
            </div>
        </div>

        <button type="submit" class="btn btn-success" id="submitBtn">Agregar</button>
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
        const submitBtn = document.getElementById('submitBtn');
        
        window.onload = function() {
            sessionStorage.removeItem('containers-store-message');
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
                    sessionStorage.setItem('containers-store-message', 'Contenedor agregado');
                    e.target.parentNode.submit();
                }
            });
        }

        submitBtn.addEventListener('click', submitHandler);
         
    </script>
@endsection
