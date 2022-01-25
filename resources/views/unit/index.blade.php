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
            <table class="table" id="units">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Año</th>
                        <th>Status</th>
                        <th>Acciones</th>
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
                        <td>{{ $unit->status == 0 ? 'Disponible' : 'En uso'  }}</td>
                        <td>
                            <a href="{{ route('units.edit', ['unit' => $unit->id]) }}"
                                class="btn btn-warning">Modificar</a>
                            <form action="{{ route('units.destroy', ['unit' => $unit->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger mt-2" value="Eliminar">
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
            $('#units').DataTable();
        });
</script>

<script>
    const unitsList = document.getElementById('units');

    window.onload = function() {
        
        //TODO: REVISAR PORQUE USAMOS containers-message en una vista de units.
        if (sessionStorage.getItem('units-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('units-message'),
                showConfirmButton: false,
                timer: 2500,
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