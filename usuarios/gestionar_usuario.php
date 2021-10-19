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
    <a class="nav-link" href="../reportes/resumen_servidores.php">
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
<div class="card-header-gestionar-usuario"></i><b id="b-gestionar-usuario">Gestionar usuario</b></div>
<div class="card-body-gestionar-usuario">

<!-- Tablas -->
<div class="table-responsive">
<table class="table table-bordered" id="tabla-gestionar-usuario" width="100%" cellspacing="0">
<br><br>    
<thead>
<!-- títulos de la tabla -->
<tr>
    <th>Usuario</th>
    <th>Rol</th>
    <th>Estado</th>
    <th>Editar</th>                                                
</tr>
</thead>

<!--paginador-->
<?php
//creando un query que nos traiga la cantidad de registros existentes
$sql_contador = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro FROM usuarios");
//creando una variable para almacenar los registros en un array
$resultado_contador = mysqli_fetch_array($sql_contador);
//creando una variable para acceder al resultado del campo total_registro
$total_registro = $resultado_contador['total_registro'];
//creando variable para almacenar la cantidad de registros por página
$por_pagina = 5;
//
if(empty($_GET['pagina']))
{
    $pagina = 1;
}else{
    $pagina = $_GET['pagina'];
}

$desde = ($pagina-1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);

//agregando las variables de la paginación al query de listar 
//creando query para listar los usuarios de la bd        
$query_lista_usuario = mysqli_query($conexion, "SELECT u.id_usuario, u.usuario, u.nombres, u.apellidos, u.correo, u.celular, u.estado, r.rol FROM usuarios u INNER JOIN rol r ON u.idrol = r.id                                           
                                            ORDER BY u.id_usuario ASC LIMIT $desde, $por_pagina");

//creando variable $resultado que almacene los datos extraidos del query
$resultado = mysqli_num_rows($query_lista_usuario);
//si el resultado obtenido es mayor a 0 significa que si hay registros
if($resultado > 0){
//listando  todos los registros encontrados en un bucle while
//que liste la cantidad de filas que extrae el query
while($data = mysqli_fetch_array($query_lista_usuario)){
?>
        
<tbody>
<tr>
<!-- llenando los datos de la variable $data en las filas de la tabla -->
    <td><?php echo $data["usuario"]; ?></td>
    <td><?php echo $data["rol"]; ?></td>
    <td><?php echo $data["estado"]; ?></td> 
                                                
    <td> <a href="actualizar_usuario.php?id_user=<?php echo $data["id_usuario"];?>" class="link_js_editar_usuario">editar</a>
    <!--creando condición para que el usuario administrador no pueda ser eliminado-->
    <?php if($data["usuario"] != 'admin'){ ?>
            |<!--creando variable id_user que reciba el id del usuario a eliminar-->
            <a href="eliminar_usuario.php?id_user=<?php echo $data["id_usuario"];?>" class="link_js_eliminar_usuario">remover</a>
    <!--cerrando el bloque php-->
    <?php } ?>
    </td>
</tr>
</tbody>

        <!-- cenrrando la llave del php -->
        <?php
    }
}  
?>
    </table>
<!--creando el páginador para los datos de la tabla-->
<div class="paginador">
    <ul>
        <?php
             if($pagina !=1)
             {
        ?>
        <li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
        <li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
        <?php
        }
             for($i=1; $i <= $total_paginas; $i++){
                 if($i == $pagina)
                 {
                    echo '<li class="pageSelected">'.$i.'</li>';
                 }else{
                    echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                 }
                 
             }
             if($pagina != $total_paginas)
             {
        ?>
        <li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
        <li><a href="?pagina=<?php echo $total_paginas; ?> ">>|</a></li>
        <?php } ?>
    </ul> 
    <!-- fin del paginador -->
</div>

</div>   
                       
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> 
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>
</html>