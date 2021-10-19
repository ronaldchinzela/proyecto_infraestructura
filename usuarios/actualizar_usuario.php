<?php
	//iniciando las sesiones
	session_start();
	
    //validando el cierre de sesión de la página
	if(!isset($_SESSION['id_usuario'])){
    //si el usuario cerró sesión, redireccionar a la página del login
		header("Location: ../login/login.php");
	}
	
//creando el nombre del usuario que inicia sesión 
//$nombres = $_SESSION['nombres'];
//$apellidos = $_SESSION['apellidos'];

//creando variable para el tipo de usuario que inicia sesión
//$idrol = $_SESSION['idrol'];
?> 

<!-- Código php para actualizar el usuario -->
<?php
include "../conexion.php";
//validando que todos los campos del formulario estén llenos antes de actualizar
if(!empty($_POST))
{   
//si todos los campos del formulairo están vacios
$alert='';
if(empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['correo']) || empty($_POST['celular']) || empty($_POST['usuario']) || empty($_POST['rol']) || empty($_POST['estado']))
{
    //se mostrará la siguiente alerta
    $alert='<p class="msg_error">¡Completar todos los campos!</p>'; 
}else{    
//almacenando en variables el name de los input
//el método $_POST['idusuario'] es invocado en el name del input codigo de usuario
$idusuario = $_POST['idusuario'];                            
$nombre = $_POST['nombres'];
$apellido = $_POST['apellidos'];
$correo = $_POST['correo'];
$cel = $_POST['celular'];
$user = $_POST['usuario'];
$pass = md5($_POST['password']);
$rol = $_POST['rol'];
$estado = $_POST['estado'];

//validando que el usuario registrado no se repita con otro existente en la bd
//ejecuntando el query a traves de la $conexion
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE 
                                    (usuario = '$user' AND id_usuario != $idusuario) 
                                    OR (correo = '$correo' AND id_usuario != $idusuario) ");
//el resultado lo devolverá por medio de un array y lo almacenará en la variable $result
$resulta = mysqli_fetch_array($query);

//validando la variable $result si es mayor a 0 significará que si hay registro
if($resulta > 0){
    $alert='<p class="msg_error">¡El usuario o el correo ya existe!</p>';
}else{
    if(empty($_POST['password']))
    {
        $sql_update = mysqli_query($conexion, "UPDATE usuarios SET nombres = '$nombre', apellidos = '$apellido', 
                                                correo = '$correo', celular = '$cel', usuario = '$user',
                                                idrol  = '$rol', estado = '$estado' 
                                                WHERE id_usuario  = $idusuario");
    }else{
        $sql_update = mysqli_query($conexion, "UPDATE usuarios SET nombres = '$nombre', apellidos = '$apellido', 
                                                correo = '$correo', celular = '$cel', usuario = '$user',
                                                password = '$pass', idrol  = '$rol', estado = '$estado' 
                                                WHERE id_usuario  = $idusuario");

    }
                                                    
        //validando si los datos se an insertado en la bd 
        if($sql_update){
            $alert='<p class="msg_save">¡Usuario actualizado correctamente!</p>';
        }else{
            $alert='<p class="msg_error">¡Ocurrió un error al actualizar el usuario!</p>';
    }
    }
}
}
                                        /*Fin del codigo php para actualizar */

//validando si en la página no existe un usuario seleccionado
if(empty($_GET['id_user']))
{
header('Location: gestionar_usuario.php');
}
//validando que el id_user enviado en la url, exista en la bd 
//luego creo un query que traiga todos los campos seleccionado de un determinado usuario
$iduser = $_GET['id_user'];
$sql = mysqli_query($conexion, "SELECT u.id_usuario, u.nombres, u.password, u.apellidos, u.correo, u.usuario, u.celular, u.estado, (u.idrol)
                            AS id_rol, (r.rol) AS rol FROM usuarios u INNER JOIN rol r ON u.idrol = r.id 
                            WHERE id_usuario = $iduser");
//guardando la consulta en una variable que almacene el número de filas del query
$result_sql = mysqli_num_rows($sql);
//validando si el resultado obtenido es 0 filas
if($result_sql == 0){
header ('Location: gestionar_usuario.php');
}else{
$option = '';
while($data = mysqli_fetch_array($sql)){
    //almacenando en variables los datos obtenidos del query $sql
    //igualo las variables al name de los input
    //luego las variables lo imprimo en el value de los input
    $iduser = $data['id_usuario'];
    $nombres = $data['nombres'];
    $apellidos = $data['apellidos'];
    $correo = $data['correo'];
    $celular = $data['celular'];
    $usuario = $data['usuario'];
    $password = $data['password'];
    $idrol = $data['id_rol'];
    $rol = $data['rol'];
    $estado = $data['estado'];
                        
    //trayendo los datos del combobox rol
    if($idrol == 1){
        $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
        }else{
        $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
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
        <div class="card-header-gestionar-usuario"></i><b id="b-nuevo-usuario">Actualizar usuario</b></div>
        <div class="card-body">

        <!-- Formulario -->
                                                                                                
                <!-- creando div que muestre una alerta al registrar un usuario -->
                <div class="alert-actualizar"><?php echo isset($alert) ? $alert : ''; ?></div>
            <!---->
            <form id="form-editar-usuario" action="" method="post">
                <input type="hidden" name="idusuario" value="<?php echo $iduser ; ?>">
                <span id="span-nombre">Nombres: <input type="text" name="nombres" id="input-nombre-nuevo-usuario" placeholder="Ingrese el nombre" value="<?php echo $nombres ; ?>"></span><br>
                <span id="span-apellido">Apellidos: <input type="text" name="apellidos" id="input-apellido-nuevo-usuario" placeholder="Ingrese los apellidos" value="<?php echo $apellidos ; ?>"></span><br>
                <span id="span-correo">Correo: <input type="email" name="correo" id="input-correo-nuevo-usuario" placeholder="Ingrese el correo" value="<?php echo $correo ; ?>"></span><br>
                <span id="span-celular">Celular: <input type="text" name="celular" id="input-celular-nuevo-usuario" placeholder="Ingrese número de celular" value="<?php echo $celular ; ?>"></span><br>
                <span id="span-password">Usuario: <input type="text" name="usuario" id="input-password-nuevo-usuario" placeholder="Escriba el usuario" value="<?php echo $usuario ; ?>"></span><br>
                <span id="span-password">Password: <input type="password" name="password" id="input-password-nuevo-usuario" placeholder="Escriba una contraseña" value="<?php echo $password ; ?>"></span><br>
                <!-- Combobox -->
                <label for="rol" class="label-rol">Rol:</label>
                <!-- creando query para traer los roles de la bd-->
                <?php
                        $query_rol = mysqli_query($conexion, "SELECT * FROM rol");
                        //contando las filas que va devolver el query
                        $result_rol = mysqli_num_rows($query_rol);                                
                ?>
                <select name="rol" class="cbo-rol">
                <!--<option selected="true" disabled="disabled">Seleccionar</option> -->
                    <?php
                        echo $option;
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
                <label for="rol" class="label-estado" >Estado:</label>
                <select id="cbo-estado" name="estado" >                                 
                    <option selected = "true">Inactivo</option>  
                    <option selected = "true">Activo</option>                                    
                </select><br>
                <input class="btn-editar-usuario" type="submit" value="Actualizar usuario">
                <input class="ver-listado-usuarios-2" type="button" value="Volver al listado" onclick="location.href='../usuarios/gestionar_usuario.php'">  
            </form>                                                                           
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