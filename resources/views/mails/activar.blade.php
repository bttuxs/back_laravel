<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Activar usuario</title>
    <style>
      .titulo{
        font-size: 25px
      }
      .nombre{
        text-transform: uppercase;
      }
      .link{
        text-transform: uppercase;
      }
    </style>
  </head>
  <body>
    <div class="titulo">
      Bienvenid@
    </div>
    <img src="http://ventas-mg.bttuxs.com/assets/images/correo.svg" alt="">
    <div class="nombre">
      {{ $nombreCompleto }}
    </div>
    <div>
      Para activar tu cuenta da
    </div>
    <a href="{{ $linkMail }}" class="link" >Click Aqui</a>
    <div class="">
      Si no abre el link, puedes copiar el siguiente enlace en el navegador, para realizar la activacion.
    </div>
    <div style="cursor:pinter;">
      {{ $linkMail }}
    </div>
  </body>
</html>
