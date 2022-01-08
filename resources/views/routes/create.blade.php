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
        @if (session('containersMessage'))
            <div class="bg-danger p-3 my-3 rounded-3 text-light fw-bold fs-3">
                {{ session('containersMessage') }}
            </div>
        @endif
        @include('routes.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar Ruta">
    </form>
</div>
@endsection