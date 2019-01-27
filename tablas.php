<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});
session_start();
if (isset($_SESSION['conexion']['basedatos'])) {
    $host = $_SESSION['conexion']['host'];
    $usuario = $_SESSION['conexion']['user'];
    $pass = $_SESSION['conexion']['pass'];
    $base = $_SESSION['conexion']['basedatos'];
    $bd = new BBDD($host, $usuario, $pass, $base);
    $tablas = $bd->selectQuery("show tables");
} else {
    header("Location:index.php");
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tablas</title>
        <style>
            input[type=submit] {
                padding:5px 15px 10px 10px; 
                background:#ccc; 
                border:2;
                cursor:pointer;
                border-radius: 5px; 
                margin: 1em;
                font-size: 1em;
            }
        </style>
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
