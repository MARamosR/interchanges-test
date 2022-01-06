<div class="mb-3">
    <label for="proveedor" class="form-label">Nombre del proveedor:</label>
    <input type="text" name="proveedor" value="{{ old('proveedor', optional($proveedor ?? null)->proveedor) }}" class="form-control">
    @error('proveedor')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección:</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', optional($proveedor ?? null)->direccion) }}">
    @error('direccion')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="ciudad" class="form-label">Ciudad:</label>
    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', optional($proveedor ?? null)->ciudad) }}">
    @error('ciudad')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Telefono:</label>
    <input type="tel" name="telefono" class="form-control" value="{{ old('telefono', optional($proveedor ?? null)->telefono) }}">
    @error('telefono')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>