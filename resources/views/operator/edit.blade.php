@extends('layouts.master')
@section('title') @lang('Operadores') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Editar operador @endslot
@endcomponent
<div>
    <form method="POST" action={{ route('operators.update', ['operator' => $operator->id]) }}>
        @method('PUT')
        @csrf
        @include('operator.partials.form')
        <button type="submit" class="btn btn-success" id="update-btn">Guardar cambios</button>
    </form>
</div>
@endsection

@section('script')
    <script>
        const updateBtn = document.getElementById('update-btn');

        window.onload = function() {
            sessionStorage.removeItem('operator-edit-message');
        }

        const operatorSubmitHandler = e => {
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
                    sessionStorage.setItem('operator-edit-message', 'Cambios del operador guardados');
                    e.target.parentNode.submit();
                }
            });
        }

        updateBtn.addEventListener('click', operatorSubmitHandler);
    </script>
@endsection