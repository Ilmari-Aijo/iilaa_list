# Listas

App para hacer listas de compras. Cada usuario ve solo las suyas.
- Registro e inicio de sesion.
- Crear una lista (nombre y fecha).
- Agregar elementos: producto, cantidad, unidad de medida.
- Editar o borrar elementos y listas.
- Un usuario admin puede ver y administrar las cuentas.

## Tecnologia

PHP + MySQL (mysqli), Bootstrap, Font Awesome, JS.

## Instalacion (XAMPP)

1. Copiar la carpeta en `htdocs`.
2. Crear la base `dblistas` e importar `dblistas.sql`.
3. Revisar usuario/clave de MySQL en `Conexion.php`.
4. Abrir `Index.php`.

## Archivos principales

- `Inicio.php`: pantalla principal con las listas.
- `nuevolista.php`: crear lista.
- `modificarlista.php`, `agregarelemento.php`, `borrarlista.php`, `borrarlistacompleta.php`: editar y borrar.
- `funciones.php`: chequea que una lista/elemento sea del usuario antes de tocarla.
- `user.php`: panel de admin.
- `Conexion.php`: datos de conexion a la base.
- `Style.css`: estilos.

## Cambios recientes

- Contraseñas hasheadas y consultas preparadas (sin SQL injection).
- Verificacion de que cada lista/elemento sea del usuario antes de editar o borrar.
- `user.php` ahora exige sesion de admin.
- Diseño nuevo tipo Google Keep, con buscador.
- Se pueden agregar elementos a una lista ya creada sin recargar la pagina.
