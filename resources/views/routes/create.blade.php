@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar ruta @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('routes.store') }}>
        @csrf
        @if (session('message'))
            <div class="alert alert-danger" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @include('routes.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar Ruta">
    </form>
</div>
@endsection