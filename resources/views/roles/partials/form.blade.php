<div class="mb-3">
    <label for="name" class="form-label">Nombre del rol:</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', optional($role ?? null)->name) }}">
    <p class="form-text">Asigna un nombre descriptivo (admin, supervisor, etc).</p>
    @error('name')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<label>Permisos disponibles:</label>
<button class="btn btn-primary m-2" id="selectAllBtn">Marcar todos</button>
@foreach ($permissions as $permission)
<div>
    <input type="checkbox" name="permissions[]" value="{{$permission->id}}" id='permission-item'> <label>{{ $permission->description }}</label>
</div>
@endforeach

<script>
    // TODO: Agregar opción para marcar todos los inputs
    const permissionsList = document.querySelectorAll('#permission-item');
    const btn = document.getElementById('selectAllBtn');

    const checkAllInputs = e => {
        e.preventDefault();

        permissionsList.forEach(item => {
            item.checked = true;
        });
    } 

    btn.addEventListener('click', checkAllInputs);
    
</script>