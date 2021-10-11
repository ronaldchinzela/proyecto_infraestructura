<?php
//realizando la conexión a la bd
     include '../conexion.php';
//creando variables y enlazando con su respectivo nombre de input
$vcpu = $_POST["vcpu"];
$ram = $_POST["ram"];
$disco = $_POST["disco"];
$mocloud = $_POST["mocloud"];
$mocot = $_POST["mocot"];
$cotlicencia = $_POST["cotlicencia"];
$liwindows = $_POST["liwindows"];
$lilinux = $_POST["lilinux"];
$backup = $_POST["backup"];

//creando la consulta sql para insertar datos a la tabla
$insertar = "INSERT INTO sow(cantidad_vcpu, ram, disco, mo_cloud_genes, mo_cot, cot_licencia, licencia_windows, licencia_linux, backup) values ('$vcpu','$ram','$disco','$mocloud','$mocot','$cotlicencia','$liwindows','$lilinux','$backup')";

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
$resultado = mysqli_query($conexion, $insertar);
//validando el registro 
if(!$resultado){
    echo 'Ocurrió un error al registrar los datos';
}else{  
  echo '<script>
       alert("SOW registrado exitosamente");   
       window.location="sow.php";
     </script>';
}
//cerrando la conexión
mysqli_close($conexion);
