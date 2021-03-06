<div class="row row-cols-2">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre(s):</label>
        <input type="text" name="nombre" value="{{ old('nombre', optional($operator ?? null)->nombre) }}"
            class="form-control">
        @error('nombre')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos:</label>
        <input type="text" name="apellidos" class="form-control"
            value="{{ old('apellidos', optional($operator ?? null)->apellidos) }}">
        @error('apellidos')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="telefono" class="form-label">Telefono:</label>
        <input type="tel" name="telefono" class="form-control"
            value="{{ old('telefono', optional($operator ?? null)->telefono) }}">
        @error('telefono')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="no_licencia" class="form-label">Numero de licencia:</label>
        <input type="text" name="no_licencia" class="form-control"
            value="{{ old('no_licencia', optional($operator ?? null)->no_licencia) }}">
        @error('no_licencia')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tipo_licencia" class="form-label">Tipo de licencia:</label>
        {{-- <input type="text" name="tipo_licencia" class="form-control" value="{{ old('tipo_licencia', optional($operator ?? null)->tipo_licencia) }}"> --}}
        <select name="tipo_licencia" class="form-control">
            <option value="" selected disabled>Seleccione el tipo de licencia de este operador</option>
            <option value="A" {{ old('tipo_licencia', optional($operator ?? null)->tipo_licencia) === 'A' ? 'selected' : '' }}>A (Vehiculos particulares)</option>
            <option value="B" {{ old('tipo_licencia', optional($operator ?? null)->tipo_licencia) === 'B' ? 'selected' : '' }}>B (Transporte de carga)</option>
            <option value="C" {{ old('tipo_licencia', optional($operator ?? null)->tipo_licencia) === 'C' ? 'selected' : '' }}>C (Transporte de carga de dos o mas ejes)</option>
            <option value="D" {{ old('tipo_licencia', optional($operator ?? null)->tipo_licencia) === 'D' ? 'selected' : '' }}>D (Transporte de pasajeros)</option>
            <option value="E" {{ old('tipo_licencia', optional($operator ?? null)->tipo_licencia) === 'E' ? 'selected' : '' }}>E (Transporte de carga general y especializada)</option>
        </select>
        @error('tipo_licencia')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_exp" class="form-label">Fecha de otorgamiento de la licencia:</label>
        <input type="date" name="fecha_exp" class="form-control" value="{{ old('fecha_exp', optional($operator ?? null)->fecha_exp) }}">
        @error('fecha_exp')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_venc" class="form-label">Fecha de caducidad de la licencia:</label>
        <input type="date" name="fecha_venc" class="form-control" value="{{ old('fecha_venc', optional($operator ?? null)->fecha_venc) }}">
        @error('fecha_venc')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="lugar_exp" class="form-label">Lugar de otorgamiento de la licencia:</label>
        <input type="text" name="lugar_exp" class="form-control" value="{{ old('lugar_exp', optional($operator ?? null)->lugar_exp) }}">
        @error('lugar_exp')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    {{-- TODO: Cambiar por numero en lugar de date --}}
    <div class="mb-3">
        <label for="antiguedad" class="form-label">Antiguedad del operador:</label>
        <input type="number" name="antiguedad" class="form-control" value="{{ old('antiguedad', optional($operator ?? null)->antiguedad) }}">
        <div class="form-text">Antiguedad en a??os.</div>
        @error('antiguedad')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="iave" class="form-label">IAVE:</label>
        <input type="text" name="iave" class="form-control" value="{{ old('iave', optional($operator ?? null)->iave) }}">
        @error('iave')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ex_medico" class="form-label">Fecha del ultimo examen medico:</label>
        <input type="date" name="ex_medico" class="form-control" value="{{ old('ex_medico', optional($operator ?? null)->ex_medico) }}" >
        @error('ex_medico')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>