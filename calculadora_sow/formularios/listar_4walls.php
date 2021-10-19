<?php
include("../../conexion.php");
//iniciando las sesiones
session_start();

//validando el cierre de sesión de la página
if(!isset($_SESSION['id_usuario'])){
//si el usuario cerró sesión, redireccionar a la página del login
    header("Location: ../../login/login.php");
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
    <link href="../../css/estilos.css" rel="stylesheet" />
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
    <a class="nav-link" href="../../reportes/consumo_recursos.php">
    <div class="sb-nav-link-icon"><i class="fas fa-angle-right"></i></div>
        Consumo Recursos TI</a>
    <a class="nav-link" href="../../reportes/tarifario.php">
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

<div class="card mb-4">
<div class="card-header-listar"></i><b id="listar-b">Costo Mantenimiento</b></div>
<div class="card-body-listar">

<!-- Fecha inicio-->
<h6 id="listar-h6-fecha">Fecha Inicio:</h6><input id="listar-fecha" type="date">

<!-- Fecha fin-->
<h6 id="listar-h6-fecha-fin">Fecha Fin:</h6><input id="listar-fecha-fin" type="date">

    <br><br>

<!-- botón consultar-->
<input class="boton-listar-consultar" type="button" value="consultar" onclick="location.href='../../calculadora_sow/formularios/listar_4walls.php'">
<!-- botón registrar-->
<input class="boton-listar-registrar" type="button" value="Registrar" onclick="location.href='../../calculadora_sow/formularios/formulario.php'">


<!-- Tablas -->
<div class="table-responsive-listar">
<table class="table table-bordered" id="dataTable-listar" width="100%" cellspacing="0">
<br><br>    
<thead>
    <tr>
        <th class="th01">Mes/año</th>
        <th class="th02">Código</th>
        <th class="th03">Proyecto</th>
        <th class="th04">Costo Mensual 4Walls</th>
        <th class="th05">Costo Nexsus</th>
        <th class="th06">Costo HP DC Care</th>
        <th class="th07">Total $</th>
        <th class="th08">Total S/.</th>                                              
    </tr>
</thead>   
<!-- creando query para listar los usuarios de la bd -->
<?php
    //creando el query del paginador
    //$sql_
    //
    
    $query_lista_formulario = mysqli_query($conexion, "SELECT * FROM 4walls");
    
    //creando variable $resultado que almacene los datos extraidos del query
    $resultado = mysqli_num_rows($query_lista_formulario);
    //si el resultado obtenido es mayor a 0 significa que si hay registros
    if($resultado > 0){
    //listando  todos los registros encontrados en un bucle while
    //que liste la cantidad de filas que extrae el query
        while($data = mysqli_fetch_array($query_lista_formulario)){
?>  
<tbody>
    <tr>
        <td><?php echo $data["mes"]; ?></td>
        <td><?php echo $data["idwalls"]; ?></td>
        <td><?php echo $data["proyecto"]; ?></td>
        <td><?php echo $data["c_mensual"]; ?></td>
        <td><?php echo $data["c_nexsus"]; ?></td>
        <td><?php echo $data["c_hp"]; ?></td>
        <td><?php echo $data["total_dolar"]; ?></td>
        <td><?php echo $data["total_soles"]; ?></td>
    </tr>                                     
</tbody>
<?php
    }
}  
?>
</table>
    
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
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>
</html>