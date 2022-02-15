@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar unidad @endslot
@endcomponent

{{-- Creamos un arreglo con los años disponibles --}}
<?php $years = range(1900, strftime("%Y", time())); ?>
<div>
    <form method="POST" action={{ route('units.store') }} enctype="multipart/form-data">
        @csrf
        @include('unit.partials.form')

        <div class="card p-2">
            <div class="mb-3">
                <label class="form-label">Imagenes de la unidad:</label>
                <div id='unit-image-fields'>
        
                </div>
                <button class="btn btn-primary" id="addUnitImageBtn">Agregar imagen</button>
                <button class="btn btn-danger" id="removeUnitImageBtn">Remover imagen</button>
            </div>
        </div>

        <button type="submit" class="btn btn-success" id="storeUnitBtn">Agregar unidad</button>
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

    <script>
        const storeUnitBtn = document.getElementById('storeUnitBtn');

        window.onload = function() {
            sessionStorage.removeItem('unit-store-message');
        }

        const handleConfirmation = e => {
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
                    sessionStorage.setItem('unit-store-message', 'Unidad agregada');
                    e.target.parentNode.submit();
                }
            });

            
        }

        storeUnitBtn.addEventListener('click', handleConfirmation);
    </script>
@endsection
