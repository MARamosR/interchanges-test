@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver unidades @endslot
@endcomponent
<div>
    @can('units.create')
    <div class="mb-4  d-flex flex-row-reverse">
        <a class="btn btn-success ml-2 mr-2" href="{{ route('units.create') }}">
            <i class='bx bx-plus'></i>
            Agregar unidad
        </a>
    </div>    
    @endcan

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table" id="units">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Año</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($units as $unit)
                    <tr>
                        <th scope="row">{{ $unit->id }}</th>
                        <td>{{ $unit->placa }}</td>
                        <td>{{ $unit->modelo }}</td>
                        <td>{{ $unit->marca }}</td>
                        <td>{{ $unit->anio }}</td>
                        <td>
                            @if ($unit->status == 0)
                            <h5><span class="badge bg-success p-1">Disponible</span></h5>
                            @else
                            <h5><span class="badge bg-warning p-1">En uso</span></h5>
                            @endif
                            
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Seleccione una accion</button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('units.show', ['unit' => $unit->id]) }}" class="dropdown-item">Ver</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('units.edit', ['unit' => $unit->id]) }}" class="dropdown-item">Editar</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('units.destroy', ['unit' => $unit->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="dropdown-item delete-btn" value="Eliminar">
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
            $('#units').DataTable();
        });
</script>

<script>
    const unitsList = document.getElementById('units');

    window.onload = function() {
        
        if (sessionStorage.getItem('units-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('units-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('units-message');
        }
        if (sessionStorage.getItem('unit-store-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('unit-store-message'),
                showConfirmButton: false,
                timer: 2500,
            });

            sessionStorage.removeItem('unit-store-message');
        }
        if (sessionStorage.getItem('unit-update-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('unit-update-message'),
                showConfirmButton: false,
                timer: 2500,
            });

            sessionStorage.removeItem('unit-update-message');
        }
    }
    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('delete-btn')) {
            // e.target.parentNode es el nodo del formulario
            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: 'Una vez borrado un registro este no se podra recuperar',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('units-message', 'Registro eliminado');
                    unitsList.removeEventListener('click', deleteHandler);
                    e.target.parentNode.submit();
                }
            });
        }
    }

    unitsList.addEventListener('click', deleteHandler);

</script>
@endsection