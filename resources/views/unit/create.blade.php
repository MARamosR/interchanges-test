@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar unidad @endslot
@endcomponent

{{-- Creamos un arreglo con los años disponibles --}}
<?php $years = range(1900, strftime("%Y", time())); ?>
<div>
    <form method="POST" action={{ route('units.store') }}>
        @csrf
        @include('unit.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar">
    </form>
</div>
@endsection