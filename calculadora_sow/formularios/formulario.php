<?php
    //llamando a la conexión de la bd
    include("../../conexion.php");
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
include "../../conexion.php";
//validando que todos los campos del formulario estén llenos antes de registrar
if(!empty($_POST))
{   
//si todos los campos del formulairo están vacios
$alerta='';
if(empty($_POST['codigo']) || empty($_POST['proyecto']) || empty($_POST['costoMensual']) || empty($_POST['Cnexus']) || empty($_POST['Chp']) || empty($_POST['totaldolar']) || empty($_POST['totalsoles']))
{
    //se mostrará la siguiente alerta
    $alerta='<p class="mensaje_error_complete_campos">¡Completar todos los campos!</p>'; 
}else{ 
    //creando variables para almacenar los name de los input enviados por método _POST                               
    $Codigo = $_POST['codigo'];
    $Proyecto = $_POST['proyecto'];
    $SoporteH = $_POST['soporteH'];
    $CoMensual = $_POST['costoMensual'];
    $CoNexsus = $_POST['Cnexus'];
    $CoHp = $_POST['Chp'];
    $PreDolar = $_POST['totaldolar'];
    $PreSoles = $_POST['totalsoles'];                   

    //validando que el usuario registrado no se repita con otro existente en la bd
    //ejecuntando el query a traves de la $conexion
    $query_formulario = mysqli_query($conexion, "SELECT * FROM 4walls WHERE proyecto = '$Proyecto' OR idwalls  = '$Codigo' ");
    //el resultado lo devolverá por medio de un array y lo almacenará en la variable $result
    $result = mysqli_fetch_array($query_formulario);

    //validando la variable $result si es mayor a 0 significará que si hay registro
    if($result > 0){
        $alerta='<p class="mensaje_error">¡Ya existe un proyecto con el mismo nombre!</p>';
    }else{
        $query_insertar_formulario = mysqli_query($conexion, "INSERT INTO 4walls(idwalls ,proyecto,soporte_horas,total_dolar,total_soles,c_mensual,c_nexsus,c_hp)
                                                    VALUES ('$Codigo','$Proyecto','$SoporteH','$PreDolar','$PreSoles','$CoMensual','$CoNexsus','$CoHp')");
        
    //validando si los datos se an insertado en la bd 
    if($query_insertar_formulario){
        $alerta='<p class="mensaje_save">¡Datos registrados correctamente!</p>';
    }else{
        $alerta='<p class="mensaje_error">¡Ocurrió un error en el registro!</p>';
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
    <link href="../../css/estilos.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
<!-- Barra de navegación-->   
<a class="navbar-brand" href="../../pagina_principal/home.php">SGTRT</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

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
    <a class="dropdown-item" href="../../login/logout.php">Salir</a>
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
        <a class="nav-link" href="../../reportes/consumo_recursos.php">
        <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>
            Consumo Recursos TI</a>
        <a class="nav-link" href="../../reportes/tarifario.php">
        <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
            Tarifario TI</a>
        <a class="nav-link" href="../../reportes/resumen_servidores.php">
        <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
            Resumen de Servidores</a>
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
            <a class="nav-link" href="../../usuarios/nuevo_usuario.php">
            <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>    
            Nuevo Usuario</a>
            <a class="nav-link" href="../../usuarios/gestionar_usuario.php">
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
            <a class="nav-link" href="../../calculadora_sow/sow.php">
            <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>
            SOW</a>
            <a class="nav-link" href="../../calculadora_sow/formularios/listar_4walls.php">
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
        <div class="container-fluid-formulario">

    <div class="row">                
    <br>        
    </div>

    <div class="card mb-5">
    <div class="card-header"></i><b id="b-formulario">Formulario 4walls</b></div>
    <div class="card-body-formulario">

        <!-- Formulario -->
                                    
<!-- creando div que muestre una alerta al registrar un usuario -->
<div class="alerta"><?php echo isset($alerta) ? $alerta : ''; ?></div>
<!---->
<form id="form_formulario" action="" method="post">
<table border="2" id="table-formulario-4walls">
<tr>
        <th colspan="8">Formulario 4walls</th>
    </tr>

    <tr>
        <th class="th1">Código</th>
        <th class="th2">Proyecto</th>
        <th class="th0">Soporte de Horas</th>
        <th class="th3">Costo Mensual 4Walls</th>
        <th class="th4">Costo <br> Nexsus</th>
        <th class="th5">Costo HP DC Care</th>
        <th class="th6">Total $</th>
        <th class="th7">Total S/.</th>
    </tr>
    <tr>                                       
        <th><input id="input_1" type="text"  name="codigo"></th>
        <th><input id="input_2" type="text" name="proyecto" placeholder="Nombre del proyecto"></th>
        <th><input id="input_0" type="text" name="soporteH" placeholder="Ingresar horas"></th>
        <th><input id="input_3" type="text" name="costoMensual" placeholder="Costo mensual"></th>
        <th><input id="input_4" type="text" name="Cnexus" placeholder="Costo de Nexsus"></th>
        <th><input id="input_5" type="text" name="Chp" placeholder="Costo de HP"></th>
        <th><input id="input_6" type="text" name="totaldolar" placeholder="Precio en dolar"></th>
        <th><input id="input_7" type="text" name="totalsoles" placeholder="Precio en soles"></th>
    </tr>                                  
</table>
<input id="boton-registrar-formulario" type="submit" value="Registrar">
<input class="cancelar-formulario" type="button" value="Cancelar" onclick="location.href='../../calculadora_sow/formularios/listar_4walls.php'">
<input class="ir-dcc" type="button" value="Ir a DCC" onclick="location.href='formulario_dcc.php'">
</div>                             
</form>
</div>
                        
    </div>
    
</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Canvia</div>
        </div>
    </div>
</footer>
</div>
</div>
<script> src="../confirmacion.js"</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> 
<script src="../../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>
</html>