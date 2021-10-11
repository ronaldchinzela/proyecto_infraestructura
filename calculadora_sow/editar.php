<?php
    //llamando a la conexión de la bd
    include("../conexion.php");
    //obteniendo el id del sow que vamos a editar
    $id = $_GET["id"];
    //seleccionando todos los datos de la tabla sow_silver
    $sow = "SELECT * FROM sow WHERE codigo = '$id'";
?>
<?php
//realizando la conexión a la bd
     include 'conexion.php';
//creando variables y enlazando con su respectivo nombre de input
$vcpu = $_POST["vcpu"];
$ram = $_POST["ram"];
$disco = $_POST["disco"];
$mocloud = $_POST["mocloud"];
$mocot = $_POST["mocot_"];
$cotlicencia = $_POST["cotlicencia"];
$liwindows = $_POST["liwindow"];
$lilinux = $_POST["lilinux"];
$backup = $_POST["backup"];

//creando la sentencia sql que actualize los campos
$actualizar = "UPDATE sow SET cantidad_vcpu ='$vcpu', ram = '$ram',  disco = '$disco', mo_cloud_genes = '$mocloud',
mo_cot = '$mocot', cot_licencia = '$cotlicencia', licencia_windows = '$liwindows', licencia_linux = '$lilinux',
backup = '$backup' WHERE codigo = '$id'";

//creando método para validar datos iguales
/*$verificar_datos = mysqli_query($conexion, "SELECT * FROM sow WHERE cantidad_vcpu = '$vcpu' OR ram = '$ram' OR disco = '$disco' OR mo_cloud_genes = '$mocloud' OR mo_cot = '$mocot' OR cot_licencia = '$cotlicencia' OR licencia_windows = '$liwindows' OR licencia_linux = '$lilinux' OR backup = '$backup'");
if (mysqli_num_rows($verificar_datos) > 0){
    echo '<script>
            alert("Ya existe un SOW con los mismos datos");
            window.history.go(-1);
          </script>';
    exit;
}*/

//Ejecutando la consulta
$resultado = mysqli_query($conexion, $actualizar);
//validando el registro 
if($resultado){
    echo "<script> alert ('Se han actualizado los cambios correctamente');
    window.location='sow.php'; </script>";
}else{  
  echo "<script>alert('No se pudieron actualizar los registros'); 
    window.history.go(-1);</script>";
}