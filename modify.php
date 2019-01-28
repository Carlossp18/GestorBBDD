<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});
session_start();
if (isset($_SESSION['conexion']['tabla'])) {
    $host = $_SESSION['conexion']['host'];
    $usuario = $_SESSION['conexion']['user'];
    $pass = $_SESSION['conexion']['pass'];
    $base = $_SESSION['conexion']['basedatos'];
    $tabla = $_SESSION['conexion']['tabla'];
    $bd = new BBDD($host, $usuario, $pass, $base);
    $campos = $bd->nombresCamposPDO($tabla);
    $filas = $bd->selectQuery("select * from $tabla");
    if (isset($_POST['operar'])) {
        $_SESSION['conexion']['datos'] = $_POST['datos'];
        switch ($_POST['operar']) {
            case "editar":
                break;
            case "borrar":
                header("Location:gestionarTablas.php");
                break;
        }
    }
} else {
    header("location:tablas.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>modifica el valor</title>
    </head>
    <body>

    </body>
</html>

