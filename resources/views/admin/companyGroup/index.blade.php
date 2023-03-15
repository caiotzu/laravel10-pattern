@extends('../admin/layouts/main')

@section('adminHead')
    <title>Company Group - Pattern laravel 10</title>
@endsection

@section('adminBreadcrumb')
  <li class="breadcrumb-item active">
    <a href="{{ route('admin.home.index') }}">Home</a>
  </li>
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{ route('admin.companyGroups.index') }}">Grupos Empresas</a>
  </li>
@endsection

@section('adminContent')
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
    <div class="box p-5 mb-4">
      <div class="flex justify-between p-1 border-b border-slate-200/60 dark:border-darkmode-400">
        <p class="text-2xl font-bold text-gray-600">
          Filtro
        </p>
      </div>
      <form action="{{ route('admin.companyGroups.index') }}" method="get" class="mt-3 grid grid-cols-12">
        <div class="col-span-12 md:col-span-4 p-2">
          <label for="company_group_id" class="form-label">Grupo empresa</label>
          <select class="tom-select w-full" id="company_group_id" name="company_group_id">
            @if(isset($data['company_group_id']) && $data['company_group_id'] == '')
              <option value="" selected>Selecione o grupo</option>
            @else
              <option value="">Selecione o grupo</option>
            @endif

            @foreach($companyGroups as $companyGroup)
            @if(!!old())
              @if(old('id') == $companyGroup->id)
                <option value="{{ $companyGroup->id }}" selected>{{ $companyGroup->group_name }}</option>
              @else
                <option value="{{ $companyGroup->id }}">{{ $companyGroup->group_name }}</option>
              @endif
            @elseif(isset($data['company_group_id']) && $data['company_group_id'] == $companyGroup->id)
                <option value="{{ $companyGroup->id }}" selected>{{ $companyGroup->group_name }}</option>
              @else
                <option value="{{ $companyGroup->id }}" >{{ $companyGroup->group_name }}</option>
              @endif
            @endforeach
          </select>
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
            @elseif(isset($data['profile_id']) && $data['profile_id'] == $profile->id)
                <option value="{{ $profile->id }}" selected>{{ $profile->description }}</option>
              @else
                <option value="{{ $profile->id }}" >{{ $profile->description }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="col-span-12 pt-5 mt-3 border-t border-slate-200/60 dark:border-darkmode-400">
          @if(in_array('COMPANYGROUP_FILTER',Session::get('userPermission')))
            <button class="btn btn-primary w-32 mr-2 mb-2 w-full" name="btnFilter">
              Filtrar
            </button>
          @endif
        </div>
      </form>
    </div>

    <div class="box p-5">
      <div class="flex justify-between p-1 border-b border-slate-200/60 dark:border-darkmode-400">
        <p class="text-2xl font-bold text-gray-600">
          Listagem de grupos empresas
        </p>

        @if(in_array('COMPANYGROUP_CREATE',Session::get('userPermission')))
          <a href="{{ route('admin.companyGroups.create') }}" class="btn btn-primary w-32 mr-2 mb-2 ">
            Adicionar
          </a>
        @endif
      </div>
      <div class="overflow-x-auto overflow-y-hidden">
        <table class="table">
          <thead>
            <tr>
              <th class="whitespace-nowrap">Nome</th>
              <th class="whitespace-nowrap">Perfil</th>
              <th class="whitespace-nowrap text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            @if(count($filteredList) > 0)
              @foreach($filteredList as $companyGroup)
                <tr>
                  <td data-title="Nome">{{ $companyGroup->group_name }}</td>
                  <td data-title="Perfil">
                    @if($companyGroup->profile->description == 'REVENDA')
                      <span class="bg-indigo-200 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900">Revenda</span>
                    @elseif($companyGroup->profile->description == 'ITE')
                      <span class="bg-cyan-200 text-cyan-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-200 dark:text-cyan-900">Ite</span>
                    @else
                      <span class="bg-purple-200 text-purple-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-purple-200 dark:text-purple-900">Montadora</span>
                    @endif
                  </td>
                  <td data-title="Ações">
                    <div class="sm:text-right lg:text-center">
                      <div class="dropdown inline-block" data-tw-placement="bottom-start">
                        <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                          Ações <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                        </button>
                        <div class="dropdown-menu w-48">
                          <ul class="dropdown-content">
                            @if(in_array('COMPANYGROUP_EDIT',Session::get('userPermission')))
                              <li>
                                <a href="{{route('admin.companyGroups.edit', $companyGroup->id)}}" class="dropdown-item">
                                  <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Editar
                                </a>
                              </li>
                            @endif
                          </ul>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            @else
              <tr class="text-center">
                <td colspan="3">Nenhum registro encontrado.</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>

      <div class="pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
        @if(request()->company_group_id || request()->profile_id)
          {{ $filteredList->appends([
            'company_group_id' => request()->get('company_group_id', ''),
            'profile_id' => request()->get('profile_id', '')
          ])->links() }}
        @else
          {{ $filteredList->links() }}
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('adminJs')
  <script type="text/javascript" src="{{ URL::asset('js/admin/companyGroup/index.js') }}"></script>
@endsection
