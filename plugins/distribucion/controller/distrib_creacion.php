<?php

/*
 * Copyright (C) 2017 Joe Nilson <joenilson@gmail.com>
 *
 *  * This program is free software: you can redistribute it and/or modify
 *  * it under the terms of the GNU Lesser General Public License as
 *  * published by the Free Software Foundation, either version 3 of the
 *  * License, or (at your option) any later version.
 *  *
 *  * This program is distributed in the hope that it will be useful,
 *  * but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See th * e
 *  * GNU Lesser General Public License for more details.
 *  *
 *  * You should have received a copy of the GNU Lesser General Public License
 *  * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
require_once 'plugins/distribucion/vendors/FacturaScripts/PrintingManager.php';
require_once 'plugins/distribucion/extras/distribucion_controller.php';
use FacturaScripts\PrintingManager;

/**
 * Description of distribucion_creacion
 *
 * @author Joe Nilson <joenilson@gmail.com>
 */
class distrib_creacion extends distribucion_controller {

    public $almacen;
    public $codalmacen;
    public $distrib_transporte;
    public $distrib_lineastransporte;
    public $distrib_facturas;
    public $distrib_cliente;
    public $resultados;
    public $total_resultados;
    public $num_resultados;
    public $mostrar;
    public $offset;
    public $desde;
    public $hasta;
    public $conductor;
    public $conductores;
    public $transporte;
    public $lineastransporte;
    public $facturastransporte;
    public $factura_cliente;
    public $faltante;
    public $faltantes;
    public $subcuentas_faltantes;
    public $asiento;
    public $ejercicio;
    public $faltante_transporte;
    public $codsubcuenta_pago;
    public $cuenta_banco;
    public $fecha_pago;
    public $totales_lineas;
    public function __construct() {
        parent::__construct(__CLASS__, '5 - Transportes', 'distribucion');
    }

    public function private_core() {
        parent::private_core();
        $this->share_extensions();
        $this->init_variables();
        
        $this->verificarVariables();

        $conductor = $this->filter_request('conductor');
        if ($conductor and $conductor != '') {
            $conductor0 = new distribucion_conductores();
            $this->conductor = $conductor0->get($this->empresa->id, $conductor);
        }

        $this->desde = $this->filter_request('desde');
        $this->hasta = $this->filter_request('hasta');
        $this->num_resultados = 0;
        
        $this->filtrarType();
        
        $this->mostrarInfo();
        $buscar_conductor = $this->filter_request('buscar_conductor');
        if ($buscar_conductor) {
            $this->buscar_conductor();
        }
    }
    
    public function verificarVariables()
    {
        $cliente = \filter_input(INPUT_GET, 'codcliente');
        $offset = \filter_input(INPUT_GET, 'offset');
        $this->mostrar = "todo";
        $this->offset = (isset($offset)) ? $offset : 0;

        $codalmacen = $this->filter_request('codalmacen');
        $this->codalmacen = ($this->user->codalmacen) ? $this->user->codalmacen : $codalmacen;

        $this->cuenta_banco = new cuenta_banco();
        $this->codsubcuenta_pago = FALSE;
        if (\filter_input(INPUT_GET, 'codsubcuenta')) {
            $this->codsubcuenta_pago = \filter_input(INPUT_GET, 'codsubcuenta');
        }
        $this->fecha_pago = $this->today();
        if (\filter_input(INPUT_GET, 'fecha_pago')) {
            $this->fecha_pago = \date('Y-m-d', strtotime(\filter_input(INPUT_GET, 'fecha_pago')));
        }
        
        $mostrar = \filter_input(INPUT_GET, 'mostrar');
        if (isset($mostrar)) {
            $this->mostrar = $mostrar;
            setcookie('distrib_transporte_mostrar', $this->mostrar, time() + FS_COOKIES_EXPIRE);
        } elseif (isset($_COOKIE['distrib_transporte_mostrar'])) {
            $this->mostrar = $_COOKIE['distrib_transporte_mostrar'];
        }

        if (isset($cliente) AND ! empty($cliente)) {
            $cli0 = new cliente();
            $codcliente = $cli0->get($cliente);
        }
        $this->cliente = (isset($codcliente)) ? $codcliente : FALSE;
    }
    
    public function mostrarInfo()
    {
        if ($this->mostrar == 'todo') {
            if ($this->codalmacen) {
                $this->resultados = $this->distrib_transporte->all_almacen($this->empresa->id, $this->codalmacen, $this->offset);
            } else {
                $this->resultados = $this->distrib_transporte->all($this->empresa->id, $this->offset);
            }
        } elseif ($this->mostrar == 'por_despachar') {
            $this->resultados = $this->distrib_transporte->all_pendientes($this->empresa->id, 'despachado', $this->codalmacen, $this->offset);
        } elseif ($this->mostrar == 'por_liquidar') {
            $this->resultados = $this->distrib_transporte->all_pendientes($this->empresa->id, 'liquidado', $this->codalmacen, $this->offset);
        } elseif ($this->mostrar == 'buscar') {
            $this->buscador();
        }
    }
    
