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
        switch ($_POST['operar']) {
            case "editar":
                break;
            case "borrar":
                break;
        }
    }
} else {
    header("location:tablas.php");
    exit();
}

function mostrarTabla($campos, $filas) {
    echo"<table><tr>";
    foreach ($campos as $campo) {
        echo"<th>$campo</th>";
    }
    echo"</tr>";
    foreach ($filas as $fila) {
        echo "<form action='gestionarTabla.php' method='POST'><tr>";
        foreach ($fila as $f) {
            echo "<td>$f</td>";
        }
        echo"<td><input type='submit' name='gestionar' value='editar'></td>"
        . "<td><input type='submit' name='gestionar' value='borrar'></td>";
        echo"</tr></form>";
    }
    echo "</table>";
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>gestionar <?php echo $tabla ?></title>
        <style>
            table {
                border-collapse: collapse;
                width: 70%;
                margin: 0 auto;
            }

            table, td, th {
                border: 1px solid black;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <?php mostrarTabla($campos, $filas) ?>
    </body>
</html>
