<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, minimum-scale=1, width=device-width">
    <title>Error 404 (Not Found)!!</title>
    <style>
      .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh
      }

      @media(max-width: 2560px) {
       img {
        width: 50%
       }
      }

      @media(max-width: 1440px) {
       img {
        width: 60%
       }
      }

      @media(max-width: 1024px) {
       img {
        width: 80%
       }
      }

      @media(max-width: 768px) {
       img {
        width: 100%
       }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <img src="{{ asset('build/assets/images/error404.jpg') }}">
    </div>
  </body>
</html>
