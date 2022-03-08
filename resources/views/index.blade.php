@extends('layouts.master')
@section('title') @lang('translation.Dashboards') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Dashboard @endslot
@endcomponent

<div class="row container-fluid">
    <div class="col-xl-4">
        <h2>@yield('page-title')</h2>
    </div>
</div>

<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-primary font-size-22">
                                    <i class='bx bxs-map-alt'></i>
                                </span>
                            </div>
                        </div>


                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Rutas registradas</h5>
                            <div class="card-text text-dark">{{ $routesQty }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-primary font-size-22">
                                    <i class="bx bxs-group"></i>
                                </span>
                            </div>
                        </div>


                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Operadores registrados</h5>
                            <div class="card-text">{{ $operatorsQty }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-primary font-size-22">
                                    <i class='bx bxs-truck'></i>
                                </span>
                            </div>
                        </div>


                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Unidades registradas</h5>
                            <div class="card-text">{{ $unitsQty }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-primary font-size-22">
                                    <i class='bx bxs-package'></i>
                                </span>
                            </div>
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Contenedores registrados</h5>
                            <div class="card-text">{{ $containersQty }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-primary font-size-22">
                                    <i class='bx bx-link'></i>
                                </span>
                            </div>
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Equipo de sujeción registrado</h5>
                            <div class="card-text">{{ $equipmentQty }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-primary font-size-22">
                                    <i class='bx bxs-user-rectangle'></i>
                                </span>
                            </div>
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Proveedores registrados</h5>
                            <div class="card-text">{{ $providersQty }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center ">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-md">
                                <span class="avatar-title rounded-circle bg-danger font-size-22">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </span>
                            </div>
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title">Equipo de sujeción extraviado</h5>
                            <div class="card-text">Total de equipos extraviados: {{ $lostEquipmentQty }}</div>
                            <div class="card-text">Monto total de equipos perdidos: ${{ $lostEquipmentTotal }} MXN</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection