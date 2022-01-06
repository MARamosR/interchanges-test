@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar contenedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('containers.store') }}>
        @csrf
        @include('containers.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar">
    </form>
</div>
@endsection