    public function filtrarType()
    {
        $type = \filter_input(INPUT_GET, 'type');
        if ($type === 'imprimir-transporte') {
            $this->imprimir_documento('transporte');
        } elseif ($type === 'imprimir-hojadevolucion') {
            $this->imprimir_documento('hojadevolucion');
        } elseif ($type == 'confirmar-devolucion') {
            $this->confirmar_devolucion(TRUE);
        } elseif ($type == 'confirmar-transporte') {
            $this->confirmar_transporte(TRUE);
        } elseif ($type == 'eliminar-transporte') {
            $this->eliminar_transporte();
        } elseif ($type == 'eliminar-devolucion') {
            $this->confirmar_devolucion(FALSE);
        } elseif ($type == 'eliminar-liquidacion') {
            $this->eliminar_liquidacion();
        } elseif ($type == 'eliminar-despacho') {
            $this->confirmar_transporte(FALSE);
        } elseif ($type == 'liquidar-transporte') {
            $this->liquidar_transporte();
        } elseif ($type == 'guardar-liquidacion') {
            $this->guardar_liquidacion();
        } elseif ($type == 'imprimir-liquidacion') {
            $this->imprimir_documento('liquidacion');
        } elseif ($type == 'imprimir-devolucion') {
            $this->imprimir_documento('devolucion');
        } elseif ($type == 'pagar-factura') {
            $this->pagar_factura();
        } elseif ($type == 'corregir-pago') {
            $this->corregir_pagos();
        } elseif ($type == 'extornar-factura') {
            $this->extornar_factura();
        } elseif ($type == 'crear-faltante') {
            $this->crear_faltante();
        }
    }
    
    public function init_variables()
    {
        new distribucion_lineastransporte();
        $this->almacen = new almacen();
        $this->distrib_transporte = new distribucion_transporte();
        $this->distrib_lineastransporte = new distribucion_lineastransporte();
        $this->distrib_facturas = new distribucion_ordenescarga_facturas();
        $this->factura_cliente = new factura_cliente();
        $this->faltante = new distribucion_faltantes();
        $this->subcuentas_faltantes = new distribucion_subcuentas_faltantes();
        $this->asiento = new asiento();
        $this->ejercicio = new ejercicio();
        $this->conductores = new distribucion_conductores();
    }

    private function cabecera_lineas_documento($tipo){
        $cabecera = array();
        if($tipo=='transporte'){
            $cabecera[] = array('size'=>125, 'descripcion'=>'Ref + Descripcion','align'=>'L','total'=>false);
            $cabecera[] = array('size'=>40, 'descripcion'=>'U. Med','align'=>'C','total'=>false);
            $cabecera[] = array('size'=>30, 'descripcion'=>'Cantidad','align'=>'R','total'=>true,'total_campo'=>'totalcantidad');
            $cabecera[] = array('size'=>30, 'descripcion'=>'Monto','align'=>'R','total'=>true,'total_campo'=>'totalimporte');
        }elseif($tipo=='hojadevolucion'){
            $cabecera[] = array('size'=>125, 'descripcion'=>'Ref + Descripcion','align'=>'L','total'=>false);
            $cabecera[] = array('size'=>40, 'descripcion'=>'U. Med','align'=>'C','total'=>false);
            $cabecera[] = array('size'=>20, 'descripcion'=>'Salida','align'=>'R','total'=>true,'total_campo'=>'totalcantidad');
            $cabecera[] = array('size'=>30, 'descripcion'=>'Devolución','align'=>'C','total'=>false);
            $cabecera[] = array('size'=>30, 'descripcion'=>'Salida Neta','align'=>'C','total'=>false);
        }elseif($tipo=='devolucion'){
            $cabecera[] = array('size'=>110, 'descripcion'=>'Ref + Descripcion','align'=>'L','total'=>false);
            $cabecera[] = array('size'=>40, 'descripcion'=>'U. Med','align'=>'C','total'=>false);
            $cabecera[] = array('size'=>30, 'descripcion'=>'Salida','align'=>'R','total'=>true,'total_campo'=>'totalsalida');
            $cabecera[] = array('size'=>30, 'descripcion'=>'Devolución','align'=>'R','total'=>true,'total_campo'=>'totaldevolucion');
            $cabecera[] = array('size'=>30, 'descripcion'=>'Saldo','align'=>'R','total'=>true,'total_campo'=>'totalsaldo');
        }elseif($tipo=='liquidacion'){
            $cabecera[] = array('size'=>25, 'descripcion'=>'Id','align'=>'L','total'=>false);
            $cabecera[] = array('size'=>50, 'descripcion'=>FS_NUMERO2,'align'=>'L','total'=>false);
            $cabecera[] = array('size'=>50, 'descripcion'=>'Cliente','align'=>'L','total'=>false);
            $cabecera[] = array('size'=>30, 'descripcion'=>'Fecha Fac','align'=>'L','total'=>false);
            $cabecera[] = array('size'=>20, 'descripcion'=>'Cant.','align'=>'R','total'=>false);
            $cabecera[] = array('size'=>30, 'descripcion'=>'Monto','align'=>'R','total'=>true,'total_campo'=>'totalmonto');
            $cabecera[] = array('size'=>30, 'descripcion'=>'Abono','align'=>'R','total'=>true,'total_campo'=>'totalabono');
            $cabecera[] = array('size'=>30, 'descripcion'=>'Saldo','align'=>'R','total'=>true,'total_campo'=>'totalsaldo');
        }
        return $cabecera;
    }

