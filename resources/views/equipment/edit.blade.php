@extends('layouts.master')
@section('title') Equipo de sujeción @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Empresa @endslot
@slot('title') Modificar equipo de sujeción @endslot
@endcomponent

<div>
    <form method="POST" action={{ route('equipment.update', ['equipment'=> $equipment->id]) }} enctype="multipart/form-data" >
        @csrf
        @method('PUT')
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
            <input type="text" name="descripcion"
                value="{{ old('descripcion', optional($equipment ?? null)->descripcion) }}" class="form-control">
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
            <label for="precio_unitario" class="form-label">Precio unitario del equipo:</label>
            <input type="number" name="precio_unitario" step="0.01"
                value="{{ old('precio_unitario', optional($equipment ?? null)->precio_unitario) }}"
                class="form-control">
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

        {{-- Imagenes actuales del registro --}}
        <div class="mb-3">
            <label class="form-label">Imagenes actuales:</label>
            <div class="row row-cols-2">
                @forelse ($equipmentImages as $image)
                <div class="col">
                    <div class="card">
                        <img src="{{ $image->image_path }}" class="card-img-top p-4">
                        <div class="card-body">
                            <label>Marque para eliminar la imagen:</label>
                            <input type="checkbox" name="deleteImageIds[]" value="{{ $image->id }}">
                        </div>
                        
                    </div>
                </div>
                @empty
                <div class="bg-light p-3 my-3 rounded-3 text-dark fw-bold">
                    Este registro no cuenta con imagenes
                </div>
                @endforelse
            </div>
        </div>

        <div class="card p-2">
            <div class="mb-3">
                <label class="form-label">Imagenes del equipo de sujecion:</label>
                <div id='equipment-photo-fields'>

                </div>
                <button class="btn btn-primary" id="addEquipmentPhotoBtn">Agregar nueva imagen</button>
                <button class="btn btn-danger" id="removeEquipmentPhotoBtn">Remover imagen</button>
            </div>
            @error('equipment')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <input type="submit" class="btn btn-success" value="Modificar Equipo">
    </form>
</div>
@endsection


<style>
    .invisible {
        display: none;
    }
</style>


@section('script')
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
@endsection