<?php
    //llamando a la conexión de la bd
    include("../conexion.php");
?>
<?php
	//iniciando las sesiones
	session_start();
	
    //validando el cierre de sesión de la página
	if(!isset($_SESSION['id_usuario'])){
    //si el usuario cerró sesión, redireccionar a la página del login
		header("Location: ../login/login.php");
	}
	
    //creando el nombre del usuario que inicia sesión 
	$nombres = $_SESSION['nombres'];
    $apellidos = $_SESSION['apellidos'];

    //creando variable para el tipo de usuario que inicia sesión
	$idrol = $_SESSION['idrol'];
?> 

                                <!-- Código php para crear el registro -->
                                <?php
                                include "../conexion.php";
                                //validando que todos los campos del formulario estén llenos antes de registrar
                                    if(!empty($_POST))
                                    {   
                                        //si todos los campos del formulairo están vacios
                                        $alert='';
                                        if(empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['correo']) || empty($_POST['celular']) || empty($_POST['usuario']) || empty($_POST['password']) || empty($_POST['rol']) || empty($_POST['estado']))
                                        {
                                            //se mostrará la siguiente alerta
                                            $alert='<p class="msg_error">¡Completar todos los campos!</p>'; 
                                        }else{                                
                                            $nombre = $_POST['nombres'];
                                            $apellido = $_POST['apellidos'];
                                            $correo = $_POST['correo'];
                                            $cel = $_POST['celular'];
                                            $user = $_POST['usuario'];
                                            $pass = $_POST['password'];
                                            $rol = $_POST['rol'];
                                            $estado = $_POST['estado'];
                                        
                                            //validando que el usuario registrado no se repita con otro existente en la bd
                                            //ejecuntando el query a traves de la $conexion
                                            $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user' OR correo = '$correo' ");
                                            //el resultado lo devolverá por medio de un array y lo almacenará en la variable $result
                                            $result = mysqli_fetch_array($query);

                                            //validando la variable $result si es mayor a 0 significará que si hay registro
                                            if($result > 0){
                                                $alert='<p class="msg_error">¡El usuario o el correo ya existe!</p>';
                                            }else{
                                                $query_insert = mysqli_query($conexion, "INSERT INTO usuarios(usuario,password,nombres,idrol,apellidos,correo,celular,estado)
                                                                                         VALUES ('$user',SHA1('$pass'),'$nombre','$rol','$apellido','$correo','$cel','$estado')");
                                             
                                            //validando si los datos se an insertado en la bd 
                                            if($query_insert){
                                                $alert='<p class="msg_save">¡Usuario registrado correctamente!</p>';
                                            }else{
                                                $alert='<p class="msg_error">¡Ocurrió un error al crear el usuario!</p>';
                                        }
                                      }
                                    }
                                }
                                     
                                ?>
                                
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema SGTRT</title>
        <link href="../css/estilos.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Barra de navegación-->   
            <a class="navbar-brand" href="../pagina_principal/home.php">SGTRT</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
             <!-- menú de la sesión -->  
            <ul class="navbar-nav ml-auto mr-0 mr-md-0 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- Agregando la variable nombre del inicio de sesión -->  
                <?php echo $nombres." ".$apellidos;?>
                    <i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Configuración</a>
                        <div class="dropdown-divider"></div>
                     <!-- redireccionando el cierre de sesión -->  
                        <a class="dropdown-item" href="../login/logout.php">Salir</a>
					</div>
				</li>
			</ul>
		</nav>