    public function buscador() {
        $datos_busqueda = array();
        $query = \filter_input(INPUT_POST, 'query');
        if ($query) {
            $datos_busqueda['idtransporte'] = $query;
        }
        if ($this->conductor) {
            $datos_busqueda['conductor'] = $this->conductor->licencia;
        }
        if ($this->codalmacen) {
            $datos_busqueda['codalmacen'] = $this->codalmacen;
        }

        $busqueda = $this->distrib_transporte->search($this->empresa->id, $datos_busqueda, $this->desde, $this->hasta, $this->offset);
        $this->resultados = $busqueda['resultados'];
        $this->num_resultados = $busqueda['cantidad'];
    }

    public function paginas() {
        $conductor = ($this->conductor) ? $this->conductor->licencia : '';
        $this->total_resultados = $this->distrib_transporte->total_transportes($this->empresa->id, $this->codalmacen, $this->desde, $this->hasta);
        $url = $this->url() . "&mostrar=" . $this->mostrar
                . "&query=" . $this->query
                . "&desde=" . $this->desde
                . "&hasta=" . $this->hasta
                . "&conductor=" . $conductor
                . "&codalmacen=" . $this->codalmacen
                . "&offset=" . $this->offset;

        $paginas = array();
        $i = 0;
        $num = 0;
        $actual = 1;

        if ($this->mostrar == 'por_despachar') {
            $total = $this->total_pendientes('despachado');
        } elseif ($this->mostrar == 'por_liquidar') {
            $total = $this->total_pendientes('liquidado');
        } elseif ($this->mostrar == 'buscar') {
            $total = $this->num_resultados;
        } else {
            $total = $this->total_resultados;
        }

        /// añadimos todas la página
        while ($num < $total) {
            $paginas[$i] = array(
                'url' => $url . "&offset=" . ($i * FS_ITEM_LIMIT),
                'num' => $i + 1,
                'actual' => ($num == $this->offset)
            );

            if ($num == $this->offset) {
                $actual = $i;
            }

            $i++;
            $num += FS_ITEM_LIMIT;
        }

        return $paginas;
    }

    public function total_pendientes($tipo) {
        return $this->distrib_transporte->total_pendientes($this->empresa->id, $tipo, $this->codalmacen, $this->desde, $this->hasta);
    }

    public function url($busqueda = FALSE) {
        if ($busqueda) {
            $licencia = '';
            if ($this->conductor) {
                $licencia = $this->conductor->licencia;
            }

            $url = $this->url() . "&mostrar=" . $this->mostrar
                    . "&query=" . $this->query
                    . "&conductor=" . $licencia
                    . "&desde=" . $this->desde
                    . "&hasta=" . $this->hasta;

            return $url;
        } else {
            return parent::url();
        }
    }

    public function imprimir_documento($tipo='transporte') {
        $this->template = false;
        $value_transporte = \filter_input(INPUT_GET, 'transporte');
        $lista_transporte = explode(',', $value_transporte);
        $contador_transporte = 0;
        $conf = array('file'=>$tipo.'.pdf', 'type'=>'pdf', 'page_size'=>'letter','linea_espacio'=>($tipo=='hojadevolucion')?8:5);
        $pdf_doc = new PrintingManager($conf);
        $pdf_doc->crearArchivo();
        foreach ($lista_transporte as $linea) {
            if (!empty($linea)) {
                $datos_transporte = explode('-', $linea);
                $idtransporte = $datos_transporte[0];
                $codalmacen = $datos_transporte[1];
                $contador_transporte++;
                $transporte = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
                $transporte->nombre = strtoupper(strtolower($this->distribucion_setup['distrib_'.$tipo]));
                $transporte->numero = str_pad($transporte->idtransporte,6,'0',STR_PAD_LEFT);
                $transporte->cabecera_lineas = $this->cabecera_lineas_documento($tipo);
                $cabecera = array();
                if($tipo!='transporte'){
                    $cabecera[] = array('size'=>30, 'label'=>$this->distribucion_setup['distrib_transporte'].':','valor'=>str_pad($transporte->idtransporte,6,0,STR_PAD_LEFT),'salto_linea'=>false);
                }
                $cabecera[] = array('size'=>30, 'label'=>'Orden de Carga:','valor'=>str_pad($transporte->idordencarga,6,0,STR_PAD_LEFT),'salto_linea'=>false);
                $cabecera[] = array('size'=>30, 'label'=>'Fecha de Reparto:','valor'=>$transporte->fecha,'salto_linea'=>true);
                $cabecera[] = array('size'=>30, 'label'=>'Almacén Origen:','valor'=>$transporte->codalmacen,'salto_linea'=>false);
                $cabecera[] = array('size'=>30, 'label'=>'Almacén Destino:','valor'=>$transporte->codalmacen_dest,'salto_linea'=>true);
                $cabecera[] = array('size'=>30, 'label'=>'Unidad:','valor'=>$transporte->unidad,'salto_linea'=>false);
                $cabecera[] = array('size'=>120, 'label'=>'Conductor:','valor'=>$transporte->conductor_nombre,'salto_linea'=>true);
                $pdf_doc->agregarCabecera($this->empresa, $transporte, $cabecera);
                $lineasdocumento = $this->lineas_documento($tipo, $idtransporte, $codalmacen);
                $pdf_doc->agregarLineas($lineasdocumento);
                if($tipo=='transporte' OR $tipo=='hojadevolucion'){
                    $this->totales_lineas = array('totalcantidad'=>$transporte->totalcantidad,'totalimporte'=>$transporte->totalimporte);
                }
                $pdf_doc->agregarTotalesLineas($this->totales_lineas);
                $pdf_doc->agregarObservaciones(false);
                $firmas = array();
                $firmas[] = 'Firma Distribución';
                $firmas[] = 'Firma Seguridad';
                $firmas[] = 'Firma Almacén';
                $pdf_doc->agregarFirmas($firmas);
            }
        }
        $pdf_doc->mostrarDocumento();
    }

