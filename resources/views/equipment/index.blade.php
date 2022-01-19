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
                        <td>{{ $item->id_proveedor }}</td>
                        <td>{{ $item->activo === 1 ? 'En uso' : 'Disponible' }}</td>
                        <td>
                            <a href="{{ route('equipment.edit', ['equipment' => $item->id]) }}"
                                class="btn btn-warning">Modificar</a>
                            <form action="{{ route('equipment.destroy', ['equipment' => $item->id]) }}" id="equipmentDeleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger mt-2" id="equipmentSubmitDeleteBtn">
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
{{-- Data-tables --}}
<script>
    $(document).ready(function () {
            $('#equipment').DataTable();
        });
</script>
@endsection