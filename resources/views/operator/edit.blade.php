@extends('layouts.master')
@section('title') @lang('Operadores') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Modificar operador @endslot
@endcomponent
<div>
    <form method="POST" action={{ route('operators.update', ['operator' => $operator->id]) }}>
        @method('PUT')
        @csrf
        @include('operator.partials.form')
        <input type="submit" class="btn btn-success" value="Guardar cambios">
    </form>
</div>
@endsection