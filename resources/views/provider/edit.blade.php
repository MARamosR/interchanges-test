@extends('layouts.master')
@section('title') Proveedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar proveedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('providers.update', ['provider' => $proveedor->id]) }}>
        @csrf
        @method('PUT')
        @include('provider.partials.form')
        <input type="submit" class="btn btn-success" value="Actualizar Proveedor">
    </form>
</div>
@endsection