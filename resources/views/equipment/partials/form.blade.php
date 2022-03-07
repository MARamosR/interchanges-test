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

<div class="mb-3">
    <label for="ubicacion" class="form-label">Ubicación del equipo:</label>
    <input type="text" name="ubicacion" value="{{ old('ubicacion', optional($equipment ?? null)->ubicacion) }}"
        class="form-control">
    @error('ubicacion')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>


<div class="mb-3">
    <label for="precio_unitario" class="form-label">Precio unitario del equipo (MXN):</label>
    <input type="number" name="precio_unitario" step="0.01"
        value="{{ old('precio_unitario', optional($equipment ?? null)->precio_unitario) }}" class="form-control">
    @error('precio_unitario')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>


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

<div class="card p-2">
    <div class="mb-3">
        <label class="form-label">Imagenes del equipo de sujecion:</label>
        <div id='equipment-photo-fields'>

        </div>
        <button class="btn btn-primary" id="addEquipmentPhotoBtn">Agregar imagen</button>
        <button class="btn btn-danger" id="removeEquipmentPhotoBtn">Remover imagen</button>
    </div>
    @error('equipment')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<style>
    .invisible {
        display: none;
    }
</style>

<script>
    const addPhotoBtn = document.getElementById('addEquipmentPhotoBtn');
        const removePhotoBtn = document.getElementById('removeEquipmentPhotoBtn');
        const photosContainer = document.getElementById('equipment-photo-fields');

        if (photosContainer.childElementCount < 1) {
            removePhotoBtn.classList.add('invisible');
        }

        const addImageField = e => {
            e.preventDefault();
            

            const imageField = document.createElement('input');
            imageField.classList = 'form-control mb-3';
            imageField.setAttribute('name', 'images[]');
            imageField.setAttribute('type', 'file');
            photosContainer.appendChild(imageField);

            if (photosContainer.childElementCount > 0) {
                removePhotoBtn.classList.remove('invisible');
            }
        }

        const removeImageField = e => {
            e.preventDefault();

            const lastField = photosContainer.querySelector('input:last-child');
            lastField.remove();

            if (photosContainer.childElementCount < 1) {
                removePhotoBtn.classList.add('invisible');
            }
        }

        addPhotoBtn.addEventListener('click', addImageField);
        removePhotoBtn.addEventListener('click', removeImageField);
</script>