<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
</head>
<body>
	<h2>El usuario con  el  nombre <em>{{ $user->nombre }}</em> fue registrado  en la plataforma <strong>csvtasaciones.com</strong> !</h2>
	<?php
	    if(count($user->areas)>0){
	    	echo "<u><h3>Areas de asignacion.</h3></u>";
			for ($i=0; $i <count($user->areas) ; $i++) 
			{ 
				echo "<p><b>Area: </b>".$user->areas[$i]."</p>";
			}
	    }		
		
	?>

	<p>Por favor habilitar los permisos necesarios.</p>
	<p>Para ello simplemente debes hacer click en el siguiente enlace:</p>
	<a href={{ 'http://www.csvanalitica.com/csv/public/user/'.$user->_usuario.'/edit' }}>
		Clic para habilitar al  usuario
	</a>
	
</body>
</html>