@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar proveedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('providers.store') }}>
        @csrf
        @include('provider.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar Proveedor">
    </form>
</div>
@endsection