<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
</head>
<body>
	<h2>Hola {{ $user->nombre }}, gracias por registrarte en <strong>csvtasaciones.com</strong> !</h2>
	<p>Por favor confirma tu correo electrónico.</p>
	<p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

	<a href={{ 'http://www.csvanalitica.com/csv/public/account/confirm/'.$user->_token }}>
	<!--<a href={{ 'http://192.168.100.29/csv/public/account/confirm/'.$user->_token }}>-->
		Clic para confirmar tu email
	</a>
</body>
</html>