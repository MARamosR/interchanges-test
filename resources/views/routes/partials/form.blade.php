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

    {{-- <div class="mb-3">
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
    </div> --}}

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
        <select name="operador" class="form-select">
            <option value="" selected disabled>Seleccione el operador de esta ruta</option>
            @foreach ($operators as $operator)
            <option value={{ $operator->id }}>{{ $operator->nombre }} {{ $operator->apellidos }}</option>
            @endforeach
        </select>
    </div>

</div>

{{-- Contenedores --}}
<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Placas de los contenedores que se usarán en esta ruta:</label>
        <div id='container-fields'>

        </div>
        <button class="btn btn-primary" id="addFieldBtn">Agregar contenedor</button>
        <button class="btn btn-danger" id="removeFieldBtn">Remover contenedor</button>
    </div>
    @error('contenedores')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

{{-- Equipo de sujecion --}}
<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Equipo de sujecion que se usará en esta ruta:</label>
        <div id='equipment-fields'>

        </div>
        <button class="btn btn-primary" id="addEquipmentBtn">Agregar equipo</button>
        <button class="btn btn-danger" id="removeEquipmentBtn">Remover equipo</button>
    </div>
</div>

<style>
    .invisible {
        display: none;
    }
</style>

<script>
    const equipmentFields = document.getElementById('equipment-fields');
    const addEquipmentBtn = document.getElementById('addEquipmentBtn');
    const removeEquipmentBtn = document.getElementById('removeEquipmentBtn');
    
    removeEquipmentBtn.classList.add('invisible');

    const addEquipmentFieldHandler = (e) => {
        e.preventDefault();
        
        if ((equipmentFields.children.length + 1) > 0) {
            removeEquipmentBtn.classList.remove('invisible');
        }

        const equipmentList = <?php echo $equipment?>;
        
        //TODO: VALIDAR EL CASO EN DONDE NO EXISTAN EQUIPOS DE SUJECION PARA AÑADIR A LA RUTA.
        if (equipmentList.length > 0) {
            const newField = document.createElement('select');
            newField.classList = 'form-select mb-3 field';
            newField.setAttribute('name', 'equipment[]');

            equipmentList.forEach(equipment => {
                newField.innerHTML += `                
                    <option value=${equipment.id}>${equipment.nombre}</option>
                `;
                equipmentFields.appendChild(newField);
            });
        }
    }

    const removeEquipmentFieldHandler = (e) => {
        e.preventDefault();

        const lastField = equipmentFields.querySelector('select:last-child');
        lastField.remove();
    } 

    addEquipmentBtn.addEventListener('click', addEquipmentFieldHandler);
    removeEquipmentBtn.addEventListener('click', removeEquipmentFieldHandler)
</script>

<script>
    const containerFields = document.getElementById('container-fields');
    const addContainerBtn = document.getElementById('addFieldBtn');
    const removeContainerBtn = document.getElementById('removeFieldBtn');

    removeContainerBtn.classList.add('invisible');

    const addContainerFieldHandler = (e) => {
        e.preventDefault();

        if ((containerFields.children.length + 1) > 0) {
            removeContainerBtn.classList.remove('invisible');
        }

        const containersList = <?php echo $containers?>;
        
        //TODO: VALIDAR EL CASO EN DONDE NO EXISTAN CONTENEDORES PARA AÑADIR A LA RUTA.
        if (containersList.length > 0) {
            const newField = document.createElement('select');
            newField.classList = 'form-select mb-3 field';
            newField.setAttribute('name', 'contenedores[]');

            containersList.forEach(container => {
                console.log(container.id);
                newField.innerHTML += `                
                    <option value=${container.id}>${container.placa}</option>
                `;

                containerFields.appendChild(newField);
            });
        }

    }

    const removeContainerFieldHandler = (e) => {
        e.preventDefault();

        const lastField = containerFields.querySelector('select:last-child');
        lastField.remove();
    }

    

    addContainerBtn.addEventListener('click', addContainerFieldHandler);
    removeContainerBtn.addEventListener('click', removeContainerFieldHandler);

</script>