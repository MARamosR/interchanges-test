@extends('layouts.master')
@section('title') Roles @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver Roles @endslot
@endcomponent
<div>
    @can('roles.create')
    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('roles.create') }}" class="btn btn-success">
            <i class='bx bx-plus'></i>
            Agregar rol
        </a>
    </div>    
    @endcan

    <ul class="list-group" id="roles">
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

@section('script')
<script>
    const rolesList = document.getElementById('roles');

    window.onload = function() {
        if (sessionStorage.getItem('roles-message')) {
            TemplateSwal.fire({
                icon: 'success',
                title: sessionStorage.getItem('roles-message'),
                showConfirmButton: false,
                timer: 2500,
            });
        }

        sessionStorage.removeItem('roles-message');
    }

    const deleteHandler = (e) => {
        
        if (e.target.classList.contains('btn-danger')) {

            // e.target.parentNode es el nodo del formulario
            e.preventDefault();            
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: "Una vez borrado un registro este no se podra recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.setItem('roles-message', 'Registro eliminado');
                        rolesList.removeEventListener('click', deleteHandler);
                        e.target.parentNode.submit();
                    }
                });
        }
    }

    rolesList.addEventListener('click', deleteHandler);
</script>
@endsection