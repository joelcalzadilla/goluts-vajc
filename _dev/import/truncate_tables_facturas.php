<?php

if (!(isset($_REQUEST["token"]) && $_REQUEST["token"] == "G4lv1nt3c")) {
    die("Token inválido");
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

include(dirname(dirname(__DIR__)) . '/config.php');

$connect = mysqli_connect(FS_DB_HOST, FS_DB_USER, FS_DB_PASS);
if (mysqli_connect_errno()) {
    echo "Fallo al conectarse con el servidor web";
    exit();
}
mysqli_select_db($connect, FS_DB_NAME) or die ("No se encuentra la BD");

mysqli_query($connect, "SET FOREIGN_KEY_CHECKS = 0;");
mysqli_query($connect, "TRUNCATE TABLE articulo_trazas");
mysqli_query($connect, "TRUNCATE TABLE albaranescli");
mysqli_query($connect, "TRUNCATE TABLE lineasfacturascli");
mysqli_query($connect, "TRUNCATE TABLE facturascli");
mysqli_query($connect, "TRUNCATE TABLE tpv_lineascomanda");
mysqli_query($connect, "TRUNCATE TABLE tpv_comandas");
mysqli_query($connect, "SET FOREIGN_KEY_CHECKS = 1;");

mysqli_close($connect);



