@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver ruta @endslot
@endcomponent

<div>
    {{ $route }}
    
</div>
@endsection