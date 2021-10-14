<?php
include ("../conexion.php");

$id_usuario = $_POST['txtid']; 
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$estado = $_POST['estado'];
        
$consulta2="UPDATE usuarios SET nombres = '$nombres',apellidos = '$apellidos',correo = '$correo',celular = 
'$celular',usuario = '$usuario',password = SHA1('$password'),estado = '$estado' WHERE id_usuario='$id_usuario'";
$resultado = mysqli_query($conexion,$consulta2);

if($resultado){
    echo "<script>alert('Usuario se actualizó correctamente'); window.location='../usuarios/gestionar_usuario.php';</script>";
}else {
    echo "<script>alert('Erro en la actualización'); window.location='../usuarios/actualizar_usuario.php';</script>";
}

?>

    