<!-- menú lateral de navegación -->
<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                             <!-- privilegios de los usuarios -->				
						<?php if($idrol == 1) { ?>
								
							 <!-- menú reportes -->
								<a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                                Reportes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                 </a>  
                             <!-- Item de reportes -->  
								<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../reportes/consumo_recursos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>
                                    Consumo Recursos TI</a>
                                <a class="nav-link" href="../reportes/tarifario.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
                                    Tarifario TI</a>
                                </nav>
                            </div>
                            <div class="dropdown-divider"></div>

                            <!-- menú usuarios -->
                            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Usuarios
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <!-- Item de usuarios -->
                            <div class="collapse" id="collapsePages" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../usuarios/nuevo_usuario.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
                                    Nuevo Usuario</a>
                                    <a class="nav-link" href="../usuarios/gestionar_usuario.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
                                    Gestionar Usuario</a>
                                </nav>
                            </div>
                            <div class="dropdown-divider"></div>
                                            
                            <!-- menú de mantenimiento --> 
                            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseLayout" aria-expanded="false" aria-controls="collapseLayout">
                                <div class="sb-nav-link-icon"><i class="fa fa-wrench"></i></div>
                                Calculadora SOW
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <!-- Item de mantenimiento -->
                            <div class="collapse" id="collapseLayout" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../calculadora_sow/sow.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>
                                    SOW</a>
                                    <a class="nav-link" href="../calculadora_sow/formularios/listar_4walls.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>  
                                    4walls</a>
                                </nav>
                            </div>  							
								</div>

                        <!-- cerrando llave del usuario en sesión --> 
                        <?php } ?>

                            <!-- página del Analista--> 
                        <?php if($idrol == 2) { ?>
                            			
						 <!-- menú reportes -->                      
                        <a class="nav-link" href="" data-toggle="collapse" data-target="#collapseLayou" aria-expanded="false" aria-controls="collapseLayou">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                                Reportes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                 </a>  
                             <!-- Item de reportes --> 
							<div class="collapse" id="collapseLayou" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../reportes/consumo_recursos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>
                                    Consumo Recursos TI</a>
                                <a class="nav-link" href="../reportes/tarifario.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
                                    Tarifario TI</a>
                                     
                              </div> 
                         
                              <?php } ?>


                            <div>
				                        </nav>
			                </div>

                            <div id="layoutSidenav_content">
                            <main>
                                <div class="container-fluid">
                    
                            <div class="row">                
                            <br>        
                            </div>

                          <div class="card mb-10">
                          <div class="card-header-gestionar-usuario"></i><b id="b-nuevo-usuario">Nuevo usuario</b></div>
                            <div class="card-body">

                            <!-- Formulario -->
                                    
                                 <!-- creando div que muestre una alerta al registrar un usuario -->
                                 <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
                                <!---->
                                <form id="form-generar-usuario" action="" method="post">
                                    <span id="span-nombre">Nombres: <input type="text" name="nombres" id="input-nombre-nuevo-usuario" placeholder="Ingrese el nombre"></span><br>
                                    <span id="span-apellido">Apellidos: <input type="text" name="apellidos" id="input-apellido-nuevo-usuario" placeholder="Ingrese los apellidos"></span><br>
                                    <span id="span-correo">Correo: <input type="email" name="correo" id="input-correo-nuevo-usuario" placeholder="Ingrese el correo"></span><br>
                                    <span id="span-celular">Celular: <input type="text" name="celular" id="input-celular-nuevo-usuario" placeholder="Ingrese número de celular"></span><br>
                                    <span id="span-password">Usuario: <input type="text" name="usuario" id="input-password-nuevo-usuario" placeholder="Escriba el usuario"></span><br>
                                    <span id="span-password">Password: <input type="password" name="password" id="input-password-nuevo-usuario" placeholder="Escriba una contraseña"></span><br>
                                    <!-- Combox de rol extrayendo data de la bd  -->
                                    <label for="rol" class="label-rol">Rol:</label>
                                    <!-- creando query para traer los roles de la bd-->
                                    <?php
                                         $query_rol = mysqli_query($conexion, "SELECT * FROM rol");
                                         //contando las filas que va devolver el query
                                         $result_rol = mysqli_num_rows($query_rol);                                
                                    ?>
                                    <select id="cbo-rol" name="rol">
                                    <option selected="true" disabled="disabled">Seleccionar</option>
                                        <?php
                                              if($result_rol > 0)
                                                 {
                                                    //guardo los resultados en un array
                                                    while ($rol = mysqli_fetch_array($query_rol)){
                                        ?>                                   
                                                    <option value="<?php echo $rol["id"]; ?>"><?php echo $rol["rol"] ?></option>
                                        <?php
                                                 }                                                  
                                            }
                                        ?>
                                                                         
                                    </select>
                                     <!-- Combox de actividad  -->
                                    <label for="rol" class="label-estado" style="visibility:hidden">Estado:</label>
                                    <select id="cbo-estado" name="estado" style="visibility:hidden">                                 
                                        <option selected disabled = "false">Inactivo</option>  
                                        <option selected = "true">Activo</option>                                    
                                    </select><br>
                                    <input class="btn-generar-usuario" type="submit" value="Generar usuario" name="user">
                                    <input class="ver-listado-usuarios" type="button" value="Ir a listado" onclick="location.href='../usuarios/gestionar_usuario.php'">
                                </form>

                               <!--   -->                            
							</div>         
						</div>
                        
					</div>
                    
				</main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Canvia</div>
                            <div>
                                <a href="#">Privacy Policy</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
        <script> src="confirmacion.js"</script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> 
        <script src="../js/scripts.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
	</body>
</html>