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
    $seleccion = $_SESSION['conexion']['datos'];
    $bd = new BBDD($host, $usuario, $pass, $base);
    if (isset($_POST['gestionar'])) {
        $valoresNuevos = $_POST['datosNuevos'];
        $_SESSION['conexion']['datosNuevos'] = $valoresNuevos;
        switch ($_POST['gestionar']) {
            case "editar":
                $bd->preparedStatementPDO($seleccion, $valoresNuevos, $tabla);
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

function showValues($valores) {
    echo "<form action='modify.php' method='POST'>";
    foreach ($valores as $campo => $valor) {
        echo "<label>$campo</label>";
        echo "<input type='text' name='$campo' value='$valor'></br>";
        echo"<input type='hidden' name='datosNuevos[$campo]' value='$valor'>";
    }
    echo"<input type='submit' name='gestionar' value='editar'>";
    echo"</form>";
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>modifica el valor</title>
    </head>
    <body>
        <?php showValues($seleccion) ?>
    </body>
</html>

