<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del equipo:</label>
    <input type="text" name="nombre" value="{{ old('nombre', optional($equipment ?? null)->nombre) }}"
        class="form-control">
    @error('nombre')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción del equipo:</label>
    <input type="text" name="descripcion" value="{{ old('descripcion', optional($equipment ?? null)->descripcion) }}"
        class="form-control">
    @error('descripcion')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

{{-- TODO: AGREGAR LA FOTO/S DEL EQUIPO --}}
<div class="mb-3">
    <label for="precio_unitario" class="form-label">Precio unitario del equipo:</label>
    <input type="number" name="precio_unitario" step="0.01"
        value="{{ old('precio_unitario', optional($equipment ?? null)->precio_unitario) }}" class="form-control">
    @error('precio_unitario')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

{{-- <div class="mb-3">
    <label for="activo" class="form-label">Estado del equipo:</label>
    <select name="activo" value="{{ old('activo', optional($equipment ?? null)->activo) }}" class="form-control">
        <option value="" selected disabled>Seleccione el estado del equipo</option>
        <option value="1" {{ old('activo', optional($equipment ?? null)->activo) == 1 ? 'selected' : '' }} >En Uso</option>
        <option value="2" {{ old('activo', optional($equipment ?? null)->activo) == 2 ? 'selected' : '' }} >Disponible</option>
    </select>

    @error('activo')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div> --}}

<div class="mb-3">
    <label for="id_proveedor" class="form-label">Proveedor del equipo:</label>
    <select name="id_proveedor" class="form-control">

        @if ($provider != null)
            <option selected value="{{ $provider[0]->id }}">{{ $provider[0]->proveedor }}</option>          
        @else
            <option value="" selected disabled>Selecciona al proveedor del equipo</option>    
        @endif
        
        @foreach ($providers as $provider)
            <option value="{{ $provider->id }}">{{ $provider->proveedor }}</option>
        @endforeach
    </select>

    @error('id_proveedor')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>



{{-- TODO: AGREGAR FOLIO --}}
{{-- <div class="mb-3">
    <label for="precio_unitario" class="form-label">Descripción del equipo:</label>
    <input type="number" name="precio_unitario"
        value="{{ old('precio_unitario', optional($equipment ?? null)->precio_unitario) }}" class="form-control">
    @error('precio_unitario')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div> --}}