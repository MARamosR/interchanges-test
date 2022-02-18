@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver equipo de sujeción @endslot
@endcomponent

<div id="backdrop" class="backdrop">
    <div id="imagesModal" class="images__modal">
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">

            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15">Folio: {{ $equipment->folio }}</h5>
                </div>
            </div>

            @if (count($equipmentImages) > 0)
            <div class="overflow-x-auto d-flex flex-row overflow-y-hidden" style="max-width: 100%; overflow-x: auto" id="equipment-images-container">
                @foreach ($equipmentImages as $image)
                <img src="{{ $image->image_path }}" alt="{{ $image->id }}" class="equipment__image">
                @endforeach
            </div>
            @else
            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                Este registro no contiene imagenes
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="text-truncate mb-3">Detalles:</h5>
            <div class="row row-cols-2">
                
                <div class="mb-3">
                    <h5 class="text-truncate">Nombre del equipo: {{ $equipment->nombre }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Descripción: {{ $equipment->descripcion }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Ubicación: {{ $equipment->ubicacion }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Proveedor: {{ $provider->proveedor }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Precio unitario: {{ $equipment->precio_unitario }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Status: 
                        @if ($equipment->activo === 0)
                        <span class="badge bg-success p-1">Disponible</span>    
                        @endif

                        @if ($equipment->activo === 1)
                        <span class="badge bg-warning p-1">En uso</span>
                        @endif

                        @if ($equipment->activo === 2)
                        <span class="badge bg-danger p-1">Extraviado</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .equipment__image {
        object-fit: cover;
        max-width: 300px;
        max-height: 400px;
        display: block;
        margin-right: 10px;
        border: 3px solid #cecece;
        border-radius: 8px;
    }

    .images__modal {
        position: absolute;
        right: 0;
        left: 0;
        top: 20;
        margin: 0 auto;
        background-color: #cecece;
        width: 700px;
        height: 600px;
        z-index: 9999;
        border-radius: 8px;
        box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.4);
        display: none;
        background-position: center center;
        background-size: 90%;
        background-repeat: no-repeat;
        animation: fade-in 300ms ease forwards;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: scale(0);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .backdrop {
        position: fixed;
        top: 0;
        left: 0;
        min-width: 100vw;
        min-height: 100vh;
        display: none;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 9999;
    }
</style>


@section('script')
<script>
    const imagesContainer = document.getElementById('equipment-images-container');
        const imagesModal = document.getElementById('imagesModal');
        const backdrop = document.getElementById('backdrop');

        let selectedImageUrl = '';

        const openImageModalHandler = e => {
            if (e.target.classList.contains('equipment__image')) {
                backdrop.style.display = 'block';
                imagesModal.style.display = 'block';
                imagesModal.style.backgroundImage = `url(${e.target.src})`;
            }
        } 

        const closeImageModalHandler = e => {
            if (e.target.classList.contains('backdrop')) {
                selectedImageUrl = '';
                backdrop.style.display = 'none';
                imagesModal.style.display = 'none';
            }
        }   

        imagesContainer.addEventListener('click', openImageModalHandler);
        backdrop.addEventListener('click', closeImageModalHandler);

</script>
@endsection