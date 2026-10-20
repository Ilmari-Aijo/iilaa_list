<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    include_once('Conexion.php');

if (isset($_POST['usuario']) && isset($_POST['nombre']) && isset($_POST['password']) && isset($_POST['rpassword'])) {
    function validar($data){
        $data = trim($data);
        $data = htmlspecialchars($data);

        return $data;
    }


    $usuario =  validar($_POST['usuario']);
    $nombre =  validar($_POST['nombre']);
    $password =  trim($_POST['password']);
    $rpassword =  trim($_POST['rpassword']);

    $usuario_Datos = 'usuario=' . $usuario . '&nombre=' . $nombre;


    if (empty($usuario)) {
        header("location: CrearCuenta.php?error=El usuario es requerido&$usuario_Datos");
        exit();
    }elseif (empty($nombre)) {
        header("location: CrearCuenta.php?error=El nombre completo es requerido&$usuario_Datos");
        exit();
    }elseif (empty($password)) {
        header("location: CrearCuenta.php?error=La contraseña es requerida&$usuario_Datos");
        exit();
    }elseif (empty($rpassword)) {
        header("location: CrearCuenta.php?error=Repetir la contraseña es requerida&$usuario_Datos");
        exit();
    }elseif ($password !== $rpassword) {
        header("location: CrearCuenta.php?error=Las contraseñas no coinciden&$usuario_Datos");
        exit();
    }else {
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $query = $stmt->get_result();

        if (mysqli_num_rows($query) > 0) {
            header("location: CrearCuenta.php?error=El nombre de usuario ya existe&$usuario_Datos");
            exit();
        }else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql2 = "INSERT INTO usuarios(nombre, usuario, password) VALUES (?, ?, ?)";
            $stmt2 = $conexion->prepare($sql2);
            $stmt2->bind_param("sss", $nombre, $usuario, $passwordHash);
            $query2 = $stmt2->execute();

            if ($query2) {
                header("location: CrearCuenta.php?success=Usuario creado con exito!&$usuario_Datos");
                exit();
            }else {
                header("location: CrearCuenta.php?error=Error desconocido&$usuario_Datos");
                exit();
            }
        }
    }

}else {
    header("location: CrearCuenta.php");
    exit();
}