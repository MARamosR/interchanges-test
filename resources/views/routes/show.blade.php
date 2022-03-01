@extends('layouts.master')
@section('title') Ruta @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Detalles de la ruta @endslot
@endcomponent

<div class="row container-fluid">
    <div class="col-xl-4">
        <h2>@yield('page-title')</h2>
    </div>
</div>

<div class="mb-4 d-flex flex-row-reverse">
    
    @if ($route->status === 1)
    <a class="btn btn-primary ml-2 mx-2" href="{{ route('routes.createScale', ['route' => $route->id]) }}">
        <i class='bx bx-plus'></i>
        Registrar una escala
    </a>

    <a class="btn btn-success ml-2 mx-2" href="{{ route('routes.createScale', ['route' => $route->id, 'endRoute' => true]) }}">
        Finalizar la ruta
    </a>    
    @endif
</div>


<div id="backdrop" class="backdrop">
    <div id="imagesModal" class="images__modal">
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-truncate font-size-15">Folio: {{ $route->folio }}</h5>
                    </div>
                </div>

                @if (count($images) > 0)
                <div class="overflow-x-auto d-flex flex-row overflow-y-hidden" style="max-width: 100%; overflow-x: auto"
                    id="route-images-container">
                    @foreach ($images as $image)
                    <img src="{{ $image->path }}" alt="{{ $image->id }}" class="route__image">
                    @endforeach
                </div>    
                @else
                <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                    Este registro no contiene imagenes
                </div>
                @endif

                <h5 class="font-size-15 mt-4">Descripción de la ruta:</h5>

                <p class="text-muted">{{ $route->descripcion }}</p>


                <div class="row task-dates">
                    <div class="col-sm-4 col-6">
                        <div class="mt-4">
                            <h5 class="font-size-14"><i class="bx bx-calendar me-1 text-primary"></i>Fecha de salida
                            </h5>
                            <p class="text-muted mb-0">{{ $route->fecha_salida }}</p>
                        </div>
                    </div>

                    <div class="col-sm-4 col-6">
                        <div class="mt-4">
                            <h5 class="font-size-14"><i class="bx bx-calendar-event me-1 text-primary"></i>Fecha de
                                llegada estimada</h5>
                            <p class="text-muted mb-0">{{ $route->fecha_destino }}</p>
                        </div>
                    </div>

                    <div class="col-sm-4 col-6">
                        <div class="mt-4">
                            <h5 class="font-size-14"><i class="bx bx-calendar-check me-1 text-primary"></i>Fecha de
                                llegada</h5>
                            @if ($route->fecha_termino !== null)
                            <p class="text-muted mb-0">{{ $route->fecha_termino }}</p>
                            @else
                            <p class="text-muted mb-0">Ruta aún en curso</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Operador</h4>
                <h6 class="text-dark">Nombre:</h6>
                <p class="card-text">{{ $operator->nombre }} {{ $operator->apellidos }}</p>

                <h6 class="text-dark">Numero de contacto:</h6>
                <p class="card-text">{{ $operator->telefono }}</p>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Unidad</h4>
                <h6 class="text-dark">Placa:</h6>
                <p class="card-text">{{ $unit->placa }}</p>

                <h6 class="text-dark">Folio:</h6>
                <p class="card-text">{{ $unit->folio }}</p>
            </div>
        </div>
    </div>

</div>
<!-- end col -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Contenedores</h4>
                <div class="list-group">
                    @foreach ($containers as $container)
                    <a href="{{ route('containers.show', ['container' => $container->id]) }}"
                        class="list-group-item list-group-item-action overflow-auto" style="cursor: pointer">
                        <h6 class="text-dark">Placa:</h6>
                        <p class="card-text">{{ $container->placa }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Equipo de sujeción</h4>
                <div class="list-group">
                    @foreach ($equipment as $item)
                    <a class="list-group-item list-group-item-action overflow-auto" style="cursor: pointer"
                        href="{{ route('equipment.show', ['equipment' => $item->id]) }}">
                        <h6 class="text-dark">Equipo:</h6>
                        <p class="card-text">{{ $item->nombre }}</p>
                    </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Documentos / Reportes</h4>
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle table-hover mb-0">
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-secondary bg-soft text-danger fs-1">
                                            <i class='bx bxs-file-pdf'></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-14 mb-1">{{ $invoice->descripcion }}</h5>
                                    <small>Fecha de creación: {{ $invoice->created_at }}</small>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{ route('routes.showInvoice', ['invoice' => $invoice->id]) }}"
                                            class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
        top: 30;
        margin: 0 auto;
        background-color: #cecece;
        width: 90%;
        height: 800px;
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
            width: 90%;
            height: 700px;
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
@endsection