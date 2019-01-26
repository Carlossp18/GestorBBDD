<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});

session_start();
$host = $_SESSION['conexion']['host'];
$usuario = $_SESSION['conexion']['user'];
$pass = $_SESSION['conexion']['pass'];
$base = $_SESSION['conexion']['basedatos'];
$bd = new BBDD($host, $usuario, $pass, $base);
$tablas = $bd->selectQuery("show tables");
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tablas</title>
    </head>
    <body>
        <?php
        foreach ($tablas as $tabla) {
            foreach ($tabla as $t) {
                echo "<input type = 'submit' name='tabla' value='$t'>";
            }
        }
        ?>
    </body>
</html>
