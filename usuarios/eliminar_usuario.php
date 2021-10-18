<?php
    //llamando a la conexión de la bd
    include("../conexion.php");
    //introduciendo la consulta de dos tablas relacionales con inner join
    $usuarios = "SELECT * FROM usuarios JOIN rol where usuarios.idrol = rol.id";
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
<?php
     include "../conexion.php";
    //realizando validación para indicar que solo ejecute la acción cuando seleccionar botón aceptar
    //eliminará el id enviado por el método post del formulario
    if(!empty($_POST))
    {
        $idusuario = $_POST['idusuario'];
        $query_delete = mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario = $idusuario");

        //indicando lo que ará el sistema luego de validar la ejecución del query
        if($query_delete){
            header("location: gestionar_usuario.php");
        }else{
            echo "Error en la eliminación";
        }
    }

//validando si la variable no existe o si tiene un valor de id = 1 retornará al listado
if(empty($_REQUEST['id_user']) || $_REQUEST['id_user'] == 1)
{
    header("location: gestionar_usuario.php");
}else{ //si la url si lleva un id & fiferente de 1
    //guardando la id obtenida en una variable $idusuario
    $idusuario = $_REQUEST['id_user'];
    //creando query que nos capture el nombre, apellido, usuario y rol del usuario que estamos por eliminar
    $query = mysqli_query($conexion, "SELECT u.nombres, u.apellidos,u.usuario, r.rol FROM 
                                      usuarios u INNER JOIN rol r ON u.idrol = r.id WHERE u.id_usuario = $idusuario ");
    
    //creando variable que almacene la cantidad de filas obtenidas del query
    $result = mysqli_num_rows($query);
    //validando si las filas son mayores a 0 si exite el usuario seleccionado
    if($result > 0){
        //si los datos existen, los recuperamos en un bucle while 
        while ($data = mysqli_fetch_array($query)){
            //guardando los datos del array en variables
            $nombre = $data['nombres'];
            $apellido = $data['apellidos'];
            $usuario = $data['usuario'];
            $rol = $data['rol'];
        }
    }else{ // si los datos obtenidos no cumplen la condición, nos retorna a la página de listado 
        header("location: gestionar_usuario.php");
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


<div class="row">                
<br>        
</div>

<div class="card mb-10" id="div-card">
<!-- Tablas -->

<div class="data_delete">
    <!--imprimiendo los datos obtenidos del query almacenados en el array -->
    <h2>¿Estas seguro de eliminar este usuario?</h2>
        <p>Nombre: <span><?php echo $nombre." ".$apellido ;?></span></p>
        <p>Usuario: <span><?php echo $usuario;?></span></p>
        <p>Tipo de usuario: <span><?php echo $rol;?></span></p>

<form class="form-eliminar-usuario" method="post" action="">
    <!--incluyendo el id que se enviará por método post para su eliminación-->
    <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
    <a href="gestionar_usuario.php" class="btn-cancelar">Cancelar</a>
    <input type="submit" value="Aceptar" class="btn-aceptar">
</form>
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>
</html>