<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('Conexion.php');

if (isset($_POST['usuario']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $usuario = validate($_POST['usuario']);
    $password = trim($_POST['password']);

    if (empty($usuario)) {
        header("Location: Index.php?error=El Usuario Es Requerido");
        exit();
    } elseif (empty($password)) {
        header("Location: Index.php?error=La clave Es Requerida");
        exit();
    } else {

        $Sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = mysqli_prepare($conexion, $Sql);
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['idu'] = $row['idu'];
                header("Location: Inicio.php");
                exit();
            } else {
                header("Location: Index.php?error=El usuario o la clave son incorrectas");
                exit();
            }
        } else {
            header("Location: Index.php?error=El usuario o la clave son incorrectas");
            exit();
        }
    }
} else {
    header("Location: Index.php");
    exit();
}
