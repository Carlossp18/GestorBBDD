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
    $tipo = $_SESSION['conexion']['tipoC'];
    $bd = new BBDD($host, $usuario, $pass, $base);
    $nameC = $bd->nombresCamposPDO($tabla);
    if (isset($_POST['gestionar'])) {
        //$_SESSION['conexion']['datosNuevos'] = $valoresNuevos;
        switch ($_POST['gestionar']) {
            case "editar":
                foreach ($seleccion as $campo => $v) {
                    $valoresNuevos[$campo] = $_POST[$campo];
                }
                var_dump($valoresNuevos);
                $_SESSION['conexion']['datosNuevos'] = $valoresNuevos;
                $bd->preparedStatementPDO($seleccion, $valoresNuevos, $tabla);
                break;
            case "insertar":
                foreach ($nameC as $campo) {
                    $valoresNuevos[$campo] = $_POST[$campo];
                }
                var_dump($valoresNuevos);
                $_SESSION['conexion']['datosNuevos'] = $valoresNuevos;
                $bd->preparedInsert($valoresNuevos, $tabla);
                break;
        }
    }
    if ($tipo != "") {
        if ($tipo == "borrar") {
            $bd->preparedDelete($seleccion, $tabla);
            header("Location:gestionarTabla.php");
            exit();
        }
    }
} else {
    header("location:tablas.php");
    exit();
}

function showValuesEditar($valores) {
    echo "<form action='modify.php' method='POST'>";
    foreach ($valores as $campo => $valor) {
        echo "<label>$campo</label>";
        echo "<input type='text' name='$campo' value='$valor'></br>";
        //echo"<input type='hidden' name='datosNuevos[$campo]' value='$valor'>";
    }
    echo"<input type='submit' name='gestionar' value='editar'>";
    echo"</form>";
}

function showValuesInsertar($campos) {
    echo "<form action='modify.php' method='POST'>";
    foreach ($campos as $campo) {
        echo "<label>$campo</label>";
        echo "<input type='text' name='$campo'></br>";
        //echo"<input type='hidden' name='datosNuevos[$campo]' value='$valor'>";
    }
    echo"<input type='submit' name='gestionar' value='insertar'>";
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
        <form action="gestionarTabla.php" method="POST">
            <input type="submit" name="gestionar" value="volver">
        </form>

        <?php
        if ($tipo != "") {
            switch ($tipo) {
                case "editar":
                    showValuesEditar($seleccion);
                    break;
                case "insertar":
                    showValuesInsertar($nameC);
                    break;
            }
        }
        ?>
    </body>
</html>

