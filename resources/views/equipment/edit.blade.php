@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Modificar equipo de sujeción @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('equipment.update', ['equipment' => $equipment->id]) }}>
        @csrf
        @method('PUT')
        @include('equipment.partials.form')
        <input type="submit" class="btn btn-success" value="Modificar Equipo">
    </form>
</div>
@endsection