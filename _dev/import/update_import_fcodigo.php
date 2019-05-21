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

$sql = "SELECT referencia, fcodigo FROM articulos WHERE fcodigo != ''";
$rs = mysqli_query($connect, $sql);
if ($rs && mysqli_num_rows($rs) > 0) {
    while ($row = mysqli_fetch_array($rs)) {
        if (!empty($row["fcodigo"])) {
            $fcodigo = $row["fcodigo"];
            echo "<pre>" . print_r($fcodigo, true) . "</pre>";
            preg_match('(^[\w]+ [\w]+-[\w]+-[\w]+)', $fcodigo, $match);
            $codigo_distribuidora = "";
            $fecha = "";
            if($match){
                $codigo_distribuidora = substr($fcodigo, 0, strpos($fcodigo, " "));
                $fecha = substr($fcodigo, strpos($fcodigo, " ") + 1);
            }
            if(!empty($codigo_distribuidora)){
                $sql_update = "UPDATE articulos SET distribuidora = '".$codigo_distribuidora."', fecha_recepcion = '".$fecha."' WHERE referencia = '".$row["referencia"]."'";
                $rs2 = mysqli_query($connect, $sql_update);
                if(!$rs2){
                    echo "<pre>" . print_r($sql_update, true) . "</pre>";
                    echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
                }
            }

        }
    }
} else {
    echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
}

mysqli_close($connect);



