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
    if (isset($_POST['gestionar'])) {
        $_SESSION['conexion']['tipoC'] = $_POST['gestionar'];
        switch ($_POST['gestionar']) {
            case "editar":
                $_SESSION['conexion']['datos'] = $_POST['datos'];
                header("Location:modify.php");
                exit();
                break;
            case "borrar":
                $_SESSION['conexion']['datos'] = $_POST['datos'];
                header("Location:modify.php");
                break;
            case "insertar":
                header("Location:modify.php");
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
        $i = 0;
        foreach ($fila as $f) {
            echo "<td>$f";
            echo "<input type='hidden' name='datos[" . $campos[$i] . "]' value='$f'</td>";
            $i++;
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
        <form action="tablas.php" method="POST">
            <input type="submit" name="gestionar" value="volver">
        </form>
        <form action="gestionarTabla.php" method="POST">
            <input type="submit" name="gestionar" value="insertar">
        </form>
        <?php mostrarTabla($campos, $filas) ?>
    </body>
</html>

