@extends('layouts.master')
@section('title') @lang('Operadores') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Bitacora del sistema @endslot
@endcomponent

<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="operators">
                    <thead>
                        <tr>
                            <th scope="row">ID</th>
                            <th>Acción</th>
                            <th>Datos</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <th scope="row">{{ $log->id }}</th>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->data }}</td>
                            <td>{{ $log->user }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection