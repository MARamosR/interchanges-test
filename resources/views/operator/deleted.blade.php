@extends('layouts.master')
@section('title') Operadores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Operador no encontrado @endslot
@endcomponent

<div>
    <div class="alert alert-danger" role="alert">
        Oh oh, parace que el operador que buscas no existe o ha sido eliminado.
    </div>
    <div class="d-flex justify-content-center">
        <a href={{ route('operators.index') }} class="btn btn-primary m-3">Ver listado de operadores</a>
        <a href={{ route('dash') }} class="btn btn-secondary m-3">Ir al dashboard</a>
    </div>
</div>
@endsection