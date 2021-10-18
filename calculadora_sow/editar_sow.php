<?php
    //llamando a la conexión de la bd
    include("../conexion.php");
    //obteniendo el id del sow que vamos a editar
    $id = $_GET["id"];
    //seleccionando todos los datos de la tabla sow_silver
    $sow = "SELECT * FROM sow WHERE codigo = '$id'";
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
                <!-- Agregando la variable nombres del inicio de sesión -->  
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
                                            
                            <!-- menú de calculadora sow --> 
                            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseLayout" aria-expanded="false" aria-controls="collapseLayout">
                                <div class="sb-nav-link-icon"><i class="fa fa-wrench"></i></div>
                                Calculadora SOW
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <!-- Item de calculadora sow -->
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
                              
                          <div class="card-header"></i><b id="b-registrar-sow">Editar SOW</b><br><br><br>                          
                            </div>
                            
                            <div id="contenedor-tabla-silver">
                                
                                <ul class="menu-registrar-sow">
                                    <li><a href="editar_bronce.php">Bronce</a></li>
                                    <li><a href="editar_silver.php">Silver</a></li>
                                    <li><a href="editar_gold.php">Gold</a></li>
                                </ul><br>                     
                                <input class="regresar" type="button" value="Regresar" onclick="location.href='sow.php'">
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
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> 
        <script src="../js/scripts.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
	</body>
</html>