@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Unidad no encontrada @endslot
@endcomponent

<div>
    <div class="alert alert-danger" role="alert">
        Oh oh, parace que la unidad que buscas no existe o ha sido eliminado.
    </div>
    <div class="d-flex justify-content-center">
        <a href={{ route('units.index') }} class="btn btn-primary m-3">Ver listado de unidades</a>
        <a href={{ route('dash') }} class="btn btn-secondary m-3">Ir al dashboard</a>
    </div>
</div>
@endsection