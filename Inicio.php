<?php
session_start();

include('Conexion.php');

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.php"); // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    exit();
}

// El usuario ha iniciado sesión, puedes acceder a sus datos
$usuario = $_SESSION['usuario'];
$nombre = $_SESSION['nombre'];
$idu = $_SESSION['idu'];

// Consulta para obtener las listas del usuario actual
$miConsulta = "SELECT listas.id, listas.nombre AS nombre_lista, listas.fecha, elementos.id AS elemento_id, elementos.nombre AS nombre_elemento, elementos.unidades, elementos.medida, usuarios.nombre AS nombre_usuario
FROM listas
JOIN elementos ON listas.id = elementos.id_lista
JOIN usuarios ON listas.idu = usuarios.idu
WHERE listas.idu = ?"; // Solo selecciona las listas del usuario actual

$consulta = $conexion->prepare($miConsulta);
$consulta->bind_param("i", $idu); // Asocia el ID de usuario
$consulta->execute();
$resultado = $consulta->get_result();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    
</head>

    <body>
        <header>
            <h1 class="h1login">Listas Block de notas</h1>
        </header>
        <CENTER>
            <H1 class="h1login">Listas</H1>
        </CENTER>
        <?php
        // Verifica si el usuario actual es Admin para mostrar el botón
        if ($usuario === 'admin' || $usuario === 'Admin') {
            echo '<a href="user.php" class="admin">ADMIN</a>';
        }

        ?>
        <div class="btncs">
            <a id="nuevolista" href="nuevolista.php">
                <i class="fas fa-plus"></i>
            </a>
            <a href="CerrarSesion.php" class="btn btn-danger">Cerrar Sesion</a>
        </div>

        <br>

        <?php
        $currentListId = null;
        while ($fila = $resultado->fetch_assoc()) :
            if ($currentListId !== $fila['id']) {
                if ($currentListId !== null) {
                    echo '<form id="formBorrarLista' . $currentListId . '" action="borrarlistacompleta.php" method="post" style="display: none;">';
                    echo '<input type="hidden" name="listaId" value="' . $currentListId . '">';
                    echo '</form>';
                    echo '<button class="btn btn-danger" onclick="confirmarBorradoLista(' . $currentListId . ')">Borrar Lista Completa</button>';
                    echo '</div>'; // Cerrar la tarjeta anterior
                }
                echo '<div class="lista-card">';
                echo '<p class="lista-header">' . $fila['id'] . ':' . $fila['nombre_lista'] . ' - Fecha: ' . $fila['fecha'] . '</p>';
                $currentListId = $fila['id'];
            }
        ?>
            <div class="elemento" data-elemento-id="<?= $fila['elemento_id'] ?>">
                <p><?= $fila['nombre_elemento']; ?> (<?= $fila['unidades']; ?> <?= $fila['medida']; ?>)</p>
                <p>Usuario: <?= $fila['nombre_usuario'] ?></p>
                <a href="modificarlista.php?elementoId=<?= $fila['elemento_id'] ?>">Modificar</a>

                <!-- Modifica el botón de borrado -->
                <button id="trash" class="btn btn-link" onclick='return confirmarBorrado(<?= $fila['elemento_id'] ?>)'>
                    <i class="fas fa-trash"></i>
                </button>

                <!-- Agrega un formulario de confirmación con el elementoId -->
                <form id="formBorrar<?= $fila['elemento_id'] ?>" action="borrarlista.php" method="post" style="display: none;">
                    <input type="hidden" name="elementoId" value="<?= $fila['elemento_id'] ?>">
                </form>

            </div>
        <?php
        endwhile;

        if ($currentListId !== null) {
            echo '<form id="formBorrarLista' . $currentListId . '" action="borrarlistacompleta.php" method="post" style="display: none;">';
            echo '<input type="hidden" name="listaId" value="' . $currentListId . '">';
            echo '</form>';
            echo '<button class="btn btn-danger" onclick="confirmarBorradoLista(' . $currentListId . ')">Borrar Lista Completa</button>';
            echo '</div>'; // Cerrar la última tarjeta
        }
        ?>
        <br>

        <footer>
            <p>Copyright &copy; 2023</p>
        </footer>
    </body>
    <script>
        function confirmarBorradoLista(listaId) {
            var confirmacion = confirm("¿Estás seguro de que deseas borrar esta lista completa?");

            if (confirmacion) {
                // Enviar el formulario de confirmación con el listaId
                document.getElementById('formBorrarLista' + listaId).submit();
            }
        }
    </script>
    <script>
            function confirmarBorrado(elementoId) {
                var confirmacion = confirm("¿Estás seguro de que deseas borrar este elemento?");

                if (confirmacion) {
                    // Enviar el formulario de confirmación
                    document.getElementById('formBorrar' + elementoId).submit();
                    return true;
                } else {
                    return false;
                }
            }
        </script>
</html>