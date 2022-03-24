<div class="mb-3">
    <label for="placa" class="form-label">Placa:</label>
    <input type="text" name="placa" value="{{ old('placa', optional($unit ?? null)->placa) }}" class="form-control">
    @error('placa')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="marca" class="form-label">Marca:</label>
    <input type="text" name="marca" class="form-control" value="{{ old('marca', optional($unit ?? null)->marca) }}">
    @error('marca')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="modelo" class="form-label">Modelo:</label>
    <input type="text" name="modelo" class="form-control" value="{{ old('modelo', optional($unit ?? null)->modelo) }}">
    @error('modelo')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="anio" class="form-label">Año:</label>
    <select class="form-control" name="anio">
        @foreach ($years as $year)
            <option value="{{ $year }}" {{ $unitYear == $year ? 'selected' : null }}>{{ $year }}</option>
        @endforeach
    </select>

    @error('anio')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>