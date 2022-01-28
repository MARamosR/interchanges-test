@extends('layouts.master')
@section('title') Rutas @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver ruta @endslot
@endcomponent

<div>
    hola
    <object data="{{ public_path('routeInvoces/61f33a57cb1a2_RT_1.pdf') }}" type="application/pdf">
        <iframe src="{{ public_path('routeInvoces/61f33a57cb1a2_RT_1.pdf') . '&embedded=true' }}" title="pdf" width="200" heigth="300"
            frameborder="0" type="application/pdf"></iframe>
    </object>
</div>
@endsection