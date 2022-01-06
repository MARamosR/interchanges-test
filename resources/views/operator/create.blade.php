@extends('layouts.master')
@section('title') Operadores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar operador @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('operators.store') }}>
        @csrf
        @include('operator.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar Operador">
    </form>
</div>
@endsection