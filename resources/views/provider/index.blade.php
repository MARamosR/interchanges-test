@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver proveedores @endslot
@endcomponent

<div>
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('providers.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar proveedor
        </a>
    </div>

    <table class="table">
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
                    <a href="{{ route('providers.edit', ['provider' => $proveedor->id]) }}" class="btn btn-warning">Modificar</a>
                    <form action="{{ route('providers.destroy', ['provider' => $proveedor->id]) }}" method="POST">
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