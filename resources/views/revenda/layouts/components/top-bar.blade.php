<!-- BEGIN: Top Bar -->
<div class="top-bar-boxed {{ isset($class) ? $class : '' }} h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
  <div class="h-full flex items-center">
    <!-- BEGIN: Logo -->
    <a href="{{ route('revenda.home.index') }}" class="logo -intro-x hidden md:flex xl:w-[180px] block">
      <img alt="Pattern laravel 10" class="logo__image w-48" src="{{ asset('build/assets/images/logo.png') }}">
    </a>
    <!-- END: Logo -->

    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
      <ol class="breadcrumb breadcrumb-light">
        @yield('revendaBreadcrumb')
        {{-- <li class="breadcrumb-item"><a href="#">Application</a></li>
        <li class="breadcrumb-item active" aria-current="page">Home</li> --}}
      </ol>
    </nav>
    <!-- END: Breadcrumb -->

    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
      <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown">
        <img alt="Pattern laravel 10" src="{{ auth()->guard('web')->user()->avatar ? url('storage/'.auth()->guard('web')->user()->avatar) : asset('build/assets/images/avatar.jpg') }}">
      </div>
      <div class="dropdown-menu w-56">
        <ul class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
          <li class="p-2">
              <div class="font-medium">{{ auth()->guard('web')->user()->name }}</div>
              <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">{{ auth()->guard('web')->user()->role->description }}</div>
          </li>
          <li>
            <hr class="dropdown-divider border-white/[0.08]">
          </li>
          <li>
            <a href="{{ route('revenda.userProfiles.index') }}" class="dropdown-item hover:bg-white/5 ">
              <i data-lucide="user" class="w-4 h-4 mr-2"></i> Perfil
            </a>
          </li>
          <li><hr class="dropdown-divider border-white/[0.08]"></li>
          <li>
            <a href="{{ route('revenda.auth.logout') }}" class="dropdown-item hover:bg-white/5" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
              <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('revenda.auth.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
    <!-- END: Account Menu -->
  </div>
</div>
<!-- END: Top Bar -->
