@extends('layouts.master')
@section('title') @lang('Operadores') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Operadores @endslot
@endcomponent
<div>

    @can('operators.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('operators.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar operadores
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <table class="table" id="operators">
                <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>No.licencia</th>
                        <th>Tipo licencia</th>
                        <th>Otorgada en</th>
                        <th>Caduda en</th>
                        <th>Lugar de otorgamiento</th>
                        <th>IAVE</th>
                        <th>Folio</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operators as $operator)
                    <tr>
                        <th scope="row">{{ $operator->id }}</th>
                        <td>{{ $operator->nombre }}</td>
                        <td>{{ $operator->apellidos }}</td>
                        <td>{{ $operator->no_licencia }}</td>
                        <td>{{ $operator->tipo_licencia }}</td>
                        <td>{{ $operator->fecha_exp }}</td>
                        <td>{{ $operator->fecha_venc }}</td>
                        <td>{{ $operator->lugar_exp }}</td>
                        <td>{{ $operator->iave }}</td>
                        <td>{{ $operator->folio }}</td>
                        <td>{{ $operator->status == 1 ? 'Activo' : 'Disponible'}}</td>

                        <td>
                            <a href="{{ route('operators.edit', ['operator' => $operator->id]) }}"
                                class="btn btn-warning">Modificar</a>

                            <form method="POST" action="{{ route('operators.destroy', ['operator' => $operator->id]) }}"
                                class="mt-2">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
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
            $('#operators').DataTable();
        });
</script>

<script>
    const operatorsList = document.getElementById('operators');

    window.onload = function() {
        if (sessionStorage.getItem('operators-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('operators-message'),
                showConfirmButton: false,
                timer: 2500,
            });
        }

        sessionStorage.removeItem('operators-message');
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('btn-danger')) {

            // e.target.parentNode es el nodo del formulario
            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: `Una vez borrado un registro este no se podra recuperar, ademas, si el operador tiene Status "Activo" los datos de la ruta a la que esta asociado se corromperan`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.setItem('operators-message', 'Registro eliminado');
                        operatorsList.removeEventListener('click', deleteHandler);
                        e.target.parentNode.submit();
                    }
                });
        }
    }

    operatorsList.addEventListener('click', deleteHandler);
</script>
@endsection