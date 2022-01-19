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

    <table class="table" id="containers">
        <thead>
            <tr>
                <th scope="row">ID</th>
                <th>Serie</th>
                <th>Marca</th>
                <th>Placa</th>
                <th>Status</th>
                <th>Tipo de caja</th>
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
                    <td>
                        <a href="{{ route('containers.edit', ['container' => $container->id]) }}" class="btn btn-warning">Modificar</a>
                        <form action="{{ route('containers.destroy', ['container' => $container->id]) }}" method="POST">
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
@endsection

@section('script') //Metemos el script de los data-tables
<script>
    $(document).ready(function () {
            $('#containers').DataTable();
        });
</script>
@endsection