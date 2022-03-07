@extends('layouts.master')
@section('title') Contenedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver contenedor @endslot
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
                    <h5 class="text-truncate font-size-15">Folio: {{ $container->folio }}</h5>
                </div>
            </div>
            @if (count($containerImages) > 0)
            <div class="overflow-x-auto d-flex flex-row overflow-y-hidden" style="max-width: 100%; overflow-x: auto" id="container-images-container">
                @foreach ($containerImages as $image)
                <img src="{{ $image->image_path }}" alt="{{ $image->id }}" class="container__image">
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
                    <h5 class="text-truncate">Serie: {{ $container->serie }}</h5>
                </div>
                
                <div class="mb-3">
                    <h5 class="text-truncate">Marca: {{ $container->marca }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Modelo: {{ $container->modelo }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Placa: {{ $container->placa }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Ubicación: {{ $container->ubicacion }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Canastilla: {{ $container->canastilla }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Propietario: {{ $container->propietario }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Ancho (mts): {{ $container->ancho }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Largo (mts): {{ $container->largo }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Alto (mts): {{ $container->alto }}</h5>
                </div>

                <div class="mb-3">
                    
                    <h5 class="text-truncate">Status: 
                        @if ($container->status === 0)
                        <span class="badge bg-success p-1">Disponible</span> 
                        @endif

                        @if ($container->status === 1)
                        <span class="badge bg-warning p-1">En uso</span>
                        @endif
                    </h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Tipo de caja: {{ $container->tipo_caja }}</h5>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .container__image {
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
    const imagesContainer = document.getElementById('container-images-container');
        const imagesModal = document.getElementById('imagesModal');
        const backdrop = document.getElementById('backdrop');

        let selectedImageUrl = '';

        const openImageModalHandler = e => {
            if (e.target.classList.contains('container__image')) {
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