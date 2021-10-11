<?php
include ("../conexion.php");

//creando variable id para recibir el id a eliminar
$id = $_GET['id'];

//creando la consulta para eliminar
$eliminar = "DELETE FROM sow WHERE codigo = '$id'";

//creando variable resultado_eliminar que almacenará la ejecusión del query
$resultado_eliminar = mysqli_query($conexion, $eliminar);

if($resultado_eliminar){
    header("location: ../calculadora_sow/sow.php");
}else{
    echo"<script>alert('Ocurrió un error en la eliminación'); window.history.go(-1);</script>";
}

