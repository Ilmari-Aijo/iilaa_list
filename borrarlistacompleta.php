<?php
session_start();

include('Conexion.php');

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.php"); // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    exit();
}

$idu = $_SESSION['idu'];

// Verifica si se recibió el ID de la lista a borrar
if (isset($_POST['listaId'])) {
    $listaId = $_POST['listaId'];

    // Verifica que la lista pertenezca al usuario logueado antes de borrar nada
    $sqlVerificar = "SELECT id FROM listas WHERE id = ? AND idu = ?";
    $stmtVerificar = $conexion->prepare($sqlVerificar);
    $stmtVerificar->bind_param("ii", $listaId, $idu);
    $stmtVerificar->execute();
    $resultadoVerificar = $stmtVerificar->get_result();

    if ($resultadoVerificar->num_rows === 0) {
        // La lista no existe o no es tuya: no seguimos
        header("Location: Inicio.php");
        exit();
    }

    // Elimina la lista y sus elementos asociados
    $borrarListaQuery = "DELETE FROM listas WHERE id = ?";
    $borrarElementosQuery = "DELETE FROM elementos WHERE id_lista = ?";

    $stmtLista = $conexion->prepare($borrarListaQuery);
    $stmtLista->bind_param("i", $listaId);
    $stmtLista->execute();

    $stmtElementos = $conexion->prepare($borrarElementosQuery);
    $stmtElementos->bind_param("i", $listaId);
    $stmtElementos->execute();

    // Redirige de nuevo a la página principal después de borrar la lista
    header("Location: Inicio.php");
    exit();
} else {
    // Si no se recibió el ID de la lista, redirige a la página principal
    header("Location: Inicio.php");
    exit();
}
?>
