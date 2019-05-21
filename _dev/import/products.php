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
ini_set('memory_limit', '-1');
set_time_limit(600);
error_reporting(E_ALL);

include(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
include(dirname(dirname(__DIR__)) . '/config.php');

use PhpOffice\PhpSpreadsheet\IOFactory;


// check if  string ends with specific sub-string
function endsWith($currentString, $target)
{
    $length = strlen($target);
    if ($length == 0) {
        return true;
    }

    return (substr($currentString, -$length) === $target);
}


$inputFileName = __DIR__ . '/files/' . $bd . '_ARTIC.xls';
$spreadsheet = IOFactory::load($inputFileName);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, false, true);

$headers = array();

$date = date("Y-m-d");


$connect = mysqli_connect(FS_DB_HOST, FS_DB_USER, FS_DB_PASS);
if (mysqli_connect_errno()) {
    echo "Fallo al conectarse con el servidor web";
    exit();
}
mysqli_set_charset($connect, "utf8");
mysqli_select_db($connect, FS_DB_NAME) or die ("No se encuentra la BD");

$num_inserts = 0;
$sql = "";
$sql_codbarras = "";
$num_products = 0;

//Obtener familias válidas
$ids_familias = array();
$sql_familias = "SELECT * FROM familias";
$rs = mysqli_query($connect, $sql_familias);
if ($rs && mysqli_num_rows($rs) > 0) {
    while ($row = mysqli_fetch_array($rs)) {
        if (!empty($row["codfamilia"])) {
            $ids_familias[] = $row["codfamilia"];
        }
    }
}


//Obtener proveedores válidos
$ids_proveedores = array();
$sql_proveedores = "SELECT codproveedor FROM proveedores";
$rs = mysqli_query($connect, $sql_proveedores);
if ($rs && mysqli_num_rows($rs) > 0) {
    while ($row = mysqli_fetch_array($rs)) {
        if (!empty($row["codproveedor"])) {
            $ids_proveedores[] = $row["codproveedor"];
        }
    }
}

$codigos_insertados = array();

