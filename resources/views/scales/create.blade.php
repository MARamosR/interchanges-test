@extends('layouts.master')
@section('title') Escalas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Registrar escala de la ruta {{ $route->folio }} @endslot
@endcomponent
<div>
    <form action="" enctype="multipart/form-data">
        @csrf
        <div class="row row-cols-2">
            <div class="mb-3">
                <label for="form-label">Descripción de la escala:</label>
                <input type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label for="form-label">Ubicación:</label>
                <input type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label for="form-label">Fecha:</label>
                <input type="date" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label for="form-label">Contenedores en uso:</label>
            @forelse ($containers as $container)
            <div class="card">
                @forelse ($container->containerImage as $image)
                <img src="{{ $image->image_path }}" class="avatar-lg">
                @empty
                <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                    No hay imagenes registradas para este contenedor
                </div>
                @endforelse
                

                <div class="card-body">
                    Placa: {{ $container->placa }}
                </div>
            </div>
            @empty
            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                Esta ruta no esta usando ningún contenedor
            </div>
            @endforelse
        </div>

        <div class="mb-3">
            <label for="form-label">Equipo de sujeción en uso:</label>
            @forelse ($equipment as $item)
            <div class="card">
                <div class="card-body">
                    {{ $item->nombre }}
                </div>
            </div>
            @empty
            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                Esta ruta no esta usando ningún equipo de sujeción
            </div>
            @endforelse
        </div>

        <input type="submit" class="btn btn-success" value="Registrar escala">
    </form>
</div>
@endsection