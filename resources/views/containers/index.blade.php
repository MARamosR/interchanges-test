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


            <table class="table" id="containers">
                <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>Serie</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Status</th>
                        <th>Tipo de caja</th>
                        <th>Ubicación</th>
                        <th>Folio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($containers as $container)
                    <tr>
                        <th scope="row">{{ $container->id }}</th>
                        <td>{{ $container->serie }}</td>
                        <td>{{ $container->marca }}</td>
                        <td>{{ $container->placa }}</td>
                        <td>{{ $container->status === 1 ? 'En uso' : 'Disponible' }}</td>
                        <td>{{ $container->tipo_caja }}</td>
                        <td>{{ $container->ubicacion }}</td>
                        <td>{{ $container->folio }}</td>
                        <td>
                            <a href="{{ route('containers.edit', ['container' => $container->id]) }}"
                                class="btn btn-warning">Modificar</a>
                            <form action="{{ route('containers.destroy', ['container' => $container->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger mt-2" type="submit" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                timer: 2500,
            });
        }

        sessionStorage.removeItem('containers-message');
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('btn-danger')) {

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