@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Equipo eliminado @endslot
@endcomponent

<div>
    <div class="alert alert-danger" role="alert">
        Oh oh, parace que el equipo de sujeción que buscas ha sido eliminado.
    </div>
    <div class="d-flex justify-content-center">
        <a href={{ route('operators.index') }} class="btn btn-primary m-3">Volver a los operadores</a>
        <a href={{ route('dash') }} class="btn btn-secondary m-3">Ir al dashboard</a>
    </div>
</div>
@endsection