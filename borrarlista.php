<?php
session_start();

include("Conexion.php");

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

    // Variables de conexión a la base de datos
    $hostDB = '127.0.0.1';
    $nombreDB = 'dblistas'; // Nombre de la base de datos
    $usuarioDB = 'root';
    $contrasenyaDB = '';

    try {
        // Conectar a la base de datos
        $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
        $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenyaDB);

        // Verifica que el elemento exista y que, via su lista, pertenezca al usuario logueado
        $miVerificacion = $miPDO->prepare(
            'SELECT elementos.id FROM elementos
             JOIN listas ON elementos.id_lista = listas.id
             WHERE elementos.id = :ID AND listas.idu = :IDU'
        );
        $miVerificacion->execute([
            ':ID' => $elementoId,
            ':IDU' => $idu,
        ]);

        if ($miVerificacion->rowCount() === 0) {
            // El elemento no existe o no es tuyo: no seguimos
            header('Location: Inicio.php');
            exit();
        }

        // Preparar la consulta de eliminación
        $miConsulta = $miPDO->prepare('DELETE FROM elementos WHERE id = :ID');

        // Ejecutar la consulta de eliminación
        $miConsulta->execute([
            ':ID' => $elementoId,
        ]);

        // Redireccionar a la página principal
        header('Location: Inicio.php');
        exit();
    } catch (PDOException $e) {
        // En caso de error, manejarlo apropiadamente, por ejemplo, redirigir a una página de error
        echo "Error en la base de datos: " . $e->getMessage();
    }
}

?>
