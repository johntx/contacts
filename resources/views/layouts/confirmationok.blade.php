<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{!!URL::to('icons/logomin.png')!!}" />
  <link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>CSV @if(isset($me)){{"- "}}{{\casas\Menu::where("code",$me)->first()->label}} @endif </title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {!!Html::style('css/materialdesignicons.min.css')!!}
  {!!Html::style('css/boot.css')!!}
  {!!Html::style('css/admin.css')!!}
  {!!Html::style('css/MentisMe.css')!!}
</head>
<body style="background-color: #FCFCFC; text-align: center;">
  <br>
  <br>
  <img src="{!!URL::to('icons/logomin.png')!!}" style="max-width: 40%; height: auto;">
  <br>
  <h1>Confirmación de correo exitosa!!</h1>
  <br>
  <h3>Ahora ya puedes iniciar sesion.. :D</h3>
  <br>
  <a href="{!!URL::to('log')!!}" class="btn default">Inicia sesion</a>
</body>
</html>
