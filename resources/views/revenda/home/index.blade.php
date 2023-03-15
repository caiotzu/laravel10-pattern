@extends('../revenda/layouts/main')

@section('revendaHead')
    <title>Home - Pattern laravel 10</title>
@endsection

@section('revendaBreadcrumb')
  <li class="breadcrumb-item active" aria-current="page">
    <a href="{{ route('revenda.home.index') }}">Home</a>
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
    <div class="box p-5 text-center">
      <p class="text-3xl font-bold text-gray-600">
        Seja bem-vindo {{ auth()->guard('web')->user()->name}}!
      </p>
      <p class="text-sm text-gray-400">
        Área exclusiva para usuários
      </p>
    </div>
  </div>
</div>
@endsection

@section('revendaJs')
@endsection
