<!DOCTYPE html>
<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="{{ $dark_mode ? 'dark' : '' }}{{ $color_scheme != 'default' ? ' ' . $color_scheme : '' }}"
>
  <head>
    <meta charset="utf-8">
    <link href="{{ asset('build/assets/images/github.png') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Design pattern with laravel 9">
    <meta name="keywords" content="Pattern, Laravel 9, Tailwind">
    <meta name="author" content="Caio Costa">

    @yield('adminHead')
    <link rel="stylesheet" href='{{ URL::asset('js/plugins/sweet-alert/custom-styles.css') }}'/>
    <link rel="stylesheet" href='{{ URL::asset('js/plugins/loading-caio/loading-caio.css') }}'/>
    @yield('adminCss')

    @vite('resources/css/app.css')
  </head>

  <body class="py-5 md:py-0">
    <div class="wrapper-loading" style="display: none">
      <div class="loading">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="shadow"></div>
        <div class="shadow"></div>
        <div class="shadow"></div>
        <span class="loading-text">Carregando</span>
      </div>
    </div>

    @switch($layout_scheme)
      @case('top-menu')
        @include('admin.layouts.top-menu')
        @break
      @case('simple-menu')
        @include('admin.layouts.simple-menu')
        @break
      @default
        @include('admin.layouts.side-menu')
    @endswitch

    {{-- <div class="invisible  xl:visible">
      @include('./admin/layouts/components/layout-mode-switcher')
      @include('./admin/layouts/components/dark-mode-switcher')
      @include('./admin/layouts/components/main-color-switcher')
    </div> --}}

    {{-- <div class="sm:visible xl:invisible"> --}}
      @include('./admin/layouts/components/mobile-mode-switcher')
    {{-- </div> --}}
    @vite('resources/js/app.js')

    <script type="text/javascript" src="{{ URL::asset('js/plugins/jquery-3.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/plugins/jquery.mask.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/plugins/select2/select2.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/plugins/sweet-alert/sweet-alert.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/plugins/momentJs/momentJs.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/layouts/index.js') }}"></script>

    @yield('adminJs')
  </body>
</html>
