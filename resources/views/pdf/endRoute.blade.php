<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('/assets/css/pdfs.css') }}" type="text/css">
    {{--
    <link href="{{ public_path('/assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" /> --}}
    <title>Ruta finalizada - {{ $route->folio }}</title>
</head>

<body>
    <header class="clearfix">
        <h1>SAISE-T</h1>
        <p>Sistema de trazabilidad de equipo</p>
        <p>Registro de finalización de la ruta: {{ $route->folio }}</p>
        <p class="date">Fecha de registro: {{ date('d/m/Y') }}</p>
    </header>

    <div class="route__info">
        <h2>Encargado del registro:</h2>
        <hr>
        <p>Nombre: {{ auth()->user()->name }}</p>
        <p>Correo de contacto: {{ auth()->user()->email }}</p>
    </div>

    <div class="route__info">
        <h2>Operador asignado a esta ruta:</h2>
        <hr>
        <table class="table-grid">
            <tbody>
                <tr>
                    <td>Nombre: {{ $operator->nombre }} {{ $operator->apellidos }}</td>
                    <td>Telefono: {{ $operator->telefono }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="route__info">
        <h2>Unidad asignada a esta ruta:</h2>
        <hr>
        <table class="table-grid">
            <tbody>
                <tr>
                    <td>Placa: {{ $unit->placa }}</td>
                    <td>Marca: {{ $unit->marca }}</td>
                </tr>
                <tr>
                    <td>Modelo: {{ $unit->modelo }}</td>
                    <td>Año: {{ $unit->anio }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="route__containers">
        <h2>Contenedores asignados a esta ruta ({{ $containersQty }}):</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($containers as $container)
                <tr>
                    <td>{{ $container->folio }}</td>
                    <td>{{ $container->placa }}</td>
                    <td>{{ $container->modelo }}</td>
                    <td>{{ $container->marca }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="route__equipment">
        <h2>Equipo de sujeción asignado a esta ruta ({{ $equipmentQty }}) :</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Equipo</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($equipment as $eqp)
                <tr>
                    <td>{{ $eqp->folio }}</td>
                    <td>{{ $eqp->nombre }}</td>
                    <td>${{ $eqp->precio_unitario }} MXN</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="route__equipment__total">
            <p>Total: ${{ $equipmentTotal }} MXN</p> 
        </div>
    </div>

    @if ($lostEquipmentQty > 0)
    <div class="route__equipment">
        <h2>Equipo de sujeción extraviado en esta ruta ({{ $lostEquipmentQty }}):</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Equipo</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lostEquipmentArr as $lostEq)
                <tr>
                    <td>{{ $lostEq->folio }}</td>
                    <td>{{ $lostEq->nombre }}</td>
                    <td>${{ $lostEq->precio_unitario }} MXN</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="route__equipment__total">
            <p>Total: ${{ $lostEquipmentTotal }} MXN</p> 
        </div>        
    </div>    
    @endif
    
</body>

</html>