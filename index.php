<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});


if (isset($_POST['submit'])) {
    session_start();

    switch ($_POST['submit']) {
        case "conectar":
            $host = $_POST['host'];
            $bd = new BBDD();
            $bases = $bd->selectQuery("show databases");
            $_SESSION['conectado'] = true;
            $_SESSION['bases'] = $bases;
            break;
        case "acceder":
            if (isset($_POST['basedatos'])) {
                $_SESSION['basedatos'] = $_POST['basedatos'];
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
    if (isset($_SESSION['conectado'])) {
        $bases = $_SESSION['bases'];
        $conectado = $_SESSION['conectado'];
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset>
            <legend>Datos de conexión</legend>
            <form action="." method="POST">
                <label for="host">Host</label>
                <input type="text" name="host" value="172.17.0.2" id="">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" value="root" id="">
                <label for="pass">Password</label>
                <input type="text" name="pass" value="root" id="">
                <input type="submit" value="<?php echo ($_SESSION['conectado'] == true) ? "desconectar" : "conectar" ?>" name="submit">
            </form>
        </fieldset>
        <?php
        if ($conectado):
            if (isset($msj))
                echo "<h3>$msj</h3>";
            ?>
            <fieldset>
                <legend>Bases disponibles</legend>
                <form action="index.php" method="post">
                    <?php
                    foreach ($bases as $base) {
                        foreach ($base as $b) {
                            echo "<input type=radio value=$b name=basedatos>";
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
