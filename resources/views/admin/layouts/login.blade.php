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

    @yield('adminLoginHead')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('adminLoginCss')

    @vite('resources/css/app.css')
  </head>

  <body class="login">
    @yield('adminLoginContent')

    <div class="invisible  md:visible">
      @include('./admin/layouts/components/dark-mode-switcher')
      @include('./admin/layouts/components/main-color-switcher')
    </div>

    @vite('resources/js/app.js')

    @yield('adminLoginJs')
  </body>
</html>

