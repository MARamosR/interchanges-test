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
            Agregar operador
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
                        <th>Telefono</th>
                        <th>IAVE</th>
                        <th>Folio</th>
                        <th>Status</th>
                        <th></th>
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
                        <td>{{ $operator->telefono }}</td>
                        <td>{{ $operator->iave }}</td>
                        <td>{{ $operator->folio }}</td>
                        <td>
                            @if ($operator->status == 1)
                                <h5><span class="badge bg-warning p-1">Activo</span></h5>
                            @else
                                <h5><span class="badge bg-success p-1">Disponible</span></h5>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Seleccione una accion</button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('operators.edit', ['operator' => $operator->id]) }}" class="dropdown-item">Editar</a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('operators.destroy', ['operator' => $operator->id]) }}" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Eliminar" class="dropdown-item btn-delete">
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
                timer: 2000,
            });

            sessionStorage.removeItem('operators-message');
        }

        if (sessionStorage.getItem('operator-add-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('operator-add-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('operator-add-message');
        }

        if (sessionStorage.getItem('operator-edit-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('operator-edit-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('operator-edit-message');
        }

        
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('btn-delete')) {

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