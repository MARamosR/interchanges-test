@extends('layouts.master')
@section('title') Unidades @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Empresa @endslot
        @slot('title') Ver unidades @endslot
    @endcomponent
    <div>
        <div class="mb-4  d-flex flex-row-reverse">
            <a class="btn btn-success ml-2 mr-2" href="{{ route('units.create') }}">
                <i class='bx bx-plus'></i>
                Agregar unidad
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Año</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $unit)
                    <tr>
                        <th scope="row">{{ $unit->id }}</th>
                        <td>{{ $unit->placa }}</td>
                        <td>{{ $unit->modelo }}</td>
                        <td>{{ $unit->marca }}</td>
                        <td>{{ $unit->anio }}</td>
                        <td>
                            <a href="{{ route('units.edit', ['unit' => $unit->id]) }}" class="btn btn-warning">Modificar</a>
                            <form action="{{ route('units.destroy', ['unit' => $unit->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger mt-2" value="Eliminar">
                            </form>
                            
                            {{-- <a href="{{ route('units.destroy', ['unit' => $unit->id]) }}" class="btn btn-danger">Borrar</a> --}}
                        </td>
                    </tr>
                    

                @endforeach
            </tbody>

        </table>

    </div>
@endsection