foreach ($sheetData as $key => $value) {
    if ($key == 1) {
        $headers = array_flip($value);
    } else {
        $CODIGO = $value[$headers["CODIGO"]]; //codigo barras
        $FCODIGO = $value[$headers["FCODIGO"]]; ////código distribuidora, fecha recepción, reservas... -- 29022 28-01-8 codigo distribuidora / fecha de recepción con año supuesto 201x  ------  2904AVI-P-PIN codigo distribuidora / reservados  ------------ 28839MIE15-07 dia que llega
        $DESCRIPCIO = $value[$headers["DESCRIPCIO"]]; //DESCRIPCION
        $ENVASE = $value[$headers["ENVASE"]]; //-
        $F = $value[$headers["F"]]; //-
        $S = $value[$headers["S"]]; //cod familia
        $PRECIO_1 = $value[$headers["PRECIO_1"]]; //pvp
        $PRECIO_2 = $value[$headers["PRECIO_2"]]; //Si existe, es el precio válido y el PRECIO_1 será el precio anterior
        $PRECIO_3 = $value[$headers["PRECIO_3"]]; //numero de ultima revista recibida
        $PRECIO_4 = $value[$headers["PRECIO_4"]]; //stock vendido al momento de la ultima recepcion
        $COMISION_1 = $value[$headers["COMISION_1"]]; //si está, es el numero anterior del anterior
        $COMISION_2 = $value[$headers["COMISION_2"]]; //si está, uds del numero anterior del anterior en el momento de la ultima reception
        $COMISION_3 = $value[$headers["COMISION_3"]]; //-
        $COMISION_4 = $value[$headers["COMISION_4"]]; //cantidad de revisatas recibidas en ultimo reparto
        $DCTO_1 = $value[$headers["DCTO_1"]]; //-
        $DCTO_2 = $value[$headers["DCTO_2"]]; //-
        $DCTO_3 = $value[$headers["DCTO_3"]]; //si está, es el numero anterior
        $DCTO_4 = $value[$headers["DCTO_4"]]; //si está, uds del numero anterior en el momento de la ultima reception
        $DESCUENTO = $value[$headers["DESCUENTO"]]; //-
        $COMISION = $value[$headers["COMISION"]]; //-
        $TIPO_IVA = $value[$headers["TIPO_IVA"]]; //-
        $STOCK = $value[$headers["STOCK"]]; //ventas historicas
        $STOCK_MINI = $value[$headers["STOCK_MINI"]];
        $FEC_U_COMP = $value[$headers["FEC_U_COMP"]];
        $FEC_U_VENT = $value[$headers["FEC_U_VENT"]];
        $PREC_MED_C = $value[$headers["PREC_MED_C"]];
        $PREC_MED_V = $value[$headers["PREC_MED_V"]];
        $ULT_PR_COS = $value[$headers["ULT_PR_COS"]];
        $UNID_VENTA = $value[$headers["UNID_VENTA"]];
        $UNID_COMPR = $value[$headers["UNID_COMPR"]];
        $PTS_COMPR = $value[$headers["PTS_COMPR"]];
        $PTS_VENTA = $value[$headers["PTS_VENTA"]];
        $PTS_IVAC = $value[$headers["PTS_IVAC"]];
        $PTS_IVA = $value[$headers["PTS_IVA"]];
        $ULT_PR_VEN = $value[$headers["ULT_PR_VEN"]];
        $PROVEEDOR = $value[$headers["PROVEEDOR"]]; //cod proveedor
        $CTA_COMPRA = $value[$headers["CTA_COMPRA"]];
        $CTA_VENTAS = $value[$headers["CTA_VENTAS"]];
        $PDTE_RECIB = $value[$headers["PDTE_RECIB"]];
        $PDTE_SERVI = $value[$headers["PDTE_SERVI"]];
        $MODIFICADO = $value[$headers["MODIFICADO"]];
        $PRECIO_ACO = $value[$headers["PRECIO_ACO"]];
        $PRECIO_ULT = $value[$headers["PRECIO_ULT"]];
        $MARGEN_1 = $value[$headers["MARGEN_1"]];
        $MARGEN_2 = $value[$headers["MARGEN_2"]];
        $MARGEN_3 = $value[$headers["MARGEN_3"]];
        $MARGEN_4 = $value[$headers["MARGEN_4"]];
        $ART_COCINA = $value[$headers["ART_COCINA"]];
        $STOCK_1 = $value[$headers["STOCK_1"]];
        $STOCK_2 = $value[$headers["STOCK_2"]];
        $STOCK_3 = $value[$headers["STOCK_3"]];
        $STOCK_4 = $value[$headers["STOCK_4"]];
        $STOCK_5 = $value[$headers["STOCK_5"]];
        $STOCK_6 = $value[$headers["STOCK_6"]];
        $STOCK_7 = $value[$headers["STOCK_7"]];
        $STOCK_8 = $value[$headers["STOCK_8"]];
        $STOCK_9 = $value[$headers["STOCK_9"]];
        $STOCK_0 = $value[$headers["STOCK_0"]];
        $TIPO_MEDID = $value[$headers["TIPO_MEDID"]];
        $COMP_COD1 = $value[$headers["COMP_COD1"]];
        $COMP_COD2 = $value[$headers["COMP_COD2"]];
        $COMP_COD3 = $value[$headers["COMP_COD3"]];
        $COMP_COD4 = $value[$headers["COMP_COD4"]];
        $COMP_COD5 = $value[$headers["COMP_COD5"]];
        $COMP_COD6 = $value[$headers["COMP_COD6"]];
        $COMP_COD7 = $value[$headers["COMP_COD7"]];
        $COMP_COD8 = $value[$headers["COMP_COD8"]];
        $COMP_COD9 = $value[$headers["COMP_COD9"]];
        $COMP_MED1 = $value[$headers["COMP_MED1"]];
        $COMP_MED2 = $value[$headers["COMP_MED2"]];
        $COMP_MED3 = $value[$headers["COMP_MED3"]];
        $COMP_MED4 = $value[$headers["COMP_MED4"]];
        $COMP_MED5 = $value[$headers["COMP_MED5"]];
        $COMP_MED6 = $value[$headers["COMP_MED6"]];
        $COMP_MED7 = $value[$headers["COMP_MED7"]];
        $COMP_MED8 = $value[$headers["COMP_MED8"]];
        $COMP_MED9 = $value[$headers["COMP_MED9"]];
        $referencia = $CODIGO;
        if (!empty($referencia) && !in_array($referencia, $codigos_insertados)) {

            $descatalogado = endsWith($DESCRIPCIO, " D") ? 1:0;
            $insert = true;
            //Comprobamos si existe esa referencia en base de datos
            $sql_check_referencia = "SELECT referencia FROM articulos WHERE referencia = '".$referencia."'";

            $rs_check = mysqli_query($connect, $sql_check_referencia);
            if ($rs_check && mysqli_num_rows($rs_check) > 0) {
                $row_check = mysqli_fetch_array($rs_check);
                if($row_check && $row_check["referencia"]){
                    if(strlen($referencia) != 13){
                        $sql_update_reference = "UPDATE articulos SET referencia = CONCAT(key_bd, '.', referencia) WHERE referencia = '".$row_check["referencia"]."'";
                        mysqli_query($connect, $sql_update_reference);
                        $referencia = $key_bd.".".$CODIGO;
                    } else {
                        $insert = false; //Si ya existe una referencia que es una EAN que está guardado, no lo insertamos
                        //Si es descatalogado, actualizamos
                        if($descatalogado){
                            $sql_update_descatalogado = "UPDATE articulos SET devuelto_descatalogado = 1 WHERE referencia = '".$row_check["referencia"]."'";
                            mysqli_query($connect, $sql_update_descatalogado);
                        }
                    }
                }
            }

            if($insert){
                $cod_barras = strlen($CODIGO) == 13 ? $CODIGO : "";
                $no_stock = 0;
                $descripcion = trim($descatalogado ? rtrim($DESCRIPCIO,"D"): $DESCRIPCIO);
                $cod_subfamilia = $key_bd . "" . str_pad($S, 2, '0', STR_PAD_LEFT);
                $cod_familia = ($F == "10" && in_array($cod_subfamilia, $ids_familias)) ? $cod_subfamilia : "";
                $cod_proveedor = in_array($PROVEEDOR, $ids_proveedores) ? $PROVEEDOR : "";
                $control_stock = 1;
                $fcodigo = $FCODIGO;
                $pvp = $PRECIO_2 != 0 ? $PRECIO_2 : $PRECIO_1;
                $pvp_anterior = $PRECIO_2 != 0 ? $PRECIO_1 : 0;
                $stock = !empty($STOCK) && $STOCK != 0 ? $STOCK : 0;
                $stock_vendido_ult_recepcion = !empty($PRECIO_4) && $PRECIO_4 != 0 ? $PRECIO_4 : '';
                $num_ultima_revista = !empty($PRECIO_3) && $PRECIO_3 != 0 ? $PRECIO_3 : '';
                $numero_anterior_del_anterior = !empty($COMISION_1) && $COMISION_1 != 0 ? $COMISION_1 : '';
                $uds_numero_anterior_del_anterior_ult_recepcion = !empty($COMISION_2) && $COMISION_2 != 0 ? $COMISION_2 : '';
                $uds_revistas_ultimo_reparto = !empty($COMISION_4) && $COMISION_4 != 0 ? $COMISION_4 : '';
                $numero_anterior = !empty($DCTO_3) && $DCTO_3 != 0 ? $DCTO_3 : '';
                $uds_numero_anterior_ult_recepcion = !empty($DCTO_4) && $DCTO_4 != 0 ? $DCTO_4 : '';

                $codigo_distribuidora = "";
                $fecha_recepcion = "";
                $reservados = "";
                if(!empty($fcodigo)){
                    preg_match('(^[\w]+ [\w]+-[\w]+-[\w]+)', $fcodigo, $match);
                    if($match){
                        $codigo_distribuidora = substr($fcodigo, 0, strpos($fcodigo, " "));
                        $fecha = substr($fcodigo, strpos($fcodigo, " ") + 1);
                    }
                }

                if(!empty($cod_familia)){
                    $sql_values = "('" . $date . "', 0, 0, '', '".$cod_barras."', 'IVA0', $stock, 0, 0, 0, 'Code39', $no_stock, '" . mysqli_real_escape_string($connect, $descripcion) . "', 1, '" . $cod_familia . "', $control_stock, '" . $referencia . "', '" . $pvp . "','" . $pvp_anterior . "', 1, 0, 0, '".$num_ultima_revista."', '".$numero_anterior_del_anterior."', '".$uds_numero_anterior_del_anterior_ult_recepcion."', '".$uds_revistas_ultimo_reparto."', '".$numero_anterior."', '".$uds_numero_anterior_ult_recepcion."', '".$stock_vendido_ult_recepcion."', '".mysqli_real_escape_string($connect, $fcodigo)."', '".mysqli_real_escape_string($connect, $codigo_distribuidora)."','".mysqli_real_escape_string($connect, $fecha_recepcion)."', ".$key_bd.", ".$descatalogado."),";
                } else {
                    $sql_values = "('" . $date . "', 0, 0, '', '".$cod_barras."', 'IVA0', $stock, 0, 0, 0, 'Code39', $no_stock, '" . mysqli_real_escape_string($connect, $descripcion) . "', 1, null, $control_stock, '" . $referencia . "', '" . $pvp . "','" . $pvp_anterior . "', 1, 0, 0, '".$num_ultima_revista."', '".$numero_anterior_del_anterior."', '".$uds_numero_anterior_del_anterior_ult_recepcion."', '".$uds_revistas_ultimo_reparto."', '".$numero_anterior."', '".$uds_numero_anterior_ult_recepcion."', '".$stock_vendido_ult_recepcion."', '".mysqli_real_escape_string($connect, $fcodigo)."','".mysqli_real_escape_string($connect, $codigo_distribuidora)."','".mysqli_real_escape_string($connect, $fecha_recepcion)."', ".$key_bd.", ".$descatalogado."),";
                }

                if ($num_inserts == 0) {
                    $sql = "INSERT INTO articulos (factualizado, bloqueado, stockmin, observaciones, codbarras, codimpuesto, stockfis, stockmax, costemedio, preciocoste, tipocodbarras, nostock, descripcion, secompra, codfamilia, controlstock, referencia, pvp, pvp_anterior, sevende, publico, trazabilidad, num_ultimo_recibido, num_anterior_del_anterior, uds_num_anterior_del_anterior, uds_recibidas_ult_reparto, num_anterior, uds_num_anterior, stock_vendido_ult_recepcion, fcodigo, distribuidora, fecha_recepcion, key_bd, devuelto_descatalogado) VALUES ";
                }
                $sql .= $sql_values;
                $num_inserts++;
                $num_products++;
                $codigos_insertados[] = $referencia;

                if ($num_inserts == 3000) {
                    $result = mysqli_query($connect, rtrim($sql, ","));
                    if(!$result){
                        echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
                    }
                    $sql = "";
                    $sql_codbarras = "";
                    $num_inserts = 0;
                }
            }
        }

    }
}

if (!empty($sql)) {
    $result = mysqli_query($connect, rtrim($sql, ","));
    if(!$result){
        echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
    }
}

mysqli_query($connect, "SET FOREIGN_KEY_CHECKS = 0;");
$sql_stock = "TRUNCATE TABLE stocks;";
$result = mysqli_query($connect, $sql_stock);
mysqli_query($connect, "SET FOREIGN_KEY_CHECKS = 1;");
if(!$result){
    echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
}
$sql_stock = "
INSERT INTO stocks (referencia, disponible, stockmin, reservada, horaultreg, nombre, pterecibir, fechaultreg,
                    codalmacen, cantidadultreg, cantidad, stockmax, ubicacion)
SELECT referencia, stockfis, 0, 0, NULL, 'ALMACEN GENERAL', 0, NULL, 'ALG', 0, stockfis, 0, ''
FROM articulos;
";
$result = mysqli_query($connect, rtrim($sql_stock, ","));
if(!$result){
    echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
}

mysqli_close($connect);

echo "Nº Products: " . $num_products;

