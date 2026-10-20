<?php
session_start();

// Conexión a la base de datos (incluye tu archivo de conexión)
include('Conexion.php');
include('funciones.php');

header('Content-Type: application/json');

// Verifica que haya una sesion iniciada
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesion']);
    exit();
}

$idu = $_SESSION['idu'];

// Recibe los datos del formulario
$listaId = $_POST['listaId'];
$nombreElemento = $_POST['nombre_elemento'];
$unidades = $_POST['unidades'];
$medida = $_POST['medida'];

// Verifica que la lista exista y pertenezca al usuario logueado
if (!obtenerListaDeUsuario($conexion, $listaId, $idu)) {
    echo json_encode(['success' => false, 'message' => 'Esa lista no existe o no te pertenece']);
    exit();
}

// Prepara la sentencia INSERT para agregar el elemento a la base de datos
$sql = "INSERT INTO elementos (id_lista, nombre, unidades, medida) VALUES (?, ?, ?, ?)";
$consulta = $conexion->prepare($sql);
$consulta->bind_param("isss", $listaId, $nombreElemento, $unidades, $medida);

// Intenta ejecutar la consulta
if ($consulta->execute()) {
    // Inserción exitosa
    $respuesta = ['success' => true, 'message' => 'Elemento agregado con éxito'];
} else {
    // Error en la inserción
    $respuesta = ['success' => false, 'message' => 'Error al agregar el elemento'];
}

echo json_encode($respuesta);
?>
