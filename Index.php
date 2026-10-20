<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inicio de sesion</title>
</head>
<body>
    <header>
        <h1 class="h1login">Listas</h1>
    </header>
    <br>
    <form action="IniciarSesion.php" method="POST">
        <h1 class="h1login">INICIAR SESION</h1>
        <hr>
        <?php
        
            if (isset($_GET['error'])) {
            ?>
            <p class="error">
                <?php
                echo $_GET['error']
                ?>
                
            </p>
        <?php    
            }
        ?>

        <hr>
        
        <div class="login-form">
        <i class="fa-solid fa-user"></i>
        <label>Usuario</label>
        <input type="text" name="usuario" placeholder="Usuario">

        <i class="fa-solid fa-unlock"></i>
        <label>Contraseña</label>
        <input type="password" name="password" placeholder="Contraseña">
        <hr>
        <button type="submit">Iniciar Sesion</button>
        <a href="CrearCuenta.php">Crear Cuenta</a>
        </div>
    </form>
    <footer>
        <p>Copyright &copy; 2023</p>
    </footer>
</body>
</html>