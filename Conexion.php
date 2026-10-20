<?php

    $host = "localhost";
    $User = "root";
    $pass = "";

    $db = "dblistas";

    $conexion = mysqli_connect($host, $User , $pass, $db);

    if (!$conexion) {
     echo "Conexion fallida";
    }

?>