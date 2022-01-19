@extends('layouts.master')
@section('title') Roles @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Crear rol @endslot
@endcomponent
<div>
    @if (session('roleMessage'))
        <div class="alert alert-success p-2 mb-3" id="roleMessage">
            {{ session('roleMessage') }}
        </div>
    @endif
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        @include('roles.partials.form')
        <input type="submit" value="Agregar rol" class="btn btn-success">
    </form>
</div>
@endsection