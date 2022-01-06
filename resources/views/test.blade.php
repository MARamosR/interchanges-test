@extends('layouts.master')
@section('title') @lang('translation.Test') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Skote @endslot
@slot('title') Test Page @endslot
@endcomponent
<div>
    <p>hola desde test</p>
</div>
@endsection