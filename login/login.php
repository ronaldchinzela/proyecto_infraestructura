<?php
   //importando la conexión	de mysql
	require "../conexion.php";
	
	//iniciando la sesión del usuario con datos correctos.
	session_start();

	//validación del envío del método POST
	//recibiendo los datos ingresados
	if($_POST){
		
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];
		
		//consulta sql para verificar si el usuario existe
		$sql = "SELECT id, password, nombres,apellidos, idrol FROM usuarios WHERE usuario='$usuario'";

		//ejecutando el dato obtenido del select
		$resultado = $conexion->query($sql);
		//validando si existe o no el usuario 
		$num = $resultado->num_rows;
		if($num>0){
			//traigo los resultados de la consulta sql
			$row = $resultado->fetch_assoc();
			$password_bd = $row['password'];
			
			//creando variable que almacene la contraseña ingresada y la convirta a sha1
			$pass_c = sha1($password);
			
			//validando si la contraseña ingresada es la misma de la base de datos
			if($password_bd == $pass_c){
				
				$_SESSION['id'] = $row['id'];
				$_SESSION['nombres'] = $row['nombres'];
				$_SESSION['apellidos'] = $row['apellidos'];
				$_SESSION['idrol'] = $row['idrol'];
				
				header("Location: ../pagina_principal/home.php");
				
			} else {			
				echo "contraseña no existe";
			
			}
					
			} else {
				echo "usuario no existe";
		}	
		
	}
	
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema SGTRT</title>
		<link rel="stylesheet" href="../sweetalert2.min.css">
		<link href="../css/estilos.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	</head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class="text-center font-weight-light my-4"></div>
									<!-- metodo SERVER para volver a cargar el formulario en caso de datos invalidos -->
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<h2 style="font: size 12px;"><b>SGTRT </b></h2><br><br>
										<input type="text" placeholder="    Usuario (Correo)" name="usuario">
										<div class="col-lg-9">	
										<span style="color:#c7c7c7;font-size:11px;">
         										<i>ejem: tucorreo@canvia.com</i>
												 </span>
												<br>
												<br>
										<input type="password" placeholder="    Contraseña" name="password"> <br>					
											<input id="btn_ingresar" type="submit" value="Ingresar  "><br><br><br>
										</form>		
										
							</div>
						</div>
					</div>
				</main>
			</div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Canvia</div>
                            <div>
                                <a href="#">Política de privacidad</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/sweetalert2.all.min.js"></script>
		<script src="../js/sweet_alert.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
