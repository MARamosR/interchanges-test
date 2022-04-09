@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Finalizar la ruta {{ $route->folio }} @endslot
@endcomponent


<div id="backdrop" class="backdrop">
    <div id="imagesModal" class="images__modal">
    </div>
</div>
<div>
    <div class="card">
        <div class="card-body">
            <p class="card-text">Imagenes de la ruta:</p>
            @if (count($images) > 0)
            <div class="overflow-x-auto d-flex flex-row overflow-y-hidden" style="max-width: 100%; overflow-x: auto"
                id="route-images-container">
                @foreach ($images as $image)
                <img src="{{ $image->path }}" alt="{{ $image->id }}" class="route__image">
                @endforeach
            </div>
            @else
            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                No se registraron imagenes para esta ruta.
            </div>
            @endif

        </div>
    </div>

    <form action="{{ route('routes.endRoute', ['route' => $route->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" name="fecha" class="form-control">
            @error('fecha')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación:</label>
            <input type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
            <p class="form-text">Lugar en donde se esta finalizando la ruta</p>
            @error('ubicacion')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>

            <textarea class="form-control" name="descripcion">{{ old('descripcion') }}</textarea>
            @error('descripcion')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Equipos de sujeción disponibles al momento de finalizar la ruta:</label>
                <br>

                @if (count($equipment) > 0)
                <ul class="list-group">
                    @foreach ($equipment as $item)
                    <li class="list-group-item d-flex align-items-center justify-content-between">

                        <div>
                            <input type="hidden" class="form-check-input" name="endEquipment[]" id="scaleEquipment"
                                value="{{ $item->id }}">
                            <label class="form-check-label">{{ $item->nombre }}</label>
                        </div>
                        <a href={{ route('equipment.show', ['equipment'=> $item->id]) }} class="btn">Ver equipo</a>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                    Esta ruta ya no esta usando equipos de sujeción
                </div>
                @endif


            </div>
        </div>

        <button type="submit" class="btn btn-success" id="submitBtn">Finalizar ruta</button>
    </form>
</div>
@endsection

<style>
    .route__image {
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
        width: 90%;
        height: 400px;
        z-index: 9999;
        border-radius: 8px;
        box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.4);
        display: none;
        background-position: center center;
        background-size: 90%;
        background-repeat: no-repeat;
        animation: fade-in 300ms ease forwards;
    }

    @media screen and (min-width: 768px) {
        .images__modal {
            width: 700px;
            height: 600px;
        }
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
    const imagesContainer = document.getElementById('route-images-container');
        const imagesModal = document.getElementById('imagesModal');
        const backdrop = document.getElementById('backdrop');

        let selectedImageUrl = '';

        const openImageModalHandler = e => {
            if (e.target.classList.contains('route__image')) {
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

<script>
    const submitBtn = document.getElementById('submitBtn');
    const lostEquipmentArr = document.getElementById('lostEquipment');
    const scaleEquipmentArr = document.getElementById('scaleEquipment');

    window.onload = function() {
        sessionStorage.removeItem('end-route-message');
    }

    const submitHandler = e => {
        e.preventDefault();

        TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: "Una vez marcada como finalizada una ruta los cambios no se podran revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('end-route-message', 'Ruta finalizada');
                    e.target.parentNode.submit();
                }
            });
    }

    submitBtn.addEventListener('click', submitHandler);
</script>
@endsection