@csrf

<div class="col-span-12 md:col-span-4 p-2">
  <label for="group_name" class="form-label">Nome do grupo <span class="text-red-500">*</span></label>
  <input id="group_name" name="group_name" type="text" class="form-control w-full py-2.5" value="{{ old('group_name', $companyGroup->group_name ?? '') }}">
</div>

<div class="col-span-12 md:col-span-4 p-2">
  <label for="profile_id" class="form-label">Perfil <span class="text-red-500">*</span></label>
  <select class="form-select py-2.5" id="profile_id" name="profile_id">
    @foreach($profiles as $profile)
    @if(!!old())
      @if(old('profile_id') == $profile->id)
        <option value="{{ $profile->id }}" selected>{{ $profile->description }}</option>
      @else
        <option value="{{ $profile->id }}">{{ $profile->description }}</option>
      @endif
    @elseif(isset($companyGroup) && $companyGroup->profile_id == $profile->id)
        <option value="{{ $profile->id }}" selected>{{ $profile->description }}</option>
      @else
        <option value="{{ $profile->id }}" >{{ $profile->description }}</option>
      @endif
    @endforeach
  </select>
</div>


