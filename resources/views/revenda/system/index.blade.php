@extends('../revenda/layouts/main')

@section('revendaHead')
    <title>Sistema - Pattern laravel 10</title>
@endsection

@section('revendaBreadcrumb')
  <li class="breadcrumb-item active">
    <a href="{{ route('revenda.home.index') }}">Home</a>
  </li>
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{ route('revenda.systems.index') }}">Sistema</a>
  </li>
@endsection

@section('revendaContent')
@if($errors->any())
  <div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4 relative" role="alert">
    <p class="font-bold text-lg mb-2 relative">Erro</p>
    <p>{!! implode('<br>', $errors->all('<span class="text-lg">&raquo;</span> :message')) !!}</p>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
      <a onClick="(function(){document.getElementById('errorMessage').remove();return false;})();return false;">
        <i data-lucide="x" role="button"></i>
      </a>
    </span>
  </div>
@endif

@if(session('successMessage'))
  <div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4 relative" role="alert">
    <p class="font-bold text-lg mb-2 relative">Sucesso</p>
    <p>
      @if(is_array(session('successMessage')))
        @foreach(session('successMessage') as $message)
          <span class="text-lg">&raquo;</span> {!! $message !!}<br/>
        @endforeach
      @else
        <span class="text-lg">&raquo;</span> {!! session('successMessage') !!}
      @endif
    </p>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
      <a onClick="(function(){document.getElementById('successMessage').remove();return false;})();return false;">
        <i data-lucide="x" role="button"></i>
      </a>
    </span>
  </div>
@endif

<div class="grid grid-cols-12">
  <div class="col-span-12 mt-8">
    <div class="box p-5">
      <div class="flex justify-between p-1 border-b border-slate-200/60 dark:border-darkmode-400">
        <p class="text-2xl font-bold text-gray-600">
          Configurações do sistema
        </p>
      </div>
      <div class="overflow-x-auto overflow-y-hidden">
        <form action="{{ route('revenda.systems.update') }}" method="post" class="mt-3">
          @method('PUT')
          @csrf

          <div class="p-2 col-span-12">
            <div class="preview">
              <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap" role="tablist">
                <li id="general" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
                  <button
                    class="nav-link w-2/4 py-2 active"
                    data-tw-toggle="pill"
                    data-tw-target="#tab-general"
                    type="button"
                    role="tab"
                    aria-controls="tab-general"
                    aria-selected="true"
                  >
                    Geral
                  </button>
                </li>
              </ul>
              <div class="tab-content border-l border-r border-b">
                <div id="tab-general" class="tab-pane leading-relaxed p-5 grid grid-cols-12 active" role="tabpanel" aria-labelledby="role">
                  <div class="col-span-12 md:col-span-4 p-2">
                    <label for="recordPerPage" class="form-label">
                      Registro por pagina<span class="text-red-500">*</span>
                      <a href="javascript:;" data-theme="light" class="tooltip inline-flex ml-1 text-blue-400" title="{{ $settings['recordPerPage']['description'] ?? '' }}">
                        (?)
                      </a>
                    </label>
                    <input id="recordPerPage" name="recordPerPage" type="number" class="form-control w-full py-2.5" value="{{ old('recordPerPage', $settings['recordPerPage']['value'] ?? '') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="flex justify-center	pt-5 mt-3 border-t border-slate-200/60 dark:border-darkmode-400">
            @if(in_array('SYSTEM_EDIT',Session::get('userPermission')))
              <button class="btn btn-primary w-32 mr-2 mb-2" name="btnSave">
                Salvar
              </button>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('revendaJs')
  <script type="text/javascript" src="{{ URL::asset('js/revenda/system/index.js') }}"></script>
@endsection

