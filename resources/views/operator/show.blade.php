@extends('layouts.master')
@section('title') Operadores @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver operador @endslot
@endcomponent


<div class="row">
    <div class="card">
        <div class="card-body">

            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15">Folio: {{ $operator->folio }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="text-truncate mb-3">Detalles:</h5>
            <div class="row row-cols-2">

                <div class="mb-3">
                    <h5 class="text-truncate">Nombre: {{ $operator->nombre }} {{ $operator->apellidos }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Telefono: {{ $operator->telefono }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Numero de licencia: {{ $operator->no_licencia }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Tipo licencia: {{ $operator->tipo_licencia }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Fecha de expedición de la licencia: {{ $operator->fecha_exp }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Lugar de expedición de la licencia: {{ $operator->lugar_exp }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Fecha de vencimiento de la licencia: {{ $operator->fecha_venc }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Antiguedad del operador: {{ $operator->antiguedad }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">IAVE del operador: {{ $operator->iave }}</h5>
                </div>

                <div class="mb-3">
                    <h5 class="text-truncate">Fecha del ultimo examen medico: {{ $operator->ex_medico }}</h5>
                </div>


                <div class="mb-3">
                    <h5 class="text-truncate">Status:
                        @if ($operator->status === 0)
                        <span class="badge bg-success p-1">Disponible</span>
                        @endif

                        @if ($operator->status === 1)
                        <span class="badge bg-warning p-1">En ruta</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="text-truncate mb-3">Equipos de sujeción extraviados:</h5>
            @if (count($lostEquipments) > 0)
            <ul>
                @foreach ($lostEquipments as $lostEquipment)
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div>
                        {{ $lostEquipment->nombre }} - {{ $lostEquipment->folio }}
                        <div>
                            @if ($lostEquipment->pagado)
                            <span class="badge bg-success p-1 fs-6 mt-2">Pagado</span>
                            @else
                            <span class="badge bg-warning p-1 fs-6 mt-2">Pago pendiente</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href={{ route('equipment.show', ['equipment'=> $lostEquipment->id]) }} class="btn">Ver
                            equipo</a>
                        @if (!$lostEquipment->pagado)
                        <form
                            action="{{ route('operators.equipmentPay', ['operator' => $operator->id, 'equipment' => $lostEquipment->id]) }}"
                            method="POST">
                            @csrf
                            <button class="btn btn-success" id="paymentBtn">Pagar</button>
                        </form>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                El operador no tiene ningun adeudo.
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    window.onload = function() {
        
    }
    const submitBtn = document.getElementById('paymentBtn');

        const submitHandler = e => {
            e.preventDefault();
            
            TemplateSwal.fire({
                title: '¿Esta seguro de esto?',
                text: "Verifique que el pago se pueda realizar con exito. Una vez hecho un pago este ya no se podra revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('equipment-payment-message', 'Equipo pagado');
                    e.target.parentNode.submit();
                }
            });
        }

        submitBtn.addEventListener('click', submitHandler);
    
</script>    
@endsection
