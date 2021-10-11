<?php
	//destruyendo la sesión una vez cerrada
	session_start();
	session_destroy();
	
	//redireccionando a la página del login
	header("Location: login.php");
?>