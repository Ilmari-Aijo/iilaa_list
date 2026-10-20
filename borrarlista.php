<?php
session_start();

include("Conexion.php");
include("funciones.php");

// Verifica que haya sesion iniciada
if (!isset($_SESSION['usuario'])) {
    header('Location: Index.php');
    exit();
}

$idu = $_SESSION['idu'];

// Verificar si se ha enviado un formulario de confirmación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['elementoId'])) {
    // Procesar el borrado del elemento aquí
    $elementoId = $_POST['elementoId'];

    // Verifica que el elemento exista y que, via su lista, pertenezca al usuario logueado
    if (!obtenerElementoDeUsuario($conexion, $elementoId, $idu)) {
        // El elemento no existe o no es tuyo: no sigue
        header('Location: Inicio.php');
        exit();
    }

    // Preparar y ejecutar la consulta de eliminación
    $miConsulta = "DELETE FROM elementos WHERE id = ?";
    $stmtBorrar = mysqli_prepare($conexion, $miConsulta);
    mysqli_stmt_bind_param($stmtBorrar, "i", $elementoId);
    mysqli_stmt_execute($stmtBorrar);

    header('Location: Inicio.php');
    exit();
}

?>
