<?php
session_start();

include('Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si el usuario ha iniciado sesión
    if (isset($_SESSION['usuario'])) {
        // Recopila las variables
        $nombreLista = isset($_POST['nombre_lista']) ? $_POST['nombre_lista'] : null;
        $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;

        // Obtén el ID de usuario activo desde la sesión
        $nombreUsuario = $_SESSION['usuario'];

        // Verifica la conexión a la base de datos (asumiendo que tu conexión se encuentra en Conexion.php)
        if ($conexion === false) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta para obtener el ID de usuario
        $sql = "SELECT idu FROM usuarios WHERE usuario = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bind_param("s", $nombreUsuario);
        $consulta->execute();
        $consulta->bind_result($idu);

        if ($consulta->fetch()) {
            // Cierra la consulta de obtener el ID de usuario
            $consulta->close();

            // Prepara la sentencia INSERT para la lista
            $miInsertLista = "INSERT INTO listas (nombre, fecha, idu) VALUES (?, ?, ?)";
            $stmtLista = mysqli_prepare($conexion, $miInsertLista);

            if ($stmtLista) {
                mysqli_stmt_bind_param($stmtLista, "ssi", $nombreLista, $fecha, $idu);
                mysqli_stmt_execute($stmtLista);
                $listaId = mysqli_insert_id($conexion); // Obtén el ID de la lista recién creada

                if (isset($_POST['elemento'])) {
                    // Prepara la sentencia INSERT para los elementos de la lista
                    $miInsertElemento = "INSERT INTO elementos (id_lista, nombre, unidades, medida) VALUES (?, ?, ?, ?)";
                    $stmtElemento = mysqli_prepare($conexion, $miInsertElemento);

                    if ($stmtElemento) {
                        foreach ($_POST['elemento'] as $elemento) {
                            mysqli_stmt_bind_param($stmtElemento, "ssss", $listaId, $elemento['nombre_elemento'], $elemento['unidades'], $elemento['medida']);
                            mysqli_stmt_execute($stmtElemento);
                        }
                        mysqli_stmt_close($stmtElemento);
                    }
                }

                mysqli_stmt_close($stmtLista);
                header('Location: Inicio.php');
                exit();
            } else {
                echo "Error en la consulta SQL para la lista: " . mysqli_error($conexion);
            }
        } else {
            echo "No se encontró un usuario con el nombre '$nombreUsuario'";
        }
    } else {
        // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
        header('Location: Index.php');
        exit();
    }
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

    <title>Nueva Lista</title>
</head>
<body>
    <header>
        <h1 class="h1login">Listas</h1>
    </header>
    <br>
    <a href="Inicio.php">Regresar</a>
<h1>Nueva Lista de Mercado</h1>
    <form action="" method="post">
        <p>
            <label for="nombre_lista">Nombre de la Lista</label>
            <input id="nombre_lista" type="text" name="nombre_lista">
        </p>
        <p>
            <label for="fecha">Fecha</label>
            <input id="fecha" type="date" name="fecha">
        </p>
        <h2>Elementos de la Lista</h2>
        <div id="elementos">
            <div class="elemento">
                <p>Elemento 1:</p>
                <p>
                    <label for="elemento[0][nombre_elemento]">Nombre del Elemento</label>
                    <input type="text" name="elemento[0][nombre_elemento]">
                </p>
                <p>
                    <label for="elemento[0][unidades]">Unidades</label>
                    <input type="text" name="elemento[0][unidades]">
                </p>
                <p>
                    <label for="elemento[0][medida]">Medida</label>
                    <input type="text" name="elemento[0][medida]">
                </p>
            </div>
        </div>
        <button type="button" id="agregarElemento">Agregar Elemento</button>
        <input type="submit" value="Guardar">
    </form>

    <script>
        let elementoCount = 1;

        document.getElementById('agregarElemento').addEventListener('click', function () {
            const elementosDiv = document.getElementById('elementos');
            const elementoDiv = document.createElement('div');
            elementoDiv.className = 'elemento';
            elementoDiv.innerHTML = `
                <p>Elemento ${elementoCount + 1}:</p>
                <p>
                    <label for="elemento[${elementoCount}][nombre_elemento]">Nombre del Elemento</label>
                    <input type="text" name="elemento[${elementoCount}][nombre_elemento]">
                </p>
                <p>
                    <label for="elemento[${elementoCount}][unidades]">Unidades</label>
                    <input type="text" name="elemento[${elementoCount}][unidades]">
                </p>
                <p>
                    <label for="elemento[${elementoCount}][medida]">Medida</label>
                    <input type="text" name="elemento[${elementoCount}][medida]">
                </p>
            `;
            elementosDiv.appendChild(elementoDiv);
            elementoCount++;
        });
    </script>
    <footer>
    <p>Copyright &copy; 2023</p>
    </footer>
</body>
</html>
