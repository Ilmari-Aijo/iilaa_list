<?php
include('Conexion.php');

// Manejo de la eliminación de usuarios
if (isset($_GET["delete"])) {
    $idu_delete = $_GET["delete"];

    // Obtener información del usuario antes de eliminar
    $info_sql = "SELECT usuario FROM usuarios WHERE idu=$idu_delete";
    $info_result = mysqli_query($conexion, $info_sql);
    $user_info = mysqli_fetch_assoc($info_result);

    // Verificar si el usuario es "ilmari" antes de eliminar
    if ($user_info["usuario"] !== "ilmari") {
        // Eliminar usuario de la base de datos
        $delete_sql = "DELETE FROM usuarios WHERE idu=$idu_delete";
        if (mysqli_query($conexion, $delete_sql)) {
            echo "<script>alert('Usuario eliminado correctamente');</script>";
        } else {
            echo "<script>alert('Error al eliminar usuario');</script>";
        }
    } else {
        echo "<script>alert('No se puede eliminar al usuario ilmari');</script>";
    }
}

// Manejo de la edición de usuarios
if (isset($_POST["idu_edit"])) {
    $idu_edit = $_POST["idu_edit"];
    $nombre_edit = $_POST["nombre_edit"];
    $usuario_edit = $_POST["usuario_edit"];

    // Actualizar información del usuario en la base de datos
    $update_sql = "UPDATE usuarios SET nombre='$nombre_edit', usuario='$usuario_edit' WHERE idu=$idu_edit";
    if (mysqli_query($conexion, $update_sql)) {
        echo "<script>alert('Usuario actualizado correctamente');</script>";
        // Redirigir al usuario a la página principal
        header("Location: user.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar usuario');</script>";
    }
}

// Consulta SQL para obtener usuarios
$sql = "SELECT idu, nombre, usuario FROM usuarios";
$result = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Usuarios Registrados</title>
</head>
<body class="admin-page">
    <header>
        <h1 class="h1login">Listas</h1>
    </header>

    <a href="Inicio.php" class="volver">Inicio</a>

    <h2>Usuarios Registrados</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Acciones</th>
    </tr>

    <?php
    // Mostrar usuarios en la tabla
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["idu"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["usuario"] . "</td>";
        echo "<td>
                <a href='?edit=" . $row["idu"] . "'>Editar</a>
                <a href='?delete=" . $row["idu"] . "' onclick='return confirmarBorrado()'>Eliminar</a>
              </td>";
        echo "</tr>";
    }
    ?>

</table>

<?php
// Formulario de edición
if (isset($_GET["edit"])) {
    $idu_edit = $_GET["edit"];
    $edit_sql = "SELECT idu, nombre, usuario FROM usuarios WHERE idu=$idu_edit";
    $edit_result = mysqli_query($conexion, $edit_sql);
    $edit_row = mysqli_fetch_assoc($edit_result);
    ?>

    <form method="post" action="">
        <input type="hidden" name="idu_edit" value="<?php echo $edit_row["idu"]; ?>">
        <label for="nombre_edit">Nombre</label>
        <input id="nombre_edit" type="text" name="nombre_edit" value="<?php echo $edit_row["nombre"]; ?>">
        <label for="usuario_edit">Usuario</label>
        <input id="usuario_edit" type="text" name="usuario_edit" value="<?php echo $edit_row["usuario"]; ?>">
        <input type="submit" value="Guardar cambios">
    </form>

    <?php
}
?>

<script>
    function confirmarBorrado() {
        return confirm("¿Estás seguro de que deseas borrar este usuario?");
    }
</script>

    <footer>
        <p>Copyright &copy; 2026</p>
    </footer>
</body>
</html>

<?php
// Cerrar conexión
mysqli_close($conexion);
?>
