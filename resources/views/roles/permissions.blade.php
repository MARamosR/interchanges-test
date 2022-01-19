@extends('layouts.master')
@section('title') Permisos @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver Permisos @endslot
@endcomponent
<div>

    <table class="table">
        <thead>
            <tr>
                <th scope="row">ID</th>
                <th>Nombre del permiso</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <th scope="row">{{ $permission->id }}</th>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection