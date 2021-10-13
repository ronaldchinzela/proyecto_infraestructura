<?php
     if (isset($_POST['dcc'])){                                           
        $cod = $_POST['codigo'];
        $serie = $_POST['serie'];
        $costo = $_POST['costo'];
        $alp = $_POST['alp'];
        $estado = $_POST['estado'];
        //validando que solo acepte enteros
        settype($idrol, 'integer');
        
        //creando la consulta
        $consulta = "INSERT INTO `dcc` (`codigo`,`serie`,`costo`,`alp`,`estado`)
                     VALUES($cod,'$serie','$costo','$alp','$estado')";
        $conexion->query($consulta);

        if($conexion->affected_rows < 0)
        {
            header("location: formulario_dcc.php?error=Error al registrar dcc");
        }else
        {
            header("location: formulario_dcc.php");
        }
     }
?>