    private function lineas_documento($tipo, $idtransporte, $codalmacen){
        $lineas_documento = array();
        $this->totales_lineas = array();
        if($tipo=='liquidacion'){
            $lineas_documento = $this->distrib_facturas->get_lineas_imprimir($this->empresa->id, $codalmacen, $idtransporte);
            $this->totales_lineas['totalmonto'] = 0;
            $this->totales_lineas['totalabono'] = 0;
            $this->totales_lineas['totalsaldo'] = 0;
            foreach($lineas_documento as $linea){
                $this->totales_lineas['totalmonto']+=$linea[5];
                $this->totales_lineas['totalabono']+=$linea[6];
                $this->totales_lineas['totalsaldo']+=$linea[7];
            }
        }
        if($tipo=='devolucion'){
            $lineas_documento = $this->distrib_lineastransporte->get_lineas_imprimir($this->empresa->id, $idtransporte, $codalmacen, $tipo);
            $this->totales_lineas['totalsalida'] = 0;
            $this->totales_lineas['totaldevolucion'] = 0;
            $this->totales_lineas['totalsaldo'] = 0;
            foreach($lineas_documento as $linea){
                $this->totales_lineas['totalsalida']+=$linea[2];
                $this->totales_lineas['totaldevolucion']+=$linea[3];
                $this->totales_lineas['totalsaldo']+=$linea[4];
            }
        }

        if($tipo=='transporte' OR $tipo=='hojadevolucion'){
            $lineas_documento = $this->distrib_lineastransporte->get_lineas_imprimir($this->empresa->id, $idtransporte, $codalmacen, $tipo);
        }
        return $lineas_documento;
    }

