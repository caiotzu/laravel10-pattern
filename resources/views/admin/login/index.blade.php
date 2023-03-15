@extends('../admin/layouts/login')


@section('adminLoginHead')
    <title>Login - Pattern laravel 10</title>
@endsection

@section('adminLoginContent')
  <div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
      <!-- BEGIN: Login Info -->
      <div class="hidden xl:flex flex-col min-h-screen">
        <a href="" class="-intro-x flex items-center pt-5">
          <img alt="Pattern laravel 10" class="w-64" src="{{ asset('build/assets/images/logo.png') }}">
        </a>
        <div class="my-auto">
          <img alt="Pattern laravel 10" class="-intro-x w-3/5 -mt-16" src="{{ asset('build/assets/images/illustration.svg') }}">
          <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Faça o login para acessar <br>a área administrativa</div>
          <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Área restrita a administradores do sistema</div>
        </div>
      </div>
      <!-- END: Login Info -->

      <!-- BEGIN: Login Form -->
      <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
          <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Entrar</h2>
          <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">Área restrita a administradores do sistema</div>
          <div class="intro-x mt-8">
            <form id="login-form">
              <input id="email" type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="E-mail">
              <div id="error-email" class="login__input-error text-danger mt-2"></div>
              <input id="password" type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Senha">
              <div id="error-password" class="login__input-error text-danger mt-2"></div>
            </form>
          </div>
          <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
            <div class="flex items-center mr-auto">
              <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
              <label class="cursor-pointer select-none" for="remember-me">Lembre-me</label>
            </div>
            <a href="">Esqueceu a senha?</a>
          </div>
          <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
            <button id="btn-login" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
              Entrar
            </button>
          </div>
        </div>
      </div>
      <!-- END: Login Form -->
    </div>
  </div>
@endsection

@section('adminLoginJs')
  <script type="module">
    (function () {
      async function login() {
        // Reset state
        $('#login-form').find('.login__input').removeClass('border-danger')
        $('#login-form').find('.login__input-error').html('')

        // Post form
        let email = $('#email').val()
        let password = $('#password').val()
        let remember = $('#remember-me').is(':checked')

        // Loading state
        $('#btn-login').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>')
        tailwind.svgLoader()
        await helper.delay(1500)

        axios.post(`admin/login`, {
          email,
          password,
          remember
        }).then(res => {
          localStorage.setItem('userPermission', JSON.stringify(res.data));
          location.href = '/admin/home'
        }).catch(err => {
          $('#btn-login').html(`Entrar`)
          if (err.response.data.message != 'E-mail ou senha incorretos.') {
            for (const [key, val] of Object.entries(err.response.data.errors)) {
              $(`#${key}`).addClass('border-danger')
              $(`#error-${key}`).html(val)
            }
          } else {
            $(`#password`).addClass('border-danger')
            $(`#error-password`).html(err.response.data.message)
          }
        })
      }

      $('#login-form').on('keyup', function(e) {
        if (e.keyCode === 13) {
          login()
        }
      })

      $('#btn-login').on('click', function() {
        login()
      })
    })()
  </script>
@endsection
