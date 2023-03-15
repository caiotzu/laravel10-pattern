@csrf

<div class="p-2 col-span-12">
  <div class="preview">
    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap" role="tablist">
      <li id="role" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2 active"
          data-tw-toggle="pill"
          data-tw-target="#tab-role"
          type="button"
          role="tab"
          aria-controls="tab-role"
          aria-selected="true"
        >
          Função
        </button>
      </li>
      <li id="permissions" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2"
          data-tw-toggle="pill"
          data-tw-target="#tab-permission"
          type="button" role="tab"
          aria-controls="tab-permission"
          aria-selected="false"
        >
          Permissões
        </button>
      </li>
    </ul>
    <div class="tab-content border-l border-r border-b">
      <div id="tab-role" class="tab-pane leading-relaxed p-5 grid grid-cols-12 active" role="tabpanel" aria-labelledby="role">
        <div class="col-span-12 md:col-span-4 p-2">
          <label for="description" class="form-label">Função<span class="text-red-500">*</span></label>
          <input id="description" name="description" type="text" class="form-control w-full py-2.5" value="{{ old('description', $role->description ?? '') }}">
        </div>
      </div>
      <div id="tab-permission" class="tab-pane leading-relaxed p-5 grid grid-cols-12" role="tabpanel" aria-labelledby="permissions">
        @foreach($permissions as $permission)
          <div class="border border-slate-200/60 dark:border-darkmode-400 col-span-12 md:col-span-6 m-2 p-2">
            @foreach($permission as $item)
              <div class="form-check mt-2">
                <input id="{{ $item['key'] }}_{{ $item['id'] }}" name="{{ $item['key'] }}_{{ $item['id'] }}" class="form-check-input" type="checkbox"
                  @if(!!old())
                    @if(old($item['key'].'_'.$item['id']) == 'on') checked @endif
                  @elseif($item['hasPermission'])
                    checked
                  @endif
                >
                <label class="form-check-label" for="{{ $item['key']}}_{{ $item['id'] }}" >{{ $item['description'] }}</label>
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
