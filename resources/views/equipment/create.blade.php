@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar equipo de sujeción @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('equipment.store') }} id="equipmentForm">
        @csrf
        @include('equipment.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar Equipo" id="equipmentSubmitBtn">
    </form>
</div>
@endsection