    public function confirmar_devolucion($confirmado = TRUE) {
        $data = array();
        $fechad = \filter_input(INPUT_GET, 'fechad');
        $value_transporte = \filter_input(INPUT_GET, 'transporte');
        $lista_transporte = explode(',', $value_transporte);
        $tipo_mensaje = ($confirmado) ? "confirmado" : "desconfirmado";
        $mensaje = (count($lista_transporte) > 1) ? "Devolución de Transportes " . $tipo_mensaje . "s" . " correctamente." : "Devolución de Transporte " . $tipo_mensaje . " correctamente.";
        foreach ($lista_transporte as $linea) {
            if ($linea) {
                $datos_transporte = explode('-', $linea);
                $idtransporte = $datos_transporte[0];
                $codalmacen = $datos_transporte[1];
                $trans0 = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
                $this->facturastransporte = $this->distrib_facturas->all_almacen_idtransporte($this->empresa->id, $codalmacen, $idtransporte);
                $lineastransporte = $this->distrib_lineastransporte->get($this->empresa->id, $idtransporte, $codalmacen);   
                $articulo = $this->tratar_facturas_transporte($this->facturastransporte);
                $error = $this->tratar_lineas_transporte($lineastransporte,$articulo,$codalmacen,$confirmado,$idtransporte);
                $data = $this->confirmar_devolucion_transporte($confirmado,$error,$fechad,$mensaje,$trans0);
            }
        }
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function confirmar_devolucion_transporte($confirmado,$error,$fechad,$mensaje,$trans0)
    {
        $data = array();
        if (!$error) {
            $trans0->devolucionado = $confirmado;
            $trans0->fechad = ($fechad) ? \date('Y-m-d', strtotime($fechad)) : \Date('d-m-Y');
            $trans0->fecha_modificacion = Date('d-m-Y H:i');
            $trans0->usuario_modificacion = $this->user->nick;
            if ($trans0->confirmar_devolucion()) {
                $data['success'] = TRUE;
                $data['mensaje'] = $mensaje;
            } else {
                $data['success'] = FALSE;
                $data['mensaje'] = '¡No se pudo confirmar la devolución del transporte pero se guardaron las cantidades de devolución!';
            }
        } else {
            $data['success'] = FALSE;
            $data['mensaje'] = '!No se lograron guardar las devoluciones de artículos en el Transporte!';
        }
        return $data;
    }
    
    public function tratar_lineas_transporte($lineastransporte,$articulo,$codalmacen,$confirmado,$idtransporte)
    {
        $error = 0;
        foreach ($lineastransporte as $linea) {
            $lin0 = $this->distrib_lineastransporte->getOne($this->empresa->id, $idtransporte, $codalmacen, $linea->referencia);
            $lin0->devolucion = ($confirmado AND isset($articulo[$linea->referencia]))?$articulo[$linea->referencia]:0;
            if (!$lin0->save()) {
                $error++;
            }
        }
        return $error;
    }
    
    public function tratar_facturas_transporte()
    {
        $articulo = array();
        foreach ($this->facturastransporte as $fact) {
            $rectif = $this->factura_cliente->get($fact->idfactura)->get_rectificativas();
            if ($rectif) {
                $this->tratar_facturasrect($rectif,$articulo);
            }
        }
        return $articulo;
    }
    
    public function tratar_facturasrect($rectif,&$articulo)
    {
        foreach ($rectif as $f) {
            foreach ($f->get_lineas() as $linea) {
                $articulo[$linea->referencia] = (!isset($articulo[$linea->referencia])) ? 0 : $articulo[$linea->referencia];
                $articulo[$linea->referencia] += $linea->cantidad;
            }
        }
        return $articulo;
    }

    public function confirmar_transporte($confirmado = TRUE) {
        $data = array();
        $value_transporte = \filter_input(INPUT_GET, 'transporte');
        $lista_transporte = explode(',', $value_transporte);
        $tipo_mensaje = ($confirmado) ? "despachado" : "desconfirmado";
        $mensaje = (count($lista_transporte) > 1) ? "Transportes " . $tipo_mensaje . "s" : "Transporte " . $tipo_mensaje;
        foreach ($lista_transporte as $linea) {
            if ($linea) {
                $datos_transporte = explode('-', $linea);
                $idtransporte = $datos_transporte[0];
                $codalmacen = $datos_transporte[1];
                $trans0 = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
                $trans0->fechad = Date('d-m-Y');
                $trans0->despachado = $confirmado;
                $trans0->fecha_modificacion = Date('d-m-Y H:i');
                $trans0->usuario_modificacion = $this->user->nick;
                if ($trans0->confirmar_despacho()) {
                    $data['success'] = TRUE;
                    $data['mensaje'] = $mensaje;
                } else {
                    $data['success'] = FALSE;
                    $data['mensaje'] = 'Transporte <b>NO</b> procesado!';
                }
            }
        }
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function eliminar_transporte() {
        $data = array();
        $value_transporte = \filter_input(INPUT_GET, 'transporte');
        $lista_transporte = explode(',', $value_transporte);
        foreach ($lista_transporte as $linea) {
            if ($linea) {
                $datos_transporte = explode('-', $linea);
                $idtransporte = $datos_transporte[0];
                $codalmacen = $datos_transporte[1];
                $trans0 = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
                if ($trans0->delete()) {
                    $data['success'] = TRUE;
                    $data['mensaje'] = 'Transporte ' . $idtransporte . ' eliminado!';
                } else {
                    $data['success'] = FALSE;
                    $data['mensaje'] = 'Transporte ' . $idtransporte . ' <b>NO</b> eliminado!';
                }
            }
        }
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function liquidar_transporte() {
        $value_transporte = \filter_input(INPUT_GET, 'transporte');
        $datos_transporte = explode('-', $value_transporte);
        $idtransporte = $datos_transporte[0];
        $codalmacen = $datos_transporte[1];
        $faltante_transporte = new distribucion_faltantes();
        $this->faltante_transporte = $faltante_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
        $this->transporte = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
        $this->facturastransporte = $this->distrib_facturas->all_almacen_idtransporte($this->empresa->id, $codalmacen, $idtransporte);
        $lineastransporte = $this->distrib_lineastransporte->get($this->empresa->id, $idtransporte, $codalmacen);
        if (!$this->transporte->devolucionado) {
            $articulo = $this->tratar_facturas_transporte($this->facturastransporte);
            foreach ($lineastransporte as $linea) {
                $linea->devolucion = (isset($articulo[$linea->referencia])) ? $articulo[$linea->referencia] : 0;
            }
        }
        $this->lineastransporte = $lineastransporte;
        $this->template = 'extension/liquidar_transporte';
    }

    public function guardar_liquidacion() {
        $data = array();
        $value_transporte = \filter_input(INPUT_GET, 'transporte');
        $fechal = \filter_input(INPUT_GET, 'fechal');
        $datos_transporte = explode('-', $value_transporte);
        $idtransporte = $datos_transporte[0];
        $codalmacen = $datos_transporte[1];
        $trans0 = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
        $trans0->fechal = ($fechal) ? \date('Y-m-d', strtotime($fechal)) : \date('d-m-Y');
        $trans0->liquidado = TRUE;
        $trans0->fecha_modificacion = Date('d-m-Y H:i');
        $trans0->usuario_modificacion = $this->user->nick;
        if ($trans0->confirmar_liquidada()) {
            $data['success'] = TRUE;
            $data['mensaje'] = 'Transporte ' . $idtransporte . ' liquidado!';
        } else {
            $data['success'] = FALSE;
            $data['mensaje'] = 'Transporte ' . $idtransporte . ' <b>NO</b> liquidado!';
        }
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function eliminar_liquidacion() {
        $data = array();
        $idtransporte = \filter_input(INPUT_GET, 'transporte');
        $codalmacen = \filter_input(INPUT_GET, 'almacen');
        $trans0 = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
        $trans0->fechal = NULL;
        $trans0->liquidado = FALSE;
        $trans0->devolucionado = FALSE;
        $trans0->fecha_modificacion = Date('d-m-Y H:i');
        $trans0->usuario_modificacion = $this->user->nick;
        $msg_aux = "";
        if ($trans0->confirmar_liquidada()) {
            $faltante = $this->faltante->get($this->empresa->id, $idtransporte, $codalmacen);
            if ($faltante) {
                if ($faltante->pagos) {
                    $pagos = $this->faltante = get_pagos_recibo($this->empresa->id, $codalmacen, $faltante->idrecibo);
                    foreach ($pagos as $recibo) {
                        $recibo->delete();
                    }
                }
                $faltante->delete();
                $msg_aux = " Un Faltante eliminado.";
            } else {
                $msg_aux = " No hay faltantes asociados a esta liquidacion." . $msg_aux;
            }
            $facturastransporte = $this->distrib_facturas->all_almacen_idtransporte($this->empresa->id, $codalmacen, $idtransporte);
            $num = 0;
            foreach ($facturastransporte as $fac) {
                $factura = $this->factura_cliente->get($fac->idfactura);
                if ($factura) {
                    $factura->pagada = FALSE;
                    $factura->save();
                    if ($this->tesoreria) {
                        require_model('recibo_cliente.php');
                        $rf = new recibo_cliente();
                        $recibofac = $rf->all_from_factura($factura->idfactura);
                        foreach ($recibofac as $r) {
                            $r->delete();
                        }
                    }
                    $num++;
                }
            }
            $fac_procesadas = ($num) ? " Se eliminó el pago a $num Facturas." : " No se desmarcaron pagos a ninguna factura.";
            $data['success'] = TRUE;
            $data['mensaje'] = '¡Liquidación del Transporte ' . $idtransporte . ' eliminado!' . $msg_aux . $fac_procesadas;
        } else {
            $data['success'] = FALSE;
            $data['mensaje'] = '¡<b>NO</b>No se pudo eliminar la Liquidación del Transporte ' . $idtransporte . '!';
        }
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function corregir_pagos() {
        $data = array();
        $idtransporte = \filter_input(INPUT_GET, 'idtransporte');
        $codalmacen = \filter_input(INPUT_GET, 'codalmacen');
        $facturastransporte = $this->distrib_facturas->all_almacen_idtransporte($this->empresa->id, $codalmacen, $idtransporte);
        $reversadas = 0;
        $confirmadas = 0;
        if ($this->tesoreria) {
            require_model('pago_recibo_cliente.php');
            require_model('recibo_cliente.php');
            require_model('recibo_factura.php');
        }
        foreach ($facturastransporte as $fac) {
            $factura = $this->factura_cliente->get($fac->idfactura);
            //Reversamos el pago
            if ($factura) {
                $factura->pagada = FALSE;
                $factura->save();
                if ($this->tesoreria) {

                    $rf = new recibo_cliente();
                    $recibofac = $rf->all_from_factura($factura->idfactura);
                    foreach ($recibofac as $r) {
                        $r->delete();
                    }
                }
                $reversadas++;
            }

            if ($this->tesoreria) {
                $rec0 = new recibo_cliente();
                $ref0 = new recibo_factura();
                $recibos = $rec0->all_from_factura($factura->idfactura);
                if (!$recibos) {
                    $this->nuevo_recibo($factura);
                    $recibos = $rec0->all_from_factura($factura->idfactura);
                }

                foreach ($recibos as $recibo) {
                    if ($recibo->estado != 'Pagado') {
                        if ($ref0->nuevo_pago_cli($recibo, $this->codsubcuenta_pago, 'Pago', $this->fecha_pago)) {
                            $confirmadas++;
                        }
                    }
                }
            }
            $factura->pagada = TRUE;
            $factura->save();
        }
        $data['success'] = TRUE;
        $data['mensaje'] = "{$reversadas} reversadas y {$confirmadas} confirmadas.";
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function pagar_factura() {
        $data = array();
        $value_factura = \filter_input(INPUT_GET, 'factura');
        $lista_facturas = explode(',', $value_factura);
        $fact0 = new factura_cliente();
        if ($this->tesoreria) {
            require_model('pago_recibo_cliente.php');
            require_model('recibo_cliente.php');
            require_model('recibo_factura.php');
            $rec0 = new recibo_cliente();
            $ref0 = new recibo_factura();
        }
        $num = 0;
        $error = 0;
        foreach ($lista_facturas as $factura) {
            $datos_factura = explode('-', $factura);
            $factura = $fact0->get($datos_factura[0]);
            if ($factura) {
                if ($this->tesoreria) {
                    $recibos = $rec0->all_from_factura($factura->idfactura);
                    if (!$recibos) {
                        $this->nuevo_recibo($factura);
                        $recibos = $rec0->all_from_factura($factura->idfactura);
                    }
                    foreach ($recibos as $recibo) {
                        if ($recibo->estado != 'Pagado') {
                            $ref0->nuevo_pago_cli($recibo, $this->codsubcuenta_pago, 'Pago', $this->fecha_pago);
                        }
                    }
                }
                $factura->pagada = TRUE;
                $factura->save();
                $num++;
            }
        }
        $data['success'] = TRUE;
        $data['facturas_procesadas'] = $num;
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function extornar_factura() {
        $data = array();
        $value_factura = \filter_input(INPUT_GET, 'factura');
        $lista_facturas = explode(',', $value_factura);
        $fact0 = new factura_cliente();
        $num = 0;
        foreach ($lista_facturas as $factura) {
            $datos_factura = explode('-', $value_factura);
            $factura = $fact0->get($datos_factura[0]);
            if ($factura) {
                $factura->pagada = FALSE;
                $factura->save();
                $num++;
            }
        }
        $data['success'] = TRUE;
        $data['facturas_procesadas'] = $num;
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function nuevo_recibo($factura) {
        $recibo = new recibo_cliente();
        $recibo->apartado = $factura->apartado;
        $recibo->cifnif = $factura->cifnif;
        $recibo->ciudad = $factura->ciudad;
        $recibo->codcliente = $factura->codcliente;
        $recibo->coddir = $factura->coddir;
        $recibo->coddivisa = $factura->coddivisa;
        $recibo->tasaconv = $factura->tasaconv;
        $recibo->codpago = $factura->codpago;
        $recibo->codserie = $factura->codserie;
        $recibo->numero = $recibo->new_numero($factura->idfactura);
        $recibo->codigo = $factura->codigo . '-' . sprintf('%02s', $recibo->numero);
        $recibo->codpais = $factura->codpais;
        $recibo->codpostal = $factura->codpostal;
        $recibo->direccion = $factura->direccion;
        $recibo->estado = 'Emitido';
        $recibo->fecha = $factura->fecha;
        $recibo->fechav = $factura->vencimiento;
        $recibo->idfactura = $factura->idfactura;
        $recibo->importe = floatval($factura->total);
        $recibo->nombrecliente = $factura->nombrecliente;
        $recibo->provincia = $factura->provincia;

        $cbc = new cuenta_banco_cliente();
        foreach ($cbc->all_from_cliente($factura->codcliente) as $cuenta) {
            if (is_null($recibo->codcuenta) OR $cuenta->principal) {
                $recibo->codcuenta = $cuenta->codcuenta;
                $recibo->iban = $cuenta->iban;
                $recibo->swift = $cuenta->swift;
            }
        }
        $recibo->save();
    }

    public function crear_faltante() {
        $data = array();
        $idtransporte = \filter_input(INPUT_GET, 'idtransporte');
        $codalmacen = \filter_input(INPUT_GET, 'codalmacen');
        $codtrans = \filter_input(INPUT_GET, 'codtrans');
        $conductor = \filter_input(INPUT_GET, 'conductor');
        $importe = \filter_input(INPUT_GET, 'monto');
        $tipo = \filter_input(INPUT_GET, 'tipo_faltante');
        $this->transporte = $this->distrib_transporte->get($this->empresa->id, $idtransporte, $codalmacen);
        $faltante = new distribucion_faltantes();
        $faltante->idempresa = $this->empresa->id;
        $faltante->idtransporte = $idtransporte;
        $faltante->codalmacen = $codalmacen;
        $faltante->coddivisa = $this->empresa->coddivisa;
        $faltante->idreciboref = NULL;
        $faltante->codtrans = $codtrans;
        $faltante->conductor = $conductor;
        $faltante->nombreconductor = $this->transporte->conductor_nombre;
        $faltante->fecha = Date('d-m-Y');
        $faltante->fechav = Date('d-m-Y', strtotime($faltante->fecha . ' +1month'));
        $faltante->fecha_creacion = Date('d-m-Y H:i');
        $faltante->usuario_creacion = $this->user->nick;
        $faltante->importe = $importe;
        $faltante->tipo = $tipo;
        $faltante->estado = "pendiente";
        if ($faltante->save()) {
            $ejercicio0 = $this->ejercicio->get_by_fecha($faltante->fecha);
            if ($faltante->generar_asiento_faltante($faltante, $ejercicio0->codejercicio)) {
                $data['success'] = TRUE;
                $data['ejercicio'] = $ejercicio0->codejercicio;
                $data['recibo'] = $faltante->idrecibo;
            }
            $data['success'] = FALSE;
            $data['ejercicio'] = $ejercicio0->codejercicio;
            $data['recibo'] = $faltante->idrecibo;
        } else {
            $data['success'] = FALSE;
            $data['recibo'] = NULL;
        }
        $this->template = false;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function get_subcuentas_pago() {
        $subcuentas_pago = array();

        $eje0 = new ejercicio();
        $ejercicio = $eje0->get_by_fecha($this->today());
        if ($ejercicio) {
            /// añadimos todas las subcuentas de caja
            $sql = "SELECT * FROM co_subcuentas WHERE idcuenta IN "
                    . "(SELECT idcuenta FROM co_cuentas WHERE codejercicio = "
                    . $ejercicio->var2str($ejercicio->codejercicio) . " AND idcuentaesp = 'CAJA');";
            $data = $this->db->select($sql);
            if ($data) {
                foreach ($data as $d) {
                    $subcuentas_pago[] = new subcuenta($d);
                }
            }
        }

        return $subcuentas_pago;
    }

    public function share_extensions() {
        $extensiones = array(
            array(
                'name' => 'ordencarga_datepicker_es_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script type="text/javascript" src="' . FS_PATH . 'plugins/distribucion/view/js/locale/datepicker-es.js"></script>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script type="text/javascript" src="' . FS_PATH . 'plugins/distribucion/view/js/jquery-ui.min.js"></script>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_css1',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/jquery-ui.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_css2',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/jquery-ui.structure.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_css3',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/jquery-ui.theme.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css4',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/distribucion.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css5',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" type="text/css" media="screen" href="' . FS_PATH . 'plugins/distribucion/view/css/ui.jqgrid-bootstrap.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css6',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/locale/grid.locale-es.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css7',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/plugins/jquery.jqGrid.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_js9',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/bootstrap-select.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_js10',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/locale/defaults-es_CL.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css11',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" type="text/css" media="screen" href="' . FS_PATH . 'plugins/distribucion/view/css/bootstrap-select.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_js12',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/bootbox.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_js13',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/plugins/validator.min.js" type="text/javascript"></script>',
                'params' => ''
            )
        );

        foreach ($extensiones as $ext) {
            $fsext0 = new fs_extension($ext);
            if (!$fsext0->delete()) {
                $this->new_error_msg('Imposible guardar los datos de la extensión ' . $ext['name'] . '.');
            }
        }

        $extensiones2 = array(
            array(
                'name' => '001_ordencarga_jqueryui_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script type="text/javascript" src="' . FS_PATH . 'plugins/distribucion/view/js/jquery-ui.min.js"></script>',
                'params' => ''
            ),
            array(
                'name' => '002_distribucion__grid_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/plugins/jquery.jqGrid.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => '003_distribucion_gridlocale_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/locale/grid.locale-es.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => '004_distribucion_bootstrap-select_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/bootstrap-select.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => '005_distribucion_validator_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/plugins/validator.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => '008_ordencarga_datepicker_es_js',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script type="text/javascript" src="' . FS_PATH . 'plugins/distribucion/view/js/locale/datepicker-es.js"></script>',
                'params' => ''
            ),
            array(
                'name' => '009_distribucion_js10',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<script src="' . FS_PATH . 'plugins/distribucion/view/js/locale/defaults-es_CL.min.js" type="text/javascript"></script>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_css1',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/jquery-ui.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_css2',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/jquery-ui.structure.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'ordencarga_jqueryui_css3',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/jquery-ui.theme.min.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css4',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" href="' . FS_PATH . 'plugins/distribucion/view/css/distribucion.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css5',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" type="text/css" media="screen" href="' . FS_PATH . 'plugins/distribucion/view/css/ui.jqgrid-bootstrap.css"/>',
                'params' => ''
            ),
            array(
                'name' => 'distribucion_css11',
                'page_from' => __CLASS__,
                'page_to' => 'distrib_creacion',
                'type' => 'head',
                'text' => '<link rel="stylesheet" type="text/css" media="screen" href="' . FS_PATH . 'plugins/distribucion/view/css/bootstrap-select.min.css"/>',
                'params' => ''
            ),
        );

        foreach ($extensiones2 as $ext) {
            $fsext0 = new fs_extension($ext);
            if (!$fsext0->save()) {
                $this->new_error_msg('Imposible guardar los datos de la extensión ' . $ext['name'] . '.');
            }
        }
    }

}
