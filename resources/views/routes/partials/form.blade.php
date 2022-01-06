<div class="row row-cols-2">


    <div class="mb-3">
        <label for="salida" class="form-label">Lugar de salida:</label>
        <input type="text" name="salida" value="{{ old('salida', optional($route ?? null)->salida) }}"
            class="form-control">
        @error('salida')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_salida" class="form-label">Fecha de salida:</label>
        <input type="date" name="fecha_salida" class="form-control"
            value="{{ old('fecha_salida', optional($route ?? null)->fecha_salida) }}">
        @error('fecha_salida')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="destino" class="form-label">Lugar de destino:</label>
        <input type="text" name="destino" class="form-control"
            value="{{ old('destino', optional($unit ?? null)->destino) }}">
        @error('destino')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_destino" class="form-label">Fecha de llegada:</label>
        <input type="date" name="fecha_destino" class="form-control"
            value="{{ old('fecha_destino', optional($route ?? null)->fecha_destino) }}">
        @error('fecha_destino')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripcion:</label>
        <input type="text" name="descripcion" class="form-control"
            value="{{ old('descripcion', optional($route ?? null)->descripcion) }}">
        @error('descripcion')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status:</label>
        <select name="status" class="form-select">
            <option value="" selected disabled>Seleccione el estado de la ruta</option>
            <option value="1">Activo</option>
            <option value="2">Finalizado</option>
        </select>
        @error('status')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="unidad" class="form-label">Unidad:</label>
        <select name="unidad" class="form-select">
            <option value="" selected disabled>Seleccione la placa de la unidad de esta ruta</option>
            @foreach ($units as $unit)
            <option value={{ $unit->id }}>{{ $unit->placa }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="operador" class="form-label">Operador:</label>
        <select name="unidad" class="form-select">
            <option value="" selected disabled>Seleccione el operador de esta ruta</option>
            @foreach ($operators as $operator)
                <option value={{ $operator->id }}>{{ $operator->nombre }} {{ $operator->apellidos }}</option>
            @endforeach
        </select>
    </div>
</div>