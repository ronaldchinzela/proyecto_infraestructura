<?php
include ("../conexion.php");

//creando variable id para recibir el id del href eliminar
$id_usuario = $_GET['id_user'];

//creando la consulta para eliminar
$eliminar_usuario = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";

//creando variable resultado_eliminar que almacenará la ejecusión del query
$resultado_eliminar_usuario = mysqli_query($conexion, $eliminar_usuario);

if($resultado_eliminar_usuario){
    header("location: ../usuarios/gestionar_usuario.php");
}else{
    echo"<script>alert('Ocurrió un error en la eliminación'); window.history.go(-1);</script>";
}

