@extends('layouts.master')
@section('title') Contenedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver contenedor @endslot
@endcomponent

<div>
    @can('containers.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('containers.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar contenedor
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
            <table class="table" id="containers">
                <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>Serie</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Tipo de caja</th>
                        <th>Ubicación</th>
                        <th>Status</th>
                        <th>Folio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($containers as $container)
                    <tr>
                        <th scope="row">{{ $container->id }}</th>
                        <td>{{ $container->serie }}</td>
                        <td>{{ $container->marca }}</td>
                        <td>{{ $container->placa }}</td>
                        <td>{{ $container->tipo_caja }}</td>
                        <td>{{ $container->ubicacion }}</td>
                        <td>
                            @if ($container->status == 0)
                            <h5><span class="badge bg-success">Disponible</span></h5>
                            @else
                            <h5><span class="badge bg-warning">En uso</span></h5>
                            @endif
                            
                        </td>
                        <td>{{ $container->folio }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Seleccione una accion
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="{{ route('containers.show', ['container' => $container->id]) }}">Ver contenedor</a></li>
                                  <li>
                                    <a href="{{ route('containers.edit', ['container' => $container->id]) }}" class="dropdown-item">Editar</a>
                                  </li>
                                  <li>
                                    <form action="{{ route('containers.destroy', ['container' => $container->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input class="dropdown-item delete-btn" type="submit" value="Eliminar">
                                    </form>
                                  </li>
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
            $('#containers').DataTable();
        });
</script>

<script>
    const containersList = document.getElementById('containers');

    window.onload = function() {
        if (sessionStorage.getItem('containers-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('containers-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('containers-message');
        }

        if (sessionStorage.getItem('containers-store-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('containers-store-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('containers-store-message');
        }

        if (sessionStorage.getItem('containers-edit-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('containers-edit-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('containers-edit-message');
        }

        
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('delete-btn')) {

            // e.target.parentNode es el nodo del formulario
            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: `Una vez borrado un registro este no se podra recuperar, ademas si el contenedor tiene status "En uso" los datos de la ruta que lo esta usando se corromperan `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.setItem('containers-message', 'Registro eliminado');
                        containersList.removeEventListener('click', deleteHandler);
                        e.target.parentNode.submit();
                    }
                });
        }
    }

    containersList.addEventListener('click', deleteHandler);


</script>
@endsection