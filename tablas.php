<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});

session_start();
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tablas</title>
    </head>
    <body>

    </body>
</html>
