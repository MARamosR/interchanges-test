@extends('layouts.master')
@section('title') Roles @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar rol @endslot
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
        <input type="submit" value="Agregar rol" class="btn btn-success" id="submit-btn">
    </form>
</div>
@endsection

@section('script')
    <script>
        const submitBtn = document.getElementById('submit-btn');

        window.onload = function() {
            sessionStorage.removeItem('role-store-message');
        }

        const roleSubmitHandler = e => {
            e.preventDefault();
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: "Verifique que los datos sean correctos.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('role-store-message', 'Rol agregado');
                    e.target.parentNode.submit();
                }
            });
        }

        submitBtn.addEventListener('click', roleSubmitHandler);
    </script>
@endsection