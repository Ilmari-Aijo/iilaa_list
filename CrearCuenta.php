<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Registrarse</title>
</head>
<body>    
        <header>
            <h1 class="h1login">Listas</h1>
        </header>
        <form action="Registrarse.php" method="POST">
        

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php }?>
            
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"> <?php echo $_GET['success']; ?></p>
            <?php }?>
            
            <div class="contenedor">
            <h1 class="h1login">Registrarse</h1>
            <label for="">
                <i class="fa-solid fa-users"></i>
                Nombre completo
            </label>
            <input type="text" placeholder="Ingrese nombre completo" name="nombre"  autocomplete="off">
            
            <label for="">
            <i class="fa-solid fa-user"></i>
                Usuario
            </label>
            <input type="text" placeholder="Ingrese usuario" name="usuario"  autocomplete="off">

            <label for="">
            <i class="fa-solid fa-key"></i>
                Clave
            </label>
            <input type="password" placeholder="Ingrese Clave" name="password" >
            <label for="">
            <i class="fa-solid fa-key"></i>
                Repetir Clave
            </label>
            <input type="password" placeholder="Repita Clave" name="rpassword" >
            <br>
            <button type="submit" value="Registrarse">Registrarse</button>
            <a href="Index.php" class="Boton_Ingresar">
                Ingresa
            </a>
            </div>
        </form>
    <footer>
        <p>Copyright &copy; 2023</p>
    </footer>
</body>
</html>