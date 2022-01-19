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
                    <a href="{{ route('operators.edit', ['operator' => $operator->id]) }}" class="btn btn-warning" >Modificar</a>
                    
                    <form method="POST" action="{{ route('operators.destroy', ['operator' => $operator->id]) }}" class="mt-2">
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
@endsection

@section('script') //Metemos el script de los data-tables
<script>
    $(document).ready(function () {
            $('#operators').DataTable();
        });
</script>
@endsection