@extends('layouts.master')
@section('title') Proveedores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar proveedor @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('providers.update', ['provider' => $proveedor->id]) }}>
        @csrf
        @method('PUT')
        @include('provider.partials.form')
        <button type="submit" class="btn btn-success" id="editProviderBtn">Actualizar proveedor</button>
    </form>
</div>
@endsection

@section('script')
<script>
    const editProviderBtn = document.getElementById('editProviderBtn');

    window.onload = function() {
        sessionStorage.removeItem('provider-update-message');
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
                sessionStorage.setItem('provider-update-message', 'Proveedor actualizado correctamente');
                e.target.parentNode.submit();
            }
        });

        
    }

    editProviderBtn.addEventListener('click', handleConfirmation);
</script>
@endsection