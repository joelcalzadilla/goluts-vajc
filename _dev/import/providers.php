<?php

if(!(isset($_REQUEST["token"]) && $_REQUEST["token"] == "G4lv1nt3c")){
    die("Token inválido");
}
if (!(isset($_REQUEST["bd"]) || empty($_REQUEST["bd"]))) {
    die("Falta Base de datos: [chuches|prensa]");
}

$bd = strtoupper($_REQUEST["bd"]);
$key_bd = ($bd == "PRENSA") ? 1 : 2;

ini_set('display_errors', 1);
error_reporting(E_ALL);

include(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
include(dirname(dirname(__DIR__)) . '/config.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$inputFileName = __DIR__ . '/files/' . $bd . '_PROV.xls';
$spreadsheet = IOFactory::load($inputFileName);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$headers = array();
$date = date("Y-m-d");

$connect = mysqli_connect(FS_DB_HOST, FS_DB_USER, FS_DB_PASS);
if (mysqli_connect_errno()) {
    echo "Fallo al conectarse con el servidor web";
    exit();
}
mysqli_select_db($connect, FS_DB_NAME) or die ("No se encuentra la BD");

$num_proveedores = 0;
$num_inserts = 0;
$sql = "";
foreach ($sheetData as $key => $value) {
    if ($key == 1) {
        $headers = array_flip($value);
    } else {

        $CODIGO = $value[$headers["CODIGO"]];
        $NOMBRE = $value[$headers["NOMBRE"]];

        if(!empty($CODIGO) && !empty($NOMBRE)){
            $cod_proveedor = $key_bd . "" . str_pad($CODIGO, 10, '0', STR_PAD_LEFT);
            $sql_values = "('" . $cod_proveedor . "','" . $NOMBRE . "'),";

            if ($num_inserts == 0) {
                $sql = "INSERT INTO proveedores (codproveedor, nombre) VALUES ";
            }
            $sql .= $sql_values;
            $num_inserts++;
            $num_proveedores++;

            if ($num_inserts == 5000) {
                mysqli_query($connect, rtrim($sql, ","));
                $sql = "";
                $num_inserts = 0;
            }
        }
    }
}

if (!empty($sql)) {
    mysqli_query($connect, rtrim($sql, ","));
}
mysqli_close($connect);

echo "Nº Proveedores: ". $num_proveedores;

