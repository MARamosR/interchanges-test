@extends('layouts.master')
@section('title') Roles @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver Roles @endslot
@endcomponent
<div>
    @if (session('message'))
    <div class="alert alert-success p-2 mb-3 d-flex justify-content-between">
        {{ session('message') }}        
    </div>
    @endif

    @can('roles.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('roles.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar rol
        </a>
    </div>    
    @endcan

    <ul class="list-group">
        @foreach ($roles as $role)
            <li class="list-group-item d-flex justify-content-between">
                <p class="fs-5 ">{{ $role->name }}</p>
                <div>
                    <a class="btn btn-warning" href="{{ route('roles.edit', ['role' => $role->id]) }}" >Editar</a>
                    <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST" >
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Eliminar" class="btn btn-danger mt-2">
                    </form>
                </div>
                
            </li>
        @endforeach
    </ul>
</div>
@endsection