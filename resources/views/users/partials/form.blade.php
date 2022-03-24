<div class="mb-3">
    <label for="name">Nombre de usuario:</label>
    <input type="text" class="form-control" name="name" value="{{ old('name', optional($user ?? null)->name) }}">
    @error('name')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="email">Correo electronico del usuario:</label>
    <input type="text" class="form-control" name="email" value="{{ old('email', optional($user ?? null)->email) }}">
    @error('email')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="password">Contraseña de usuario:</label>
    <input type="text" class="form-control" name="password" value="{{ old('password', optional($user ?? null)->password) }}">
    @error('password')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="role">Rol:</label>
    <select name="role" class="form-control">
        <option value="" selected disabled>Selecciona un rol para este usuario</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>
    @error('role')
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>