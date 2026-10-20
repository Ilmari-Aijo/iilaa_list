<?php

    $host = "localhost";
    $user = "root";
    $pass = "";

    $db = "dblistas";

    $conexion = mysqli_connect($host, $user, $pass, $db);

    if (!$conexion) {
        die("Conexion fallida: " . mysqli_connect_error());
    }

?>