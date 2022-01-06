@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar unidad @endslot
@endcomponent

{{-- Creamos un arreglo con los años disponibles --}}
<?php $years = range(1900, strftime("%Y", time())); ?>
<div>
    <form method="POST" action={{ route('units.update', ['unit' => $unit->id]) }}>
        @csrf
        @method('PUT')
        @include('unit.partials.form')
        <input type="submit" class="btn btn-success" value="Actualizar">
    </form>
</div>
@endsection