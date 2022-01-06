@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Modificar contenedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('containers.update', ['container' => $contenedor->id]) }}>
        @csrf
        @method('PUT')
        @include('containers.partials.form')
        <input type="submit" class="btn btn-success" value="Modificar">
    </form>
</div>
@endsection