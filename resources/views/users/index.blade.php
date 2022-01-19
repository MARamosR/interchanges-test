@extends('layouts.master')
@section('title') Usuarios @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Ver usuarios @endslot
@endcomponent

<div>
    @can('users.create')
    <div class="mb-4  d-flex flex-row-reverse">
        <a class="btn btn-success ml-2 mr-2" href="{{ route('users.create') }}">
            <i class='bx bx-plus'></i>
            Agregar usuario
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-body">


            <table class="table" id="users">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                class="btn btn-warning">Editar</a>
                            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger mt-2">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script') //Metemos el script de los data-tables
<script>
    $(document).ready(function () {
            $('#users').DataTable();
        });
</script>
@endsection