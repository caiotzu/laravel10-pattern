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
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{route('admin.companyGroups.edit', $companyGroup->id) }}">Edição</a>
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

<div class="grid grid-cols-12">
  <div class="col-span-12 mt-8">
    <div class="box p-5">
      <div class="flex justify-between p-1 border-b border-slate-200/60 dark:border-darkmode-400">
        <p class="text-2xl font-bold text-gray-600">
          Edição do grupo de empresas - {{ $companyGroup->group_name }}
        </p>
      </div>
      <form action="{{ route('admin.companyGroups.update', $companyGroup->id) }}" method="post" class="mt-3">
        @method('PUT')
        <div class="grid grid-cols-12 mt-3 mb-3">
          @include('admin.companyGroup._partials.form')
        </div>
        <div class="flex justify-center	pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
          @if(in_array('COMPANYGROUP_EDIT',Session::get('userPermission')))
            <button class="btn btn-primary w-32 mr-2 mb-2" name="btnSave">
              Salvar
            </button>
          @endif
          <a href="{{ route('admin.companyGroups.index') }}" class="btn btn-secondary w-32 mr-2 mb-2 ">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('adminJs')
  <script type="text/javascript" src="{{ URL::asset('js/admin/companyGroup/index.js') }}"></script>
@endsection

