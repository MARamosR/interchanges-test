@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver rutas @endslot
@endcomponent

<div>
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('routes.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar ruta
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="row">ID</th>
                <th>Lugar de salida</th>
                <th>Fecha de salida</th>
                <th>Destino</th>
                <th>Fecha de llegada</th>
                <th>Descripcion</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@endsection