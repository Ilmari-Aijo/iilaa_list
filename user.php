<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dblistas";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Conexion fallida: " . mysqli_connect_error());
}

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
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #495057;
    margin: 0;
    }

    h2 {
        text-align: center;
        color: #007bff;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: #ffffff;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 15px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin: 8px 0;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #ffffff;
        padding: 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    #inicioBtn {
        background-color: #007bff;
        color: #ffffff;
        padding: 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        margin: 20px;
    }

    #inicioBtn:hover {
        background-color: #0056b3;
    }
</style>
<body>

<a href="inicio.php" id="inicioBtn">Inicio</a>

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

    <form method="post" action="" style="max-width: 400px; margin: 20px auto; padding: 15px; background-color: #fff; border: 1px solid #ddd; border-radius: 5px;">
        <input type="hidden" name="idu_edit" value="<?php echo $edit_row["idu"]; ?>">
        Nombre: <input type="text" name="nombre_edit" value="<?php echo $edit_row["nombre"]; ?>"><br>
        Usuario: <input type="text" name="usuario_edit" value="<?php echo $edit_row["usuario"]; ?>"><br>
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

</body>
</html>

<?php
// Cerrar conexión
mysqli_close($conexion);
?>
