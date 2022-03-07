@extends('layouts.master')
@section('title') Proveedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar proveedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('providers.store') }}>
        @csrf
        @include('provider.partials.form')
        <button type="submit" class="btn btn-success" id="providerStoreBtn">Agregar proveedor</button>
    </form>
</div>
@endsection

@section('script')
<script>
    const providerStoreBtn = document.getElementById('providerStoreBtn');

    window.onload = function() {
        sessionStorage.removeItem('provider-store-message');
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
                sessionStorage.setItem('provider-store-message', 'Proveedor agregado');
                e.target.parentNode.submit();
            }
        });

        
    }

    providerStoreBtn.addEventListener('click', handleConfirmation);
</script>
@endsection