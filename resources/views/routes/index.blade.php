@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver rutas @endslot
@endcomponent

<div>
    
    @can('routes.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('routes.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar ruta
        </a>
    </div>
    @endcan

    <table class="table">
        <thead>
            <tr>
                <th scope="row">ID</th>
                <th>Lugar de salida</th>
                <th>Fecha de salida</th>
                <th>Destino</th>
                <th>Fecha de llegada</th>
                <th>Descripcion</th>
                <th>Encargado</th>
                <th>Folio</th>
                <th>Status</th>
                <th>Fecha de termino</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($routes as $route)
            <tr>
                <th scope="row">{{ $route->id }}</th>
                <td>{{ $route->salida }}</td>
                <td>{{ $route->fecha_salida }}</td>
                <td>{{ $route->destino }}</td>
                <td>{{ $route->fecha_destino }}</td>
                <td>{{ $route->descripcion }}</td>
                <td>{{ $route->user->name }}</td>
                <td>{{ $route->folio }}</td>
                <td>{{ $route->status === 1 ? 'Activa' : 'Finalizada' }}</td>
                <td>{{ $route->fecha_termino }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Acciones <i class="fas fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('routes.show', ['route' => $route->id]) }}"> Ver ruta</a></li>
                            <li><a class="dropdown-item" href="{{ route('routes.createScale', ['route' => $route->id]) }}">Registrar escala</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')
    <script>
        window.onload = function() {
        
        if (sessionStorage.getItem('route-store-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('route-store-message'),
                showConfirmButton: false,
                timer: 2500,
            });

            sessionStorage.removeItem('route-store-message');
        }
        
    }
    </script>
@endsection