<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	<title>Cambiar Contraseña</title>
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
				<h3 class="panel-title">Cambiar Contraseña</h3>
			</div>
			<div class="panel-body">
				{!!Form::open(['url'=>'pass/changePassword'])!!}
				<div class="form-group">
					{!!Form::password('passwordold',['class'=>'form-control', 'placeholder'=>'Contraseña Antigua', 'required', 'maxlength'=>60])!!}
				</div>
				<div class="form-group">
					{!!Form::password('password',['class'=>'form-control', 'placeholder'=>'Contraseña Nueva', 'required', 'maxlength'=>60])!!}
				</div>
				<div class="form-group">
					{!!Form::password('password_confirmation',['class'=>'form-control', 'placeholder'=>'Repetir Contraseña Nueva', 'required', 'maxlength'=>60])!!}
				</div>
				{!!Form::submit('Cambiar contraseña',['class'=>'btn primary form-control shadow'])!!}
				{!!Form::close()!!}
			</div>
		</div>
	</div>
</body>
</html>