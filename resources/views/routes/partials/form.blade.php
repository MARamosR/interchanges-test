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
        <label for="destino" class="form-label">Lugar de destino</label>
        <input type="text" name="destino" class="form-control"
            value="{{ old('destino', optional($unit ?? null)->destino) }}">
        @error('destino')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_destino" class="form-label">Fecha de llegada estimada</label>
        <input type="date" name="fecha_destino" class="form-control"
            value="{{ old('fecha_destino', optional($route ?? null)->fecha_destino) }}">
        @error('fecha_destino')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control"
            value="{{ old('descripcion', optional($route ?? null)->descripcion) }}">
        @error('descripcion')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="unidad" class="form-label">Unidad</label>
        <select name="unidad" class="form-select">
            <option value="" selected disabled>Selecciona una unidad por placa</option>
            @foreach ($units as $unit)
            <option value={{ $unit->id }}>{{ $unit->placa }}</option>
            @endforeach
        </select>
        @error('unidad')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="operador" class="form-label">Operador:</label>
        <select name="operador" class="form-select">
            <option value="" selected disabled>Seleccione un operador</option>
            @foreach ($operators as $operator)
            <option value={{ $operator->id }}>{{ $operator->nombre }} {{ $operator->apellidos }}</option>
            @endforeach
        </select>
        @error('operador')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>


</div>

{{-- Contenedores --}}
<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Contenedores disponibles:</label>
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

{{-- Equipo de sujeción --}}
<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Equipo de sujeción disponible:</label>
        <div id='equipment-fields'>

        </div>
        <button class="btn btn-primary" id="addEquipmentBtn">Agregar equipo</button>
        <button class="btn btn-danger" id="removeEquipmentBtn">Remover equipo</button>
    </div>
    @error('equipment')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>


{{-- Imagenes de la ruta --}}
<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Imagenes iniciales de la ruta</label>
        <div id='image-fields'>

        </div>
        <button class="btn btn-primary" id="addImageBtn">Agregar imagen</button>
        <button class="btn btn-danger" id="removeImageBtn">Remover imagen</button>
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
    const equipmentList = <?php echo $equipment?>; //Arreglo desde php.
    
    removeEquipmentBtn.classList.add('invisible');

    if (equipmentList.length < 1) {
        const message = document.createElement('div');
        message.classList = 'bg-light p-3 my-3 rounded-3 text-dark fw-bold';
        message.textContent = 'No hay equipos de sujeción disponibles.';
        equipmentFields.appendChild(message);

        addEquipmentBtn.disabled = true;
        
    }

    const addEquipmentFieldHandler = (e) => {
        e.preventDefault();
        
        if (equipmentList.length > 0) {
            const newField = document.createElement('select');
            newField.classList = 'form-select mb-3 field';
            newField.setAttribute('name', 'equipment[]');

            //Creamos el listado de opciones para el select
            equipmentList.forEach(equipment => {
                newField.innerHTML += `                
                    <option value=${equipment.id}>${equipment.nombre} - ${equipment.folio}</option>
                `;
                
            });
            const textContent = 'Seleccione un equipo de sujeción'
            newField.innerHTML += `<option value="" selected disabled >${textContent}</option>`;
            
            equipmentFields.appendChild(newField);
        }

        if (equipmentFields.children.length > 0) {
            removeEquipmentBtn.classList.remove('invisible');
        }
    }

    const removeEquipmentFieldHandler = (e) => {
        e.preventDefault();

        const lastField = equipmentFields.querySelector('select:last-child');
        lastField.remove();

        if (equipmentFields.children.length < 1) {
            removeEquipmentBtn.classList.add('invisible');
        }
    } 

    addEquipmentBtn.addEventListener('click', addEquipmentFieldHandler);
    removeEquipmentBtn.addEventListener('click', removeEquipmentFieldHandler)
</script>

<script>
    const containerFields = document.getElementById('container-fields');
    const addContainerBtn = document.getElementById('addFieldBtn');
    const removeContainerBtn = document.getElementById('removeFieldBtn');
    const containersList = <?php echo $containers?>; //Arreglo desde php.

    removeContainerBtn.classList.add('invisible');

    if (containersList.length < 1) {
        const message = document.createElement('div');
        message.classList = 'bg-light p-3 my-3 rounded-3 text-dark fw-bold';
        message.textContent = 'No hay contenedores disponibles.';
        containerFields.appendChild(message);

        addContainerBtn.disabled = true;
    }

    const addContainerFieldHandler = (e) => {
        e.preventDefault();

        if (containersList.length > 0) {
            const newField = document.createElement('select');
            newField.classList = 'form-select mb-3 field';
            newField.setAttribute('name', 'contenedores[]');

            containersList.forEach(container => {
                newField.innerHTML += `                
                    <option value=${container.id}>${container.placa}</option>
                `;
            });

            const textContent = 'Seleccione un contenedor';
            newField.innerHTML += `<option value="" selected disabled>${textContent}</option>`

            containerFields.appendChild(newField);
        }

        if (containerFields.children.length > 0) {
            removeContainerBtn.classList.remove('invisible');
        }
    }

    const removeContainerFieldHandler = (e) => {
        e.preventDefault();

        const lastField = containerFields.querySelector('select:last-child');
        lastField.remove();

        if (containerFields.children.length < 1 ) {
            removeContainerBtn.classList.add('invisible');
        }
    }

    addContainerBtn.addEventListener('click', addContainerFieldHandler);
    removeContainerBtn.addEventListener('click', removeContainerFieldHandler);

</script>

<script>
    const addImageBtn = document.getElementById('addImageBtn');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const imagesContainer = document.getElementById('image-fields');

    if (imagesContainer.children.length < 1) {
        removeImageBtn.classList.add('invisible');
    }

    const addImageFieldHandler = e => {
        e.preventDefault();
        const imageField = document.createElement('input');
        imageField.setAttribute('name', 'images[]');
        imageField.setAttribute('type', 'file');
        imageField.classList = 'form-control mb-2';
        imagesContainer.appendChild(imageField);

        if (imagesContainer.children.length > 0) {
            removeImageBtn.classList.remove('invisible');
        }
    }

    const removeImageFieldHandler = e => {
        e.preventDefault();
     
        const lastField = imagesContainer.querySelector('input:last-child');
        lastField.remove();        

        if (imagesContainer.children.length < 1) {
            removeImageBtn.classList.add('invisible');
        }
    }

    addImageBtn.addEventListener('click', addImageFieldHandler);
    removeImageBtn.addEventListener('click', removeImageFieldHandler);

</script>