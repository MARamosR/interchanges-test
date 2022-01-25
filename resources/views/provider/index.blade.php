@extends('layouts.master')
@section('title') Proveedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver proveedores @endslot
@endcomponent

<div>

    @can('providers.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('providers.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar proveedor
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <table class="table" id="providers">
                <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                    <tr>
                        <th scope="row">{{ $proveedor->id }}</th>
                        <td>{{ $proveedor->proveedor }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>{{ $proveedor->ciudad }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>
                            <a href="{{ route('providers.edit', ['provider' => $proveedor->id]) }}"
                                class="btn btn-warning">Modificar</a>
                            <form action="{{ route('providers.destroy', ['provider' => $proveedor->id]) }}"
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

@section('script') //Metemos el script de los data-tables
<script>
    $(document).ready(function () {
            $('#providers').DataTable();
        });
</script>

<script>
    const providersList = document.getElementById('providers');

    window.onload = function() {
        if (sessionStorage.getItem('providers-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('providers-message'),
                showConfirmButton: false,
                timer: 2500,
            });
        }

        sessionStorage.removeItem('providers-message');
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('btn-danger')) {

            // e.target.parentNode es el nodo del formulario
            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: "Una vez borrado un registro este no se podra recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.setItem('providers-message', 'Registro eliminado');
                        providersList.removeEventListener('click', deleteHandler);
                        e.target.parentNode.submit();
                    }
                });
        }
    }

    providersList.addEventListener('click', deleteHandler);


</script>
@endsection