<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});
$conexion = null;
if (isset($_POST['submit'])) {
    session_start();

    switch ($_POST['submit']) {
        case "conectar":
            $host = $_POST['host'];
            $usuario = $_POST['usuario'];
            $pass = $_POST['pass'];
            $bd = new BBDD($host, $usuario, $pass);
            if ($bd->checkState()) {
                $bases = $bd->selectQuery("show databases");
                $_SESSION['conexion']['host'] = $host;
                $_SESSION['conexion']['user'] = $usuario;
                $_SESSION['conexion']['pass'] = $pass;
                $_SESSION['conexion']['bases'] = $bases;
                $connect = true;
            }
            break;
        case "acceder":
            if (isset($_POST['basedatos'])) {
                $_SESSION['conexion']['basedatos'] = $_POST['basedatos'];
                header("Location:tablas.php");
                exit();
            } else {
                $msj = "Has de seleccionar una base de datos";
            }
            var_dump($_POST['basedatos']);
            break;
        case "desconectar":
            session_destroy();
            header("Location:index.php");
            break;
    }
    if (isset($_SESSION['conexion'])) {
        $bases = $_SESSION['conexion']['bases'];
        $conexion = $_SESSION['conexion'];
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Autenticacion</title>
    </head>
    <body>
        <fieldset>
            <legend>Datos de conexión</legend>
            <form action="." method="POST">
                <label for="host">Host</label>
                <input type="text" name="host" value="127.0.0.1" id="">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" value="root" id="">
                <label for="pass">Password</label>
                <input type="text" name="pass" value="" id="">
                <input type="submit" value="<?php echo (isset($_SESSION['conexion'])) ? "desconectar" : "conectar" ?>" name="submit">
            </form>
        </fieldset>
        <?php
        if ($conexion):
            if (isset($msj))
                echo "<h3>$msj</h3>";
            ?>
            <fieldset>
                <legend>Bases disponibles</legend>
                <form action="index.php" method="post">
                    <?php
                    foreach ($bases as $base) {
                        foreach ($base as $b) {
                            $check = ($_SESSION['conexion']['basedatos'] == $b) ? "checked" : "";
                            echo "<input type=radio value=$b name=basedatos $check>";
                            echo "<label for=basedatos>$b</label><br />";
                        }
                    }
                    ?>
                    <input type="submit" name="submit" value="acceder">
                </form>
            </fieldset>
        <?php endif; ?>
    </body>
</html>
