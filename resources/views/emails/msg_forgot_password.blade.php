<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
</head>
<body>
	<span>Hi <strong>{{ $contact['first_name'] }}</strong>
		<br>
		To recover your password click <a href="{{url('user')}}">here</a>
	</span>
</body>
</html>