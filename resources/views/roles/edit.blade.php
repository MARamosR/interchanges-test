@extends('layouts.master')
@section('title') Roles @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar rol @endslot
@endcomponent
<div>
    <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del rol:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', optional($role ?? null)->name) }}">
            <p class="form-text">Asigna un nombre descriptivo (admin, supervisor, etc).</p>
            @error('name')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>

        <label>Permisos disponibles:</label>
        @foreach ($permissions as $permission)
        <div>
            <input type="checkbox" name="permissions[]" 
            {{-- Mostramos los roles seleccionados --}}
            @if (optional($selectedPermissions))
                {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}
            @endif
            value="{{$permission->id}}">
            <label>{{ $permission->description }}</label>
        </div>
        @endforeach

        <button type="submit" class="btn btn-success" id="editRoleBtn">Guardar cambios</button>
    </form>
</div>
@endsection

@section('script')
<script>
    const editRoleBtn = document.getElementById('editRoleBtn');

    window.onload = function() {
        sessionStorage.removeItem('role-edit-message');
    }

    const handleConfirmation = e => {
        e.preventDefault();

        TemplateSwal.fire({
            title: '¿Esta seguro de esto?',
            text: "Verifique que los datos sean correctos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                sessionStorage.setItem('role-edit-message', 'Role editado correctamente');
                e.target.parentNode.submit();
            }
        });

        
    }

    editRoleBtn.addEventListener('click', handleConfirmation);
</script>
@endsection