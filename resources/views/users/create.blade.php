@extends('layouts.master')
@section('title') Usuarios @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Agregar usuario @endslot
@endcomponent

<div>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @include('users.partials.form')
        <button type="submit" class="btn btn-success" id="userSubmitBtn">Agregar usuario</i></button>
    </form>
</div>
@endsection

@section('script')
    <script>
        const userSubmitBtn = document.getElementById('userSubmitBtn');

        window.onload = function() {
            sessionStorage.removeItem('user-store-message');
        }

        const userSubmitHandler = e => {
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
                    sessionStorage.setItem('user-store-message', 'Usuario agregado');
                    e.target.parentNode.submit();
                }
            });
        }

        userSubmitBtn.addEventListener('click', userSubmitHandler);
    </script>
@endsection