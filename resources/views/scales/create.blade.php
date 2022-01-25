@extends('layouts.master')
@section('title') Escalas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Registrar escala de la ruta "{{ $route->folio }}" @endslot
@endcomponent
<div>
    <p>Ruta:</p>
    {{ $route->descripcion }}

    <p>Contenedores:</p>
    <ol>
        @foreach ($containers as $container)
        <li>{{ $container->placa }}</li>
        @endforeach
    </ol>


    <p>Operador:</p>
    {{ $operator->nombre }} {{ $operator->apellidos }}

    <p>Unidad</p>
    {{ $unit->placa }}

    <p>Equipo de sujecion</p>
    <ol>
        @foreach ($equipment as $item)
        <li>{{ $item->nombre }}</li>
        @endforeach
    </ol>

</div>
@endsection