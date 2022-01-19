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

{{-- Equipo de sujeción --}}
<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Equipo de sujeción que se usará en esta ruta:</label>
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

{{-- <div id="vue">

</div> --}}

@section('script')
<script>
    const app = Vue.createApp({
        template: `
            <route-form></route-form>
        `,
        components: ['route-form']
    });
        
        app.component('route-form', {
            template: `
                <div class="row row-cols-2">
                    <div class="mb-3">
                        <label for="salida" class="form-label">Lugar de salida:</label>
                        <input type="text" name="salida" class="form-control">    
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_salida" class="form-label">Fecha de salida:</label>
                        <input type="date" name="fecha_salida" class="form-control">    
                    </div>

                    <div class="mb-3">
                        <label for="destino" class="form-label">Lugar de salida:</label>
                        <input type="text" name="destino" class="form-control">    
                    </div>

                    <div class="mb-3">
                        <label for="fecha_destino" class="form-label">Fecha de llegada:</label>
                        <input type="date" name="fecha_destino" class="form-control">    
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la ruta:</label>
                        <input type="text" name="descripcion" class="form-control">    
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
                        <select name="operador" class="form-select">
                            <option value="" selected disabled>Seleccione el operador de esta ruta</option>
                            @foreach ($operators as $operator)
                            <option value={{ $operator->id }}>{{ $operator->nombre }} {{ $operator->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card p-2">
                    <div class="mb-3">
                        <label class="form-label">Contenedores que se usarán en esta ruta:</label>
                        <div>
                            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold" v-if="containerFields.length === 0 && containersArray.length > 0" >
                                Agregue un contenedor
                            </div>
                            <div v-if="containersArray.length === 0" >
                                No hay contenedores disponibles
                            </div>

                            <container-field v-for="field in containerFields" :key="field"/>
                        </div> 
                        
                        <button class="btn btn-primary" @click.prevent="addContainerField" :disabled="containersArray.length < 1">
                            Agregar contenedor
                            <i class="fas fa-plus"></i>
                        </button>
                        
                        <button class="btn btn-danger mx-3" @click.prevent="removeContainerField" v-if="containerFields.length > 0">
                            Remover contenedor
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card p-2">
                    <div class="mb-3">
                        <label class="form-label">Equipo de sujeción que se usará en esta ruta:</label>
                        <div>
                            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold" v-if="equipmentFields.length === 0 && equipmentArray.length > 0" >
                                Agregue equipo de sujeción
                            </div>
                            <div v-if="equipmentArray.length === 0" class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                                No hay equipo de sujeción disponible
                            </div>

                            <equipment-field v-for="field in equipmentFields" :key="field"/>
                        </div> 
                        
                        <button class="btn btn-primary" @click.prevent="addEquipmentField" :disabled="equipmentArray < 1">
                            Agregar equipo
                            <i class="fas fa-plus"></i>
                        </button>
                        
                        <button class="btn btn-danger mx-3" @click.prevent="removeEquipmentField" v-if="equipmentFields.length > 0">
                            Remover equipo
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card p-2">
                    <div class="mb-3">
                        <label class="form-label">Evidencia de montaje (imagenes):</label>
                        <div>
                            <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold" v-if="photoFields.length === 0" >
                                Agregue una imagen como evidencia del montaje 
                            </div>

                            <photo-field v-for="field in photoFields" :key="field"/>
                        </div> 
                        
                        <button class="btn btn-primary" @click.prevent="addPhotoField">
                            Agregar imagen
                            <i class="fas fa-plus"></i>
                        </button>
                        
                        <button class="btn btn-danger mx-3" @click.prevent="removePhotoField" v-if="photoFields.length > 0">
                            Remover imagen
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>                
            `,
            components: ['container-field', 'equipment-field', 'photo-field'],
            data() {
                return {
                    containersArray: <?php echo $containers?>,
                    equipmentArray: <?php echo $equipment?>,
                    containerFields: [],
                    equipmentFields: [],
                    photoFields: []
                }
            },
            methods: {
                addContainerField() {
                    this.containerFields.push(1);
                },
                removeContainerField() {
                    this.containerFields.pop();
                },
                addEquipmentField() {
                    this.equipmentFields.push(1);
                },
                removeEquipmentField() {
                    this.equipmentFields.pop();
                },
                addPhotoField() {
                    this.photoFields.push(1);
                },
                removePhotoField() {
                    this.photoFields.pop();
                }
            }
        });

        app.component('container-field', {
            template: `
                <select class="form-select mb-3 field" name="contenedores[]">
                    <option selected disabled value="">-- Seleccione un contenedor --</option>
                    @foreach ($containers as $container)
                    <option value={{ $container->id }}>{{ $container->placa }}</option>
                    @endforeach
                </select>
            `
        });

        app.component('equipment-field', {
            template: `
                <select class="form-select mb-3 field" name="equipment[]">
                    <option selected disabled value="">-- Seleccione el equipo de sujeción --</option>
                    @foreach ($equipment as $eq)
                    <option value={{ $eq->id }}>{{ $eq->nombre }}</option>
                    @endforeach
                </select>
            `
        });

        app.component('photo-field', {
            template: `
                <input type="file" name="photo" class="form-control my-3"/>
            `
        })
        
        app.mount('#vue');
</script>
@endsection

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
        message.textContent = 'No hay equipo de sujeción disponible';
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
                    <option value=${equipment.id}>${equipment.nombre}</option>
                `;
                
            });
            //TODO: VER SI FUNCIONA
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
        message.textContent = 'No hay contenedores disponibles';
        containerFields.appendChild(message);

        addContainerBtn.disabled = true;
    }

    const addContainerFieldHandler = (e) => {
        e.preventDefault();

        
        //TODO: VALIDAR EL CASO EN DONDE NO EXISTAN CONTENEDORES PARA AÑADIR A LA RUTA.
        if (containersList.length > 0) {
            const newField = document.createElement('select');
            newField.classList = 'form-select mb-3 field';
            newField.setAttribute('name', 'contenedores[]');

            containersList.forEach(container => {
                newField.innerHTML += `                
                    <option value=${container.id}>${container.placa}</option>
                `;
            });

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