@extends('layouts.master')
@section('title') Contenedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Contenedor no encontrado @endslot
@endcomponent

<div>
    <div class="alert alert-danger" role="alert">
        Oh oh, parace que el contenedor que buscas no existe o ha sido eliminado.
    </div>
    <div class="d-flex justify-content-center">
        <a href={{ route('containers.index') }} class="btn btn-primary m-3">Ver listado de contenedores</a>
        <a href={{ route('dash') }} class="btn btn-secondary m-3">Ir al dashboard</a>
    </div>
</div>
@endsection