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
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="routes">
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
                            <th></th>
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
                            <td>
                                @if ($route->status === 1)
                                <h5><span class="badge bg-warning p-1">Activa</span></h5>
                                @endif

                                @if ($route->status === 0)
                                <h5><span class="badge bg-success p-1">Finalizada</span></h5>
                                @endif
                            </td>
                            <td>
                                @if ($route->fecha_termino)
                                {{ $route->fecha_termino }}
                                @else
                                <h5><span class="badge bg-secondary p-1">Esta ruta aun no finaliza</span></h5>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item"
                                                href="{{ route('routes.show', ['route' => $route->id]) }}"> Ver ruta</a>
                                        </li>
                                        @if ($route->status === 1)

                                        <li><a class="dropdown-item"
                                                href="{{ route('routes.createScale', ['route' => $route->id]) }}">Registrar
                                                escala</a></li>
                                        @endif
                                        @if ($route->status === 1)
                                        <li><a class="dropdown-item"
                                                href="{{ route('routes.createScale', ['route' => $route->id, 'endRoute' => true]) }}">Finalizar
                                                la ruta</a></li>
                                        @endif
                                        <form action="{{ route('routes.destroy', ['route' => $route->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="dropdown-item delete-btn" value="Eliminar ruta">
                                        </form>
                                    </ul>
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

@endsection

@section('script')
<script>
    $(document).ready(function () {
            $('#routes').DataTable();
        });
</script>

<script>
    const routesList = document.getElementById('routes');

    window.onload = function() {
        
        if (sessionStorage.getItem('routes-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('routes-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('routes-message');
        }

        if (sessionStorage.getItem('route-store-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('route-store-message'),
                showConfirmButton: false,
                timer: 2500,
            });

            sessionStorage.removeItem('route-store-message');
        }

        if (sessionStorage.getItem('end-route-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('end-route-message'),
                showConfirmButton: false,
                timer: 2500,
            });

            sessionStorage.removeItem('end-route-message');
        }

        
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('delete-btn')) {
            // e.target.parentNode es el nodo del formulario
            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: 'Una vez borrado un registro este no se podra recuperar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('routes-message', 'Registro eliminado');
                    routesList.removeEventListener('click', deleteHandler);
                    e.target.parentNode.submit();
                }
            });
        }
    }

    routesList.addEventListener('click', deleteHandler);
</script>

@endsection