<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
  <title>Log In</title>
  {!!Html::style('css/boot.css')!!}
  {!!Html::style('css/MentisMe.css')!!}
</head>
<body>
  @include('alerts.success')
  @include('alerts.alert')
  @include('alerts.error')
  <div class="col-1 col-mid" style="margin-top: 10%;">
    <div class="panel default-soft">
      <div class="panel-heading">
        <h3 class="panel-title">Log In</h3>
      </div>
      <div class="panel-body centrado">
        {!!Form::open(['route'=>'log.store', 'method'=>'POST', 'class'=>'form'])!!}
        <div class="form-group">
          {!!Form::text('name',null,['class'=>'form-control', 'placeholder'=>'User', 'required', 'maxlength'=>255])!!}
        </div>
        <div class="form-group">
          {!!Form::password('password',['class'=>'form-control', 'placeholder'=>'Password', 'required', 'maxlength'=>60])!!}
        </div>
        <div class="form-group">
          {!!Form::submit('Log In',['class'=>'btn primary form-control shadow'])!!}
        </div>
        {!!Form::close()!!}
        <div class="form-group">
          <p>ó</p>
        </div>
        <a href="{!!URL::to('usr/registrate')!!}" class="btn default form-control">Regístrate</a>
      </div>
    </div>
  </div>
  {!!Html::script('js/jquery.js')!!}
  {!!Html::script('js/admin.js')!!}
</body>
</html>