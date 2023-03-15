@extends('../admin/layouts/main')

@section('adminHead')
    <title>User Profile - Pattern laravel 10</title>
@endsection
@section('adminCss')
  <style>
    .label-upload-photo {
      cursor: pointer;
    }
    #upload-photo {
      opacity: 0;
    }
  </style>
@endsection

@section('adminBreadcrumb')
  <li class="breadcrumb-item active">
    <a href="{{ route('admin.home.index') }}">Home</a>
  </li>
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{ route('admin.userProfiles.index') }}">Perfil</a>
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
    <div class="intro-y box px-5 pt-5 mt-5">
      <form action="{{ route('admin.userProfiles.update') }}" method="post" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
          <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img alt="User avatar" class="rounded-full" src="{{ $user->avatar ? url('storage/'.$user->avatar) : asset('build/assets/images/avatar.jpg') }}">
                <label for="upload-photo" class="label-upload-photo">
                  <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="camera" class="lucide lucide-camera w-4 h-4 text-white" data-lucide="camera">
                      <path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2.5-3z"></path>
                      <circle cx="12" cy="13" r="3"></circle>
                    </svg>
                  </div>
                </label>
                <input type="file" name="avatar" id="upload-photo" accept="image/jpeg"/>
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->name }}</div>
                <div class="text-slate-500">{{ $user->adminRole->description }}</div>
            </div>
          </div>
          <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
              <div class="font-medium text-center lg:text-left lg:mt-3">Detalhes</div>
              <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="mail" data-lucide="mail" class="lucide lucide-mail w-4 h-4 mr-2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                  </svg>
                  {{ $user->email }}
                </div>
              </div>
          </div>
        </div>

        <div class="grid grid-cols-12 my-5">
          <div class="col-span-12 md:col-span-3 p-2">
            <label for="name" class="form-label">Nome <span class="text-red-500">*</span></label>
            <input id="name" name="name" type="text" class="form-control w-full py-2.5" value="{{ old('name', $user->name ?? '') }}">
          </div>

          <div class="col-span-12 md:col-span-3 p-2">
            <label for="email" class="form-label">E-mail <span class="text-red-500">*</span></label>
            <input id="email" name="email" type="email" class="form-control w-full py-2.5" value="{{ old('email', $user->email ?? '') }}">
          </div>

          <div class="col-span-12 md:col-span-3 p-2">
            <label for="password" class="form-label">Senha
              <a
                href="javascript:;"
                data-theme="light"
                class="tooltip inline-flex ml-1 text-blue-400"
                title="Preencher a senha apenas houver alteração. Para garantir uma melhor seguranda, preencha a senha com letras maiúsculas, minúsculas, números e caracteres especiais.">
              (?)
              </a>
            </label>
            <input id="password" name="password" type="password" class="form-control w-full py-2.5" value="{{ old('password') }}">
          </div>

          <div class="col-span-12 md:col-span-3 p-2">
            <label for="password_confirmation" class="form-label">Confirmação da senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control w-full py-2.5" value="{{ old('password_confirmation') }}">
          </div>
        </div>

        <div class="flex justify-center	pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
          <button class="btn btn-primary w-32 mr-2 mb-2" name="btnSave">
            Salvar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('adminJs')
  <script type="text/javascript" src="{{ URL::asset('js/admin/userProfile/index.js') }}"></script>
@endsection
