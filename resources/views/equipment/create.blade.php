@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar equipo de sujeción @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('equipment.store') }} id="equipmentForm" enctype="multipart/form-data">
        @csrf
        @include('equipment.partials.form')
        <button type="submit" class="btn btn-success" id="equipmentSubmitBtn">Agregar Equipo</button>
    </form>
</div>
@endsection

@section('script')
<script>
    const submitBtn = document.getElementById('equipmentSubmitBtn');
    
    window.onload = function() {
        sessionStorage.removeItem('equipment-store-message');
    }

    const submitHandler = e => {
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
                sessionStorage.setItem('equipment-store-message', 'Equipo agregado');
                e.target.parentNode.submit();
            }
        });    


    }

    submitBtn.addEventListener('click', submitHandler);
</script>
@endsection