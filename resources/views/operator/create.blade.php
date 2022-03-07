@extends('layouts.master')
@section('title') Operadores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar operador @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('operators.store') }}>
        @csrf
        @include('operator.partials.form')
        <button type="submit" class="btn btn-success" id="addOperatorBtn">Agregar Operador</button>
    </form>
</div>
@endsection

@section('script')
    <script>
        const addBtn = document.getElementById('addOperatorBtn');

        window.onload = function() {
            sessionStorage.removeItem('operator-add-message');
        }

        const submitHandler = e => {
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
                    sessionStorage.setItem('operator-add-message', 'Operador agregado');
                    e.target.parentNode.submit();
                }
            });
        }

        addBtn.addEventListener('click', submitHandler);
        
    </script>
@endsection