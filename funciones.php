<?php


// Devuelve los datos completos del elemento fila de la tabla 'elementos'
// Si no existe o no es del usuario, devuelve null.
function obtenerElementoDeUsuario($conexion, $elementoId, $idu)
{
    $sql = "SELECT elementos.* FROM elementos
        JOIN listas ON elementos.id_lista = listas.id
        WHERE elementos.id = ? AND listas.idu = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $elementoId, $idu);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila ?: null;
}

// Devuelve los datos completos de la lista fila de la tabla 'listas'
// si existe y pertenece al usuario indicado, si no devuelve null.
function obtenerListaDeUsuario($conexion, $listaId, $idu)
{
    $sql = "SELECT * FROM listas WHERE id = ? AND idu = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $listaId, $idu);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila ?: null;
}

?>
