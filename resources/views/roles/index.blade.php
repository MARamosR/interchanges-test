@extends('layouts.master')
@section('title') Roles @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver Roles @endslot
@endcomponent
<div>
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('roles.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar rol
        </a>
    </div>
</div>
@endsection