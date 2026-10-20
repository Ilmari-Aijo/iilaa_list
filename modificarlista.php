<?php
session_start();
include('Conexion.php');

// Verifica que haya sesion iniciada
if (!isset($_SESSION['usuario'])) {
    header('Location: Index.php');
    exit();
}

$idu = $_SESSION['idu'];
$elementoId = isset($_REQUEST['elementoId']) ? $_REQUEST['elementoId'] : null;

// Verifica que el elemento exista y que, via su lista, pertenezca al usuario logueado
$sqlVerificar = "SELECT elementos.* FROM elementos
    JOIN listas ON elementos.id_lista = listas.id
    WHERE elementos.id = ? AND listas.idu = ?";
$stmtVerificar = mysqli_prepare($conexion, $sqlVerificar);
mysqli_stmt_bind_param($stmtVerificar, "ii", $elementoId, $idu);
mysqli_stmt_execute($stmtVerificar);
$resultVerificar = mysqli_stmt_get_result($stmtVerificar);

if (mysqli_num_rows($resultVerificar) === 0) {
    // El elemento no existe o no es tuyo: no seguimos
    header('Location: Inicio.php');
    exit();
}

$elemento = mysqli_fetch_assoc($resultVerificar);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobamos si el formulario se envió y procesamos la actualización
    $nombre_elemento = $_POST['nombre_elemento'];
    $unidades = $_POST['unidades'];
    $medida = $_POST['medida'];

    // Preparamos la consulta UPDATE
    $miUpdate = "UPDATE elementos SET nombre = ?, unidades = ?, medida = ? WHERE id = ?";
    $stmtUpdate = mysqli_prepare($conexion, $miUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "sssi", $nombre_elemento, $unidades, $medida, $elementoId);
    mysqli_stmt_execute($stmtUpdate);

    // Redirigimos a la página principal
    header('Location: Inicio.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Modificar Elemento</title>
</head>
<body>
    <header>
        <h1 class="h1login">Listas</h1>
    </header>
    <a href="Inicio.php">Regresar</a>
    <form method="post">
        <p>
            <label for="nombre_elemento">Nombre del Elemento</label>
            <input id="nombre_elemento" type="text" name="nombre_elemento" value="<?= isset($elemento['nombre']) ? $elemento['nombre'] : '' ?>" required>
        </p>
        <p>
            <label for="unidades">Unidades</label>
            <input id="unidades" type="text" name="unidades" value="<?= isset($elemento['unidades']) ? $elemento['unidades'] : '' ?>" required>
        </p>
        <p>
            <label for="medida">Medida</label>
            <input id="medida" type="text" name="medida" value="<?= isset($elemento['medida']) ? $elemento['medida'] : '' ?>" required>
        </p>
        <input type="hidden" name="elementoId" value="<?= $elementoId ?>">
        <input type="submit" value="Modificar">
    </form>
    <footer>
        <p>Copyright &copy; 2023</p>
    </footer>
</body>
</html>


