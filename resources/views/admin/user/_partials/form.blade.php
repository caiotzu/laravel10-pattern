@csrf

<div class="col-span-12 md:col-span-4 p-2">
  <label for="name" class="form-label">Nome <span class="text-red-500">*</span></label>
  <input id="name" name="name" type="text" class="form-control w-full py-2.5" value="{{ old('name', $user->name ?? '') }}">
</div>

<div class="col-span-12 md:col-span-4 p-2">
  <label for="email" class="form-label">E-mail <span class="text-red-500">*</span></label>
  <input id="email" name="email" type="email" class="form-control w-full py-2.5" value="{{ old('email', $user->email ?? '') }}">
</div>

<div class="col-span-12 md:col-span-4 p-2">
  <label for="role_id" class="form-label">Regra <span class="text-red-500">*</span></label>
  <select class="form-select py-2.5" id="role_id" name="role_id">
    @foreach($roles as $role)
    @if(!!old())
      @if(old('role_id') == $role->id)
        <option value="{{ $role->id }}" selected>{{ $role->description }}</option>
      @else
        <option value="{{ $role->id }}">{{ $role->description }}</option>
      @endif
    @elseif(isset($user) && $user->role_id == $role->id)
        <option value="{{ $role->id }}" selected>{{ $role->description }}</option>
      @else
        <option value="{{ $role->id }}" >{{ $role->description }}</option>
      @endif
    @endforeach
  </select>
</div>

@if(isset($user->id))
  <div class="col-span-4 p-2">
    <div class="form-check mt-2">
      <input id="active" name="active" class="form-check-input" type="checkbox"
        @if(!!old())
          @if(old('active') == 'on') checked @endif
        @elseif($user->active)
          checked
        @endif
      >
      <label class="form-check-label" for="active">Ativo</label>
    </div>
  </div>
@endif
