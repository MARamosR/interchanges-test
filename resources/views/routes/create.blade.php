@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar ruta @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('routes.store') }} enctype="multipart/form-data">
        @csrf
        @if (session('message'))
        <div class="alert alert-danger" role="alert">
            {{ session('message') }}
        </div>
        @endif
        @include('routes.partials.form')
        <input type="submit" class="btn btn-success" value="Agregar ruta" id="storeRouteBtn">
    </form>
</div>
@endsection

<script>
    window.onload = function() {

        sessionStorage.removeItem('route-store-message');

        const storeRouteBtn = document.getElementById('storeRouteBtn');

        const handleConfirmation = e => {
            e.preventDefault();
        
            TemplateSwal.fire({
                title: '¿Esta seguro?',
                text: 'Verifique que los datos sean correctos, una vez registrada una ruta esta ya no se podra modificar hasta la finalización de la misma.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('route-store-message', 'Ruta agregada correctamente');
                    e.target.parentNode.submit();
                }
            });
        }

        storeRouteBtn.addEventListener('click', handleConfirmation);
    }
</script>
