@extends('../admin/layouts/main')

@section('adminHead')
    <title>Permission - Pattern laravel 10</title>
@endsection

@section('adminBreadcrumb')
  <li class="breadcrumb-item active">
    <a href="{{ route('admin.home.index') }}">Home</a>
  </li>
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{ route('admin.permissions.index') }}">Permissões</a>
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
    <div class="box p-5">
      <div class="flex justify-between p-1 border-b border-slate-200/60 dark:border-darkmode-400">
        <p class="text-2xl font-bold text-gray-600">
          Listagem de permissões
        </p>

        @if(in_array('PERMISSION_CREATE',Session::get('userPermission')))
          <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary w-32 mr-2 mb-2 ">
            Adicionar
          </a>
        @endif
      </div>
      <div class="overflow-x-auto overflow-y-hidden">
        <table class="table">
          <thead>
            <tr>
              <th class="whitespace-nowrap">Função</th>
              <th class="whitespace-nowrap text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
              <tr>
                <td data-title="Função">{{ $role->description }}</td>
                <td data-title="Ações">
                  <div class="sm:text-right lg:text-center">
                    <div class="dropdown inline-block" data-tw-placement="bottom-start">
                      <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                        Ações <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                      </button>
                      <div class="dropdown-menu w-48">
                        <ul class="dropdown-content">
                          @if(in_array('PERMISSION_EDIT',Session::get('userPermission')))
                            <li>
                              <a href="{{route('admin.permissions.edit', $role->id)}}" class="dropdown-item">
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
          </tbody>
        </table>
      </div>

      <div class="pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
        {{ $roles->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

@section('adminJs')
@endsection
