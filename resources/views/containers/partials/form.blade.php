<div class="row row-cols-2">
    <div class="mb-3">
        <label for="serie" class="form-label">Serie:</label>
        <input type="text" name="serie" value="{{ old('serie', optional($contenedor ?? null)->serie) }}"
            class="form-control">
        @error('serie')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="marca" class="form-label">Marca:</label>
        <input type="text" name="marca" value="{{ old('marca', optional($contenedor ?? null)->marca) }}"
            class="form-control">
        @error('marca')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="modelo" class="form-label">Modelo:</label>
        <input type="text" name="modelo" value="{{ old('modelo', optional($contenedor ?? null)->modelo) }}"
            class="form-control">
        @error('modelo')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="placa" class="form-label">Placa:</label>
        <input type="text" name="placa" value="{{ old('placa', optional($contenedor ?? null)->placa) }}"
            class="form-control">
        @error('placa')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="comentario" class="form-label">Comentario:</label>
        <input type="text" name="comentario" value="{{ old('comentario', optional($contenedor ?? null)->comentario) }}"
            class="form-control">
        @error('comentario')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="placa_mx" class="form-label">Placa Mexicana:</label>
        <input type="text" name="placa_mx" value="{{ old('placa_mx', optional($contenedor ?? null)->placa_mx) }}"
            class="form-control">
        @error('placa_mx')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="placa_ant" class="form-label">Placa anterior:</label>
        <input type="text" name="placa_ant" value="{{ old('placa_ant', optional($contenedor ?? null)->placa_ant) }}"
            class="form-control">
        @error('placa_ant')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ubicacion" class="form-label">Ubicación:</label>
        <input type="text" name="ubicacion" value="{{ old('ubicacion', optional($contenedor ?? null)->ubicacion) }}"
            class="form-control">
        @error('ubicacion')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="riel_logistico" class="form-label">Riel logistico:</label>
        <input type="text" name="riel_logistico"
            value="{{ old('riel_logistico', optional($contenedor ?? null)->riel_logistico) }}" class="form-control">
        @error('riel_logistico')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="canastilla" class="form-label">Canastilla:</label>
        <input type="text" name="canastilla" value="{{ old('canastilla', optional($contenedor ?? null)->canastilla) }}"
            class="form-control">
        @error('canastilla')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tipo_placa" class="form-label">Tipo de placa:</label>
        <input type="text" name="tipo_placa" value="{{ old('tipo_placa', optional($contenedor ?? null)->tipo_placa) }}"
            class="form-control">
        @error('tipo_placa')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="propietario" class="form-label">Propietario:</label>
        <input type="text" name="propietario"
            value="{{ old('propietario', optional($contenedor ?? null)->propietario) }}" class="form-control">
        @error('propietario')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ancho" class="form-label">Ancho:</label>
        <input type="number" step="0.01" name="ancho" value="{{ old('ancho', optional($contenedor ?? null)->ancho) }}"
            class="form-control">
        <p class="form-text">Medida en metros</p>
        @error('ancho')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="largo" class="form-label">Largo:</label>
        <input type="number" step="0.01" name="largo" value="{{ old('largo', optional($contenedor ?? null)->largo) }}"
            class="form-control">
        <p class="form-text">Medida en metros</p>
        @error('largo')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="alto" class="form-label">Alto:</label>
        <input type="number" step="0.01" name="alto" value="{{ old('alto', optional($contenedor ?? null)->alto) }}"
            class="form-control">
        <p class="form-text">Medida en metros</p>
        @error('alto')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="llanta" class="form-label">Llanta:</label>
        <input type="text" name="llanta" value="{{ old('llanta', optional($contenedor ?? null)->llanta) }}"
            class="form-control">
        @error('llanta')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="llanta_status" class="form-label">Estado de la llanta:</label>
        <input type="text" name="llanta_status"
            value="{{ old('llanta_status', optional($contenedor ?? null)->llanta_status) }}" class="form-control">
        @error('llanta_status')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tipo_caja" class="form-label">Tipo de caja:</label>
        <input type="text" name="tipo_caja" value="{{ old('tipo_caja', optional($contenedor ?? null)->tipo_caja) }}"
            class="form-control">
        @error('tipo_caja')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>