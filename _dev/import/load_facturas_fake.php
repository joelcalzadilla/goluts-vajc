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

for ($i = 5; $i <= 150; $i++) {
    $codigo_factura = "FAC2018A".$i;
    $hora = $i < 100 ? "08:00:".str_pad($i, 2, "0", STR_PAD_LEFT) : "08:01:".substr($i, 1);
    $sql = "INSERT INTO facturascli(apartado,automatica,cifnif,ciudad,codagente,codalmacen,codcliente,coddir,coddivisa,codejercicio,codigo,codigorect,codpago,codpais,codpostal,codserie,deabono,direccion,editable,fecha,vencimiento,femail,hora,idasiento,idasientop,idfactura,idfacturarect,idpagodevol,idprovincia,irpf,netosindto,neto,nogenerarasiento,nombrecliente,numero,numero2,observaciones,pagada,anulada,porcomision,provincia,recfinanciero,tasaconv,total,totaleuros,totalirpf,totaliva,totalrecargo,tpv,codtrans,codigoenv,nombreenv,apellidosenv,direccionenv,codpostalenv,ciudadenv,provinciaenv,apartadoenv,codpaisenv,idimprenta,numdocs,dtopor1,dtopor2,dtopor3,dtopor4,dtopor5,codruta,codvendedor)
SELECT apartado,automatica,cifnif,ciudad,codagente,codalmacen,codcliente,coddir,coddivisa,codejercicio, '".$codigo_factura."',codigorect,codpago,codpais,codpostal,codserie,deabono,direccion,editable,fecha,vencimiento,femail, '".$hora."',idasiento,idasientop, '".$i."',idfacturarect,idpagodevol,idprovincia,irpf,netosindto,neto,nogenerarasiento,nombrecliente, '".$i."',numero2, '".$i."',pagada,anulada,porcomision,provincia,recfinanciero,tasaconv,total,totaleuros,totalirpf,totaliva,totalrecargo,tpv,codtrans,codigoenv,nombreenv,apellidosenv,direccionenv,codpostalenv,ciudadenv,provinciaenv,apartadoenv,codpaisenv,idimprenta,numdocs,dtopor1,dtopor2,dtopor3,dtopor4,dtopor5,codruta,codvendedor
FROM facturascli
WHERE idfactura = 2;
";
    $rs = mysqli_query($connect, $sql);
    if(!$rs){
        echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
    }

    $sql_lineas = "INSERT INTO lineasfacturascli (cantidad,codimpuesto,descripcion,dtolineal,dtopor,dtopor2,dtopor3,dtopor4,idalbaran,idfactura,idlineaalbaran,irpf,iva,porcomision,pvpsindto,pvptotal,pvpunitario,recargo,referencia,codcombinacion,orden,mostrar_cantidad,mostrar_precio,cantidad_um,codum)
select cantidad,codimpuesto,descripcion,dtolineal,dtopor,dtopor2,dtopor3,dtopor4,idalbaran, '".$i."',idlineaalbaran,irpf,iva,porcomision,pvpsindto,pvptotal,pvpunitario,recargo,referencia,codcombinacion,orden,mostrar_cantidad,mostrar_precio,cantidad_um,codum FROM lineasfacturascli
WHERE lineasfacturascli.idfactura = 2";

    $rs_lineas = mysqli_query($connect, $sql_lineas);
    if (!$rs_lineas) {
        echo "<pre>" . print_r($sql_lineas, true) . "</pre>";
        echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
    }

    //Tpv comanda
    $sql_comanda = "INSERT INTO tpv_comandas(cifnif,ciudad,codalmacen,codcliente,coddir,codpago,totalpago,codpago2,totalpago2,numero2,observaciones,codpais,codpostal,direccion,fecha,hora,idfactura,idtpv_arqueo,idtpv_comanda,neto,nombrecliente,provincia,total,totaliva,ultcambio,ultentregado)
SELECT cifnif,ciudad,codalmacen,codcliente,coddir,codpago,totalpago,codpago2,totalpago2,numero2,observaciones,codpais,codpostal,direccion,fecha, '".$hora."', '".$i."',idtpv_arqueo, '".$i."',neto,nombrecliente,provincia,total,totaliva,ultcambio,ultentregado
FROM tpv_comandas
WHERE idfactura = 2;
";
    $rs_comanda = mysqli_query($connect, $sql_comanda);
    if (!$rs_comanda) {
        echo "<pre>" . print_r($sql_comanda, true) . "</pre>";
        echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
    }

    //Tpv líneas comanda
    $sql_lineas_comanda = "INSERT INTO tpv_lineascomanda(cantidad,codimpuesto,descripcion,dtopor,idtpv_comanda,irpf,iva,porcomision,pvpsindto,pvptotal,pvpunitario,recargo,referencia,codcombinacion)
SELECT cantidad,codimpuesto,descripcion,dtopor, '".$i."',irpf,iva,porcomision,pvpsindto,pvptotal,pvpunitario,recargo,referencia,codcombinacion
FROM tpv_lineascomanda
WHERE idtpv_comanda = 2;
";
    $rs_lineas_comanda = mysqli_query($connect, $sql_lineas_comanda);
    if (!$rs_lineas_comanda) {
        echo "<pre>" . print_r($sql_lineas_comanda, true) . "</pre>";
        echo "<pre>" . print_r(mysqli_error($connect), true) . "</pre>";
    }

}
mysqli_close($connect);


echo "Fin";



