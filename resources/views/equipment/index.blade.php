@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver equipo de sujeción @endslot
@endcomponent
<div>
    
    @can('equipment.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('equipment.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar equipo
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <table class="table" id="equipment">
                <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>Nombre del equipo</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Folio</th>
                        <th>Proveedor</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($equipment as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->precio_unitario }}</td>
                        <td>{{ $item->folio }}</td>
                        <td>{{ $item->provider->proveedor }}</td>
                        <td>
                            @if ($item->activo == 0)
                            <h5><span class="badge bg-success">Disponible</span></h5>                            
                            @endif

                            @if ($item->activo === 1)
                            <h5><span class="badge bg-warning">En uso</span></h5>    
                            @endif

                            @if ($item->activo === 2)
                            <h5><span class="badge bg-danger">Extraviado</span></h5>    
                            @endif
                            
                        </td>
                        
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Seleccione una accion
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="{{ route('equipment.show', ['equipment' => $item->id]) }}">Ver equipo</a></li>
                                  <li>
                                    <a href="{{ route('equipment.edit', ['equipment' => $item->id]) }}" class="dropdown-item">Editar</a>
                                  </li>
                                  <li>
                                    <form action="{{ route('equipment.destroy', ['equipment' => $item->id]) }}" id="equipmentDeleteForm" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Eliminar" id="equipmentSubmitDeleteBtn" class="dropdown-item delete-btn">
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

@section('script')
{{-- Data-tables --}}
<script>
    $(document).ready(function () {
            $('#equipment').DataTable();
        });
</script>

<script>
    const equipmentList = document.getElementById('equipment');

    window.onload = function() {
        if (sessionStorage.getItem('equipment-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('equipment-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('equipment-message');
        }

        if (sessionStorage.getItem('equipment-store-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('equipment-store-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('equipment-store-message');
        }

        if(sessionStorage.getItem('equipment-edit-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('equipment-edit-message'),
                showConfirmButton: false,
                timer: 2000,
            });

            sessionStorage.removeItem('equipment-edit-message');
        }

        
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('delete-btn')) {

            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: `Una vez borrado un registro este no se podra recuperar, ademas, si el Status del equipo es "En uso" los datos de la ruta que lo este usando se corromperan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.setItem('equipment-message', 'Registro eliminado');
                        equipmentList.removeEventListener('click', deleteHandler);
                        
                        // e.target.parentNode es el nodo del formulario
                        e.target.parentNode.submit();
                    }
                });
        }
    }

    equipmentList.addEventListener('click', deleteHandler);
</script>
@endsection