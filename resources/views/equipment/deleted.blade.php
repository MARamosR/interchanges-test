@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Equipo de sujeción no encontrado @endslot
@endcomponent

<div>
    <div class="alert alert-danger" role="alert">
        Oh oh, parace que el equipo de sujeción que buscas no existe o ha sido eliminado.
    </div>
    <div class="d-flex justify-content-center">
        <a href={{ route('equipment.index') }} class="btn btn-primary m-3">Ver listado de equipos de sujeción</a>
        <a href={{ route('dash') }} class="btn btn-secondary m-3">Ir al dashboard</a>
    </div>
</div>
@endsection