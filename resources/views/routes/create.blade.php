@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') @lang('routesCreate.add_route') @endslot
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
        <input type="submit" class="btn btn-success" value="@lang('routesCreate.route_create_add_route_btn')" id="storeRouteBtn">
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
                title: '¿Esta seguro de esto?',
                text: "Verifique que los datos sean correctos, una vez registrada una ruta sus datos ya no podran ser alterados hasta el termino de la misma.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('route-store-message', 'Ruta agregada');
                    e.target.parentNode.submit();
                }
            });
        }

        storeRouteBtn.addEventListener('click', handleConfirmation);
    }
</script>