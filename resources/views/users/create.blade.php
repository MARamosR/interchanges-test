@extends('layouts.master')
@section('title') Usuarios @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar usuario @endslot
@endcomponent

<div>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @include('users.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar usuario">
    </form>
</div>
@endsection