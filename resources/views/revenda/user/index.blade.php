@extends('../revenda/layouts/main')

@section('revendaHead')
    <title>User - Pattern laravel 10</title>
@endsection

@section('revendaBreadcrumb')
  <li class="breadcrumb-item active">
    <a href="{{ route('revenda.home.index') }}">Home</a>
  </li>
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{ route('revenda.users.index') }}">Usuários</a>
  </li>
@endsection

@section('revendaContent')
<div id="divMessage"></div>

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
          Listagem de usuários
        </p>

        @if(in_array('USER_CREATE',Session::get('userPermission')))
          <a href="{{ route('revenda.users.create') }}" class="btn btn-primary w-32 mr-2 mb-2 ">
            Adicionar
          </a>
        @endif
      </div>
      <div class="overflow-x-auto overflow-y-hidden">
        <table class="table">
          <thead>
            <tr>
              <th class="whitespace-nowrap">Nome</th>
              <th class="whitespace-nowrap">E-mail</th>
              <th class="whitespace-nowrap">Função</th>
              <th class="whitespace-nowrap">Status</th>
              <th class="whitespace-nowrap text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td data-title="Nome">{{ $user->name }}</td>
                <td data-title="E-mail">{{ $user->email }}</td>
                <td data-title="Função">{{ $user->role->description }}</td>
                <td data-title="Status">
                  @if($user->active)
                    <span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>
                  @else
                    <span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>
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
                          @if(in_array('USER_EDIT',Session::get('userPermission')))
                            <li>
                              <a href="{{route('revenda.users.edit', $user->id)}}" class="dropdown-item">
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
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

@section('revendaJs')
@endsection
