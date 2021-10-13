<?php
include '../conexion.php';

//registrar nuevo usuario
if (isset($_POST['user'])){                                           
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
 $correo = $_POST['correo'];
$celular = $_POST['celular'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$idrol = $_POST['rol'];
//validando que solo acepte enteros
settype($idrol, 'integer');
                                            
//creando la consulta
$consulta = "INSERT INTO usuarios(usuario,password,nombres,idrol,apellidos,correo,celular)
              VALUES('$usuario',SHA1('$password'),'$nombres','$idrol','$apellidos','$correo','$celular')";
$conexion->query($consulta);

if($conexion->affected_rows < 0)
{
header("location: gestionar_usuario.php?error=Error al registrar usuario");
}else
{
   header("location: gestionar_usuario.php");
      }
   }
?>