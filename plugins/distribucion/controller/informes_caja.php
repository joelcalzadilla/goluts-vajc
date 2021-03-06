<?php

/*
 * Copyright (C) 2016 Joe Nilson <joenilson at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
require_model('almacenes.php');
require_model('distribucion_faltantes.php');
require_model('distribucion_ordenescarga_facturas.php');
require_model('facturas_cliente.php');
require_model('facturas_proveedor.php');
require_model('forma_pago.php');
require_once 'plugins/facturacion_base/extras/xlsxwriter.class.php';
require_once 'plugins/distribucion/extras/distribucion_controller.php';
/**
 * Description of informes_caja
 *
 * @author Joe Nilson <joenilson at gmail.com>
 */
class informes_caja extends distribucion_controller {
    public $almacenes;
    public $facturascli;
    public $facturaspro;
    public $faltantes;
    public $f_desde;
    public $f_hasta;
    public $codalmacen;
    public $total;
    public $ingresos;
    public $ingresos_condpago;
    public $cobros_condpago;
    public $egresos;
    public $egresos_condpago;
    public $pagos_condpago;
    public $cobros;
    public $resultados_cobros;
    public $resultados_pendientes;
    public $resultados_ingresos;
    public $resultados_egresos;
    public $resultados_pendientes_anteriores;
    public $resultados_cobros_anteriores;
    public $resultados_egresos_formas_pago;
    public $resultados_formas_pago;
    public $resultados_faltantes_cobrados;
    public $resultados_faltantes_pendientes;
    public $total_ingresos;
    public $total_cobros;
    public $total_pendientes_cobro;
    public $total_pendientes_anteriores;
    public $total_cobros_anteriores;
    public $total_egresos;
    public $total_pagos;
    public $total_pendientes_pago;
    public $total_general;
    public $total_ventas;
    public $total_faltantes_ventas;
    public $total_faltantes_compras;
    public $total_compras;
    public $pagadas;
    public $pagadas_anteriores;
    public $pendientes;
    public $pendientes_anteriores;
    public $fp;
    public $detalle;
    public $fileNameXLS;
    public $pathNameXLS;
    public $distribucion_ordenescarga_factura;
    public function __construct() {
        parent::__construct(__CLASS__, 'Caja', 'informes', FALSE, TRUE, FALSE);
    }

    protected function private_core() {
        parent::private_core();
        $this->almacenes = new almacen();
        $this->facturascli = new factura_cliente();
        $this->facturaspro = new factura_proveedor();
        $this->faltantes = new distribucion_faltantes();
        $this->distribucion_ordenescarga_factura = new distribucion_ordenescarga_facturas();
        $this->fp = new forma_pago();
        $this->resultados_formas_pago = false;

        //Creamos o validamos las carpetas para grabar los informes de caja
        $this->fileName = '';
        $this->publicPath = FS_PATH . FS_MYDOCS . 'documentos' . DIRECTORY_SEPARATOR . 'caja';
        
        $f_desde = filter_input(INPUT_POST, 'f_desde');
        $this->f_desde = ($f_desde)?$f_desde:\date('d-m-Y');
        $f_hasta = filter_input(INPUT_POST, 'f_hasta');
        $this->f_hasta = ($f_hasta)?$f_hasta:\date('d-m-Y');
        $codalmacen = filter_input(INPUT_POST, 'codalmacen');
        $this->codalmacen = ($this->user->codalmacen)?$this->user->codalmacen:$codalmacen;
        $accion = filter_input(INPUT_POST, 'accion');
        if($accion){
            switch ($accion){
                case "buscar":
                    $this->pagadas = array();
                    $this->pendientes = array();
                    $this->detalle = array();
                    $this->generar_formas_pago();
                    $this->total_general = 0;
                    $this->ingresos();
                    $this->cobros_anteriores();
                    $this->pendientes_anteriores();
                    $this->egresos();
                    $this->generar_excel();
                break;
            }
        }
    }

    private function generar_excel(){
        $this->pathNameXLS = $this->cajaDir . DIRECTORY_SEPARATOR . 'informe' . "_" . $this->user->nick . ".xlsx";
        $this->fileNameXLS = $this->publicPath . DIRECTORY_SEPARATOR . 'informe' . "_" . $this->user->nick . ".xlsx";
        if (file_exists($this->fileNameXLS)) {
            unlink($this->fileNameXLS);
        }
        $cabeceraResumenIngresos = array();
        $cabeceraResumenIngresos['Tipo'] = 'string';
        $cabeceraResumenIngresos['Facturado'] = '#,###,###.##';
        $cabeceraResumenIngresos['Cobrado'] = '#,###,###.##';
        $cabeceraResumenIngresos['Por Cobrar'] = '#,###,###.##';
        $cabeceraResumenIngresos[''] = '#,###,###.##';
        $estilo_cabecera = array('border'=>'left,right,top,bottom','font-style'=>'bold');
        $this->writer = new XLSXWriter();
        $this->writer->writeSheetHeader('Resumen', $cabeceraResumenIngresos);
        $this->writer->writeSheetRow('Resumen', array('Detalle de Ingresos', '', ''));
        $this->writer->writeSheetRow('Resumen', array('Ventas', $this->total_ventas, $this->pagadas['ventas'], $this->pendientes['ventas']));
        $this->writer->writeSheetRow('Resumen', array('Faltantes', $this->total_faltantes_ventas, $this->pagadas['faltantes_ventas'], $this->pendientes['faltantes_ventas']));
        $this->writer->writeSheetRow('Resumen', array('Total', $this->total_ingresos, $this->total_cobros, $this->total_pendientes_cobro));
        $this->writer->writeSheetHeader('Resumen', $cabeceraResumenIngresos);
        $this->writer->writeSheetRow('Resumen', array('Detalle de Egresos', '', ''));
        $this->writer->writeSheetRow('Resumen', array('Compras', $this->total_compras, $this->pagadas['compras'], $this->pendientes['compras']));
        $this->writer->writeSheetRow('Resumen', array('Faltantes', $this->total_faltantes_compras, $this->pagadas['faltantes_compras'], $this->pendientes['faltantes_compras']));
        $this->writer->writeSheetRow('Resumen', array('Total', $this->total_egresos, $this->total_pagos, $this->total_pendientes_pago));
        $this->writer->writeSheetRow('Resumen', array('', '', ''));
        $this->writer->writeSheetRow('Resumen', array('', '', ''));
        $this->writer->writeSheetRow('Resumen', array('', '', ''));
        $this->writer->writeSheetRow('Resumen', array('Movimientos por Formas de Pago', '', '','',''));
        $totales_fp = array();
        $totales_fp['ingresos_brutos'] = 0;
        $totales_fp['ingresos_netos'] = 0;
        $totales_fp['egresos_brutos'] = 0;
        $totales_fp['egresos_netos'] = 0;
        foreach($this->fp->all() as $fp){
            $this->writer->writeSheetRow('Resumen', array($fp->descripcion, $this->ingresos_condpago[$fp->codpago], $this->cobros_condpago[$fp->codpago], $this->egresos_condpago[$fp->codpago], $this->pagos_condpago[$fp->codpago]));
            $totales_fp['ingresos_brutos'] += $this->ingresos_condpago[$fp->codpago];
            $totales_fp['ingresos_netos'] += $this->cobros_condpago[$fp->codpago];
            $totales_fp['egresos_brutos'] += $this->egresos_condpago[$fp->codpago];
            $totales_fp['egresos_netos'] += $this->pagos_condpago[$fp->codpago];
        }
        $this->writer->writeSheetRow('Resumen', array('Total', $totales_fp['ingresos_brutos'], $totales_fp['ingresos_netos'], $totales_fp['egresos_brutos'], $totales_fp['egresos_netos']));
        $cabeceraDetalleVenta = array();
        $cabeceraDetalleVenta['Factura'] = 'string';
        $cabeceraDetalleVenta[FS_NUMERO2] = 'string';
        $cabeceraDetalleVenta['Transporte'] = '0';
        $cabeceraDetalleVenta['Cliente'] = 'string';
        $cabeceraDetalleVenta['Pagada'] = 'string';
        $cabeceraDetalleVenta['Importe'] = '#,###,###.##';
        $cabeceraDetalleVenta['Rect'] = '#,###,###.##';
        $cabeceraDetalleVenta['Abonos'] = '#,###,###.##';
        $cabeceraDetalleVenta['Saldo'] = '#,###,###.##';
        $cabeceraDetalleVenta['Fecha Factura'] = 'date';
        $cabeceraDetalleVenta['Vencimiento'] = 'date';
        $cabeceraDetalleVenta['Fecha Pago'] = 'date';
        $this->writer->writeSheetHeader('Ventas', $cabeceraDetalleVenta);
        $totalImporte=0;
        $totalRectificativas=0;
        $totalAbonos=0;
        $totalSaldo=0;
        foreach($this->detalle['ventas'] as $factura){
            $this->writer->writeSheetRow('Ventas', array($factura->codigo, $factura->numero2, $factura->transporte, $factura->nombrecliente, ($factura->pagada)?'Pagada':'Pendiente', $factura->total, $factura->rectificativa, $factura->abonos, $factura->saldo, \date('Y-m-d',strtotime($factura->fecha)),\date('Y-m-d',strtotime($factura->vencimiento)), ($factura->fecha_pago)?\date('Y-m-d',strtotime($factura->fecha_pago)):''));
            $totalImporte+=$factura->total;
            $totalRectificativas+=$factura->rectificativa;
            $totalAbonos+=$factura->abonos;
            $totalSaldo+=$factura->saldo;
        }
        $this->writer->writeSheetRow('Ventas', array('Total Montos Facturas', '','', '', '', $totalImporte, $totalRectificativas, $totalAbonos, $totalSaldo, '','',''), $estilo_cabecera);
        $this->writer->writeSheetRow('Ventas', array('Total Facturas', '','', '', '', 0, 0, 0, ($totalAbonos+$totalSaldo), '','',''), $estilo_cabecera);
        $totalImporteFaltantes=0;
        $totalAbonosFaltantes=0;
        $totalSaldoFaltantes=0;
        foreach($this->detalle['faltantes'] as $factura){
            $factura->saldo = ($factura->total+$factura->rectificativa)-$factura->abonos;
            $this->writer->writeSheetRow('Ventas', array($factura->idrecibo, '', '', $factura->conductor_nombre, ucfirst($factura->estado), $factura->importe, 0, $factura->importe_abonos, $factura->importe_saldo, \date('Y-m-d',strtotime($factura->fecha)), '', ($factura->fechap)?\date('Y-m-d',strtotime($factura->fechap)):''));
            $totalImporteFaltantes+=$factura->importe;
            $totalAbonosFaltantes+=$factura->importe_abonos;
            $totalSaldoFaltantes+=$factura->importe_saldo;
        }

        $this->writer->writeSheetRow('Ventas', array('Total Montos Faltantes', '','', '', '', $totalImporteFaltantes, 0, $totalAbonosFaltantes, $totalSaldoFaltantes, '', '',''), $estilo_cabecera);
        $this->writer->writeSheetRow('Ventas', array('Total Faltantes', '', '', '','', 0, 0, 0, ($totalSaldoFaltantes), '',''), $estilo_cabecera);

        $totalImporteCA = 0;
        $totalRectificativasCA = 0;
        $totalAbonosCA = 0;
        $totalSaldoCA = 0;
        foreach($this->detalle['cobros_anteriores'] as $factura){
            $this->writer->writeSheetRow('Ventas', array($factura->codigo, $factura->numero2, $factura->transporte, $factura->nombrecliente, ($factura->pagada)?'Pagada':'Pendiente', $factura->total, $factura->rectificativa, $factura->abonos, $factura->saldo, \date('Y-m-d',strtotime($factura->fecha)),\date('Y-m-d',strtotime($factura->vencimiento)), ($factura->fecha_pago)?\date('Y-m-d',strtotime($factura->fecha_pago)):''));
            $totalImporteCA+=$factura->total;
            $totalRectificativasCA+=$factura->rectificativa;
            $totalAbonosCA+=$factura->abonos;
            $totalSaldoCA+=$factura->saldo;
            $totalAbonos+=$factura->abonos;
            $totalSaldo+=$factura->saldo;
        }
        $this->writer->writeSheetRow('Ventas', array('Total Cobros Anteriores', '','', '', '', $totalImporteCA, $totalRectificativasCA, $totalAbonosCA, $totalSaldoCA, '','',''), $estilo_cabecera);
        $this->writer->writeSheetRow('Ventas', array('Total Facturas Anteriores', '','', '', '', 0, 0, 0, ($totalAbonosCA+$totalSaldoCA), '','',''), $estilo_cabecera);

        $this->writer->writeSheetRow('Ventas', array('Total Ingreso Neto', '', '', '', '', 0, 0, 0, (($totalAbonos+$totalSaldo)-$totalSaldoFaltantes), '','',''), $estilo_cabecera);

        $totalImportePC = 0;
        $totalRectificativasPC = 0;
        $totalAbonosPC = 0;
        $totalSaldoPC = 0;
        foreach($this->detalle['anteriores'] as $factura){
            $this->writer->writeSheetRow('Ventas', array($factura->codigo, $factura->numero2, $factura->transporte, $factura->nombrecliente, ($factura->pagada)?'Pagada':'Pendiente', $factura->total, $factura->rectificativa, $factura->abonos, $factura->saldo, \date('Y-m-d',strtotime($factura->fecha)),\date('Y-m-d',strtotime($factura->vencimiento)), ($factura->fecha_pago)?\date('Y-m-d',strtotime($factura->fecha_pago)):''));
            $totalImportePC+=$factura->total;
            $totalRectificativasPC+=$factura->rectificativa;
            $totalAbonosPC+=$factura->abonos;
            $totalSaldoPC+=$factura->saldo;

        }
        $this->writer->writeSheetRow('Ventas', array('Total Pendientes Anteriores', '','', '', '', $totalImportePC, $totalRectificativasPC, $totalAbonosPC, $totalSaldoPC, '','',''), $estilo_cabecera);
        $this->writer->writeSheetRow('Ventas', array('Total Facturas Pendientes Anteriores', '','', '', '', 0, 0, 0, ($totalAbonosPC+$totalSaldoPC), '','',''), $estilo_cabecera);

        //Hoja de Cuadre contable de Documentos
        $this->writer->writeSheetHeader('Cuadre Ventas', $cabeceraDetalleVenta);
        $totalImporte2=0;
        $totalRectificativas2=0;
        $totalAbonos2=0;
        $totalSaldo2=0;
        foreach($this->detalle['ventas'] as $factura){
            $factura->saldo = ($factura->total+$factura->rectificativa)-$factura->abonos;
            $this->writer->writeSheetRow('Cuadre Ventas', array($factura->idfactura, $factura->numero2, $factura->transporte, $factura->nombrecliente, ($factura->pagada)?'Pagada':'Pendiente', $factura->total, $factura->rectificativa, $factura->abonos, $factura->saldo, \date('Y-m-d',strtotime($factura->fecha)), \date('Y-m-d',strtotime($factura->vencimiento)), ($factura->fecha_pago)?\date('Y-m-d',strtotime($factura->fecha_pago)):''));
            if($factura->get_rectificativas()){
                foreach($factura->get_rectificativas() as $rectificativa){
                    $this->writer->writeSheetRow('Cuadre Ventas', array($rectificativa->idfactura, $rectificativa->numero2, $factura->transporte, ucfirst(FS_FACTURA_RECTIFICATIVA), ($rectificativa->anulada)?'Anulada':'Activa', 0, $rectificativa->total, 0, 0, \date('Y-m-d',strtotime($rectificativa->fecha)), '', ''));
                }
            }
            $totalImporte2+=$factura->total;
            $totalRectificativas2+=$factura->rectificativa;
            $totalAbonos2+=$factura->abonos;
            $totalSaldo2+=$factura->saldo;
        }
        $this->writer->writeSheetRow('Cuadre Ventas', array('Total Montos Facturas', '', '','', '', $totalImporte2, $totalRectificativas2, $totalAbonos2, $totalSaldo2, '', '',''), $estilo_cabecera);
        $this->writer->writeSheetRow('Cuadre Ventas', array('Total Facturas', '', '','', '', 0, 0, 0, ($totalAbonos2+$totalSaldo2), '', '',''), $estilo_cabecera);
        $totalImporteFaltantes2=0;
        $totalAbonosFaltantes2=0;
        $totalSaldoFaltantes2=0;
        foreach($this->detalle['faltantes'] as $factura){
            $factura->saldo = ($factura->total+$factura->rectificativa)-$factura->abonos;
            $this->writer->writeSheetRow('Cuadre Ventas', array($factura->idrecibo, '', '', $factura->conductor_nombre, ucfirst($factura->estado), $factura->importe, 0, $factura->importe_abonos, $factura->importe_saldo, \date('Y-m-d',strtotime($factura->fecha)), ($factura->fechap)?\date('Y-m-d',strtotime($factura->fechap)):''));
            if($factura->get_pagos()){
                foreach($factura->get_pagos() as $recibo){
                    $this->writer->writeSheetRow('Cuadre Ventas', array($recibo->idrecibo, '', '', '', ucfirst($factura->estado), $factura->importe, 0, 0, 0, \date('Y-m-d',strtotime($factura->fecha)), ''));
                }
            }
            $totalImporteFaltantes+=$factura->importe;
            $totalAbonosFaltantes+=$factura->importe_abonos;
            $totalSaldoFaltantes+=$factura->importe_saldo;
        }

        $this->writer->writeSheetRow('Cuadre Ventas', array('Total Montos Faltantes','', '', '', '', $totalImporteFaltantes2, 0, $totalAbonosFaltantes2, $totalSaldoFaltantes2, '',''));
        $this->writer->writeSheetRow('Cuadre Ventas', array('Total Faltantes', '','', '', '', 0, 0, 0, ($totalSaldoFaltantes2), '',''));
        $this->writer->writeSheetRow('Cuadre Ventas', array('Total Ingreso Neto','', '', '', '', 0, 0, 0, (($totalAbonos2+$totalSaldo2)-$totalSaldoFaltantes2), '',''));

        //Hoja de Detalle de Compras
        $this->writer->writeSheetHeader('Compras', $cabeceraDetalleVenta);
        $totalImporteCompras=0;
        $totalRectificativasCompras=0;
        $totalAbonosCompras=0;
        $totalSaldoCompras=0;
        foreach($this->detalle['compras'] as $factura){
            $factura->saldo = ($factura->total+$factura->rectificativa)-$factura->abonos;
            $this->writer->writeSheetRow('Compras', array($factura->idfactura, $factura->numproveedor, '', $factura->nombre, ($factura->pagada)?'Pagada':'Pendiente', $factura->total, $factura->rectificativa, $factura->abonos, $factura->saldo, \date('Y-m-d',strtotime($factura->fecha)),\date('Y-m-d',strtotime($factura->vencimiento)), ($factura->fecha_pago)?\date('Y-m-d',strtotime($factura->fecha_pago)):''));
            $totalImporteCompras+=$factura->total;
            $totalRectificativasCompras+=$factura->rectificativa;
            $totalAbonosCompras+=$factura->abonos;
            $totalSaldoCompras+=$factura->saldo;
        }
        $this->writer->writeSheetRow('Compras', array('Total','', '', '', '', $totalImporteCompras, $totalRectificativasCompras, $totalAbonosCompras, $totalSaldoCompras, '',''));
        $this->writer->writeSheetRow('Compras', array('Total','', '', '', '', 0, 0, 0, ($totalAbonosCompras+$totalSaldoCompras), '',''));
        $this->writer->writeToFile($this->pathNameXLS);
        gc_collect_cycles();
    }

    private function generar_formas_pago(){
        foreach($this->fp->all() as $fp){
            $this->ingresos_condpago[$fp->codpago] = 0;
            $this->cobros_condpago[$fp->codpago] = 0;
            $this->egresos_condpago[$fp->codpago] = 0;
            $this->pagos_condpago[$fp->codpago] = 0;
        }
    }

    /**
     * //Buscamos todos los ingresos, ya seán por ventas o por cobros de faltantes
     */
    private function ingresos(){
        $this->total_ingresos = 0;
        $this->total_cobros = 0;
        $this->total_pendientes_cobro = 0;
        $this->total_ventas = 0;
        $this->total_faltantes_ventas = 0;
        $this->pagadas['ventas'] = 0;
        $this->pagadas['faltantes_ventas'] = 0;
        $this->pendientes['ventas'] = 0;
        $this->pendientes['faltantes_ventas'] = 0;
        $this->detalle['ventas'] = array();
        $query_ventas = "f.fecha >= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_desde)))
                ." AND f.fecha <= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_hasta)))
                ." AND f.codalmacen = ".$this->facturascli->var2str($this->codalmacen)
                ." AND f.anulada = FALSE and f.idfacturarect IS NULL ";
        if($this->tesoreria)
        {
            //Obtenemos las ventas que no estén anuladas y sacamos las que estén o no pagadas
            $sql_ventas = "SELECT recli.fechap,recli.abonos,fr.rectificativa,dof.idtransporte,f.* FROM facturascli as f ".
                " left outer join (select idfactura,max(fechap) as fechap,sum(importe) as abonos from reciboscli as rc where estado = 'Pagado' and fecha >= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_desde)))
                ." AND fecha <= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_hasta)))." group by idfactura) as recli ON (recli.idfactura = f.idfactura)".
                " left outer join (select idfacturarect,max(fecha) as fechar,sum(total) as rectificativa from facturascli as f2 where anulada = false and fecha >= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_desde)))
                ." AND fecha <= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_hasta)))." group by idfacturarect) as fr ON (fr.idfacturarect = f.idfactura) ".
                " left outer join distribucion_ordenescarga_facturas as dof ON (dof.idfactura = f.idfactura)".
                " WHERE $query_ventas ORDER BY f.fecha,f.idfactura";
        }
        else
        {
            //Obtenemos las ventas que no estén anuladas y sacamos las que estén o no pagadas
            $sql_ventas = "SELECT ca.fecha as fechap,f.total as abonos,fr.rectificativa,dof.idtransporte,f.* FROM facturascli as f ".
                " left outer join co_asientos as ca ON (ca.documento = f.codigo AND ca.idasiento = f.idasientop and ca.codejercicio = f.codejercicio and fecha >= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_desde)))
                ." AND fecha <= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_hasta))).") ".
                " left outer join (select idfacturarect,max(fecha) as fechar,sum(total) as rectificativa from facturascli as f2 where anulada = falseand fecha >= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_desde)))
                ." AND fecha <= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_hasta)))." group by idfacturarect) as fr ON (fr.idfacturarect = f.idfactura) ".
                " left outer join distribucion_ordenescarga_facturas as dof ON (dof.idfactura = f.idfactura) ".
                " WHERE $query_ventas ORDER BY f.fecha,f.idfactura";
        }
        $lista_ventas = $this->db->select($sql_ventas);
        if($lista_ventas){
            foreach($lista_ventas as $d){
                $factura = new factura_cliente($d);
                $factura->transporte = $d['idtransporte'];
                $factura->total = ($this->empresa->coddivisa == $factura->coddivisa)?$factura->total:$this->euro_convert($this->divisa_convert($factura->total, $factura->coddivisa, 'EUR'));
                $factura->fecha_pago = '';
                $factura->abonos = $d['abonos'];
                $factura->rectificativa = $d['rectificativa'];

                if($factura->pagada)
                {
                    if($this->comparar_fechas($d['fechap'],'dentro'))
                    {
                        $this->total_cobros += $factura->total;
                        $this->pagadas['ventas'] += $factura->total;
                        $this->cobros_condpago[$factura->codpago] += $factura->total;
                        $factura->abonos = $factura->total;
                        $factura->fecha_pago = $d['fechap'];
                    }
                    else
                    {
                        $this->total_pendientes_cobro += $factura->total;
                        $this->pendientes['ventas'] += $factura->total;
                    }
                }else{
                    $this->total_pendientes_cobro += $factura->total;
                    $this->pendientes['ventas'] += $factura->total;
                }

                if(round($factura->rectificativa+$factura->total,0) == 0){
                    $factura->abonos = 0;
                }else{
                    if($factura->pagada)
                    {
                        $factura->abonos += $factura->rectificativa;
                    }
                }
                $this->total_cobros += $factura->rectificativa;
                $this->pagadas['ventas'] += $factura->rectificativa;
                $this->cobros_condpago[$factura->codpago] += $factura->rectificativa;

                $factura->saldo = ($factura->total+$factura->rectificativa)-$factura->abonos;
                $factura->pagada = (round($factura->saldo,0)==0)?true:false;
                $this->detalle['ventas'][] = $factura;
                $this->total_ventas += $factura->total;
                $this->total_ingresos += $factura->total;
                $this->ingresos_condpago[$factura->codpago] += $factura->total;
            }
        }
        $this->detalle['faltantes'] = array();
        //Obtenemos los cobros de faltantes
        $recibos_faltantes = $this->faltantes->buscar($this->empresa->id, $this->codalmacen, $this->f_desde, $this->f_hasta, FALSE, FALSE);
        if($recibos_faltantes){
            foreach($recibos_faltantes as $faltante){
                if($faltante->estado == 'pagado' and ($faltante->fechap>=\date('Y-m-d',strtotime($this->f_desde)) AND $faltante->fechap>=\date('Y-m-d',strtotime($this->f_hasta)))){
                    $faltante->importe = ($this->empresa->coddivisa == $faltante->coddivisa)?$faltante->importe:$this->euro_convert($this->divisa_convert($faltante->importe, $faltante->coddivisa, 'EUR'));
                    $this->total_cobros += $faltante->importe;
                    $this->pagadas['faltantes_ventas'] += $faltante->importe;
                    $this->cobros_condpago['CONT'] += $faltante->importe;
                }else{
                    $this->total_pendientes_cobro += $faltante->importe;
                    $this->pendientes['faltantes_ventas'] += $faltante->importe;
                    $this->total_cobros -= $faltante->importe;
                    $this->pagadas['faltantes_ventas'] -= $faltante->importe;
                }
                $this->total_faltantes_ventas += $faltante->importe;
                $this->total_ingresos -= $faltante->importe;
                $this->cobros_condpago['CONT'] -= $faltante->importe;
                $this->detalle['faltantes'][] = $faltante;
                $this->ingresos_condpago['CONT'] += $faltante->importe;
            }
            $this->total_general += $this->total_ingresos;
            
        }
    }

    /**
     * Comparamos las fechas de los documentos para saber si estan dentro de un
     * determinado rango de fechas o fuera del mismo
     * @param type $fecha
     * @param type $tipo
     * @return boolean
     */
    public function comparar_fechas($fecha,$tipo='dentro')
    {
        $respuesta = false;
        if($tipo == 'dentro')
        {
            if(\date('Y-m-d',strtotime($fecha))>=\date('Y-m-d',strtotime($this->f_desde)) AND \date('Y-m-d',strtotime($fecha))<=\date('Y-m-d',strtotime($this->f_hasta)))
            {
                $respuesta = true;
            }
        }
        elseif($tipo == 'fuera')
        {
            if(\date('Y-m-d',strtotime($fecha))<\date('Y-m-d',strtotime($this->f_desde)))
            {
                $respuesta = true;
            }
        }
        return $respuesta;
    }

    /**
     * Obtenemos los abonos de una factura
     * @param factura_cliente $f
     * @return int
     */
    public function factura_abonos(factura_cliente $f)
    {
        $abonos = 0;
        //Si se tiene el plugin tesorería se revisa si tiene abonos por recibos
        if($this->tesoreria)
        {
            require_model('recibo_cliente.php');
            require_model('recibo_factura.php');
            $recibos = new recibo_cliente();
            $recibo_pago = $recibos->all_from_factura($f->idfactura);
            foreach($recibo_pago as $r)
            {
                $recibos->fecha;
                $recibos->fechap;
                $r->importe;
            }
            $pago_venta = ($recibo_pago)?$recibo_pago[0]:FALSE;
        }
        else
        {
            $pago_venta = $f->get_asiento_pago();
        }

        if($pago_venta){
            $fecha_pago = ($this->tesoreria)?$pago_venta->fechap:$pago_venta->fecha;
            if(\date('Y-m-d',strtotime($fecha_pago))>=\date('Y-m-d',strtotime($this->f_desde)) AND \date('Y-m-d',strtotime($fecha_pago))<=\date('Y-m-d',strtotime($this->f_hasta))){
                $abonos = $f->total;
            }
        }
        return $abonos;
    }


    /**
     * Obtenemos los montos de facturas rectificativas de una factura
     * @param factura_cliente $f
     * @return int
     */
    public function factura_rectificativa(factura_cliente $f, $modo = 'adentro')
    {
        $total_rectificativas = 0;
        $rectificativas = $f->get_rectificativas();
        if($rectificativas){
            foreach($rectificativas as $rectificativa){
                if($this->comparar_fechas($rectificativa->fecha,$modo)){
                    $total_rectificativas += $rectificativa->total;
                    $f->fecha_pago = $rectificativa->fecha;
                    if(round($rectificativa->total+$f->total,0) == 0){
                        $f->abonos = 0;
                    }else{
                        if($f->pagada)
                        {
                            $f->abonos += $rectificativa->total;
                        }
                    }
                }
            }
        }
        return $total_rectificativas;
    }


    /**
     * Buscamos las facturas que están pendientes de pago antes de la fecha desde en el reporte
     */
    public function pendientes_anteriores()
    {
        $this->resultados_pendientes_anteriores = array();
        $this->detalle['anteriores'] = array();
        $this->pendientes['anteriores'] = 0;
        $sql = "SELECT * FROM facturascli WHERE pagada = false AND anulada = false and idfacturarect is null ".
            " AND codalmacen = ".$this->empresa->var2str($this->codalmacen).
            " AND fecha < ".$this->empresa->var2str(\date('Y-m-d',strtotime($this->f_desde))).
            " ORDER BY fecha,idfactura";
        $data = $this->db->select($sql);
        if($data)
        {
            foreach($data as $d)
            {
                $f = new factura_cliente($d);
                $f->transporte = $this->distribucion_ordenescarga_factura->get_transporte_factura($this->empresa->id, $f->idfactura, $f->codalmacen);
                $f->abonos = $this->factura_abonos($f);
                $f->rectificativa = $this->factura_rectificativa($f, 'fuera');
                $f->saldo = ($f->total+$f->rectificativa)-$f->abonos;
                $f->fecha_pago = '';
                $this->resultados_pendientes_anteriores[] = $f;
                $this->pendientes['anteriores'] += $f->saldo;
                $this->detalle['anteriores'][] = $f;
                $this->total_pendientes_cobro += $f->saldo;
            }
        }
    }

    /**
     * buscamos las facturas de fechas anteriores que han sido pagadas en esta fecha
     */
    public function cobros_anteriores()
    {
        $this->detalle['cobros_anteriores'] = array();
        $this->pagadas['anteriores']=0;
        if($this->tesoreria)
        {
        $sql = "SELECT facturascli.*,reciboscli.fechap as fechap ".
               " FROM facturascli,reciboscli ".
               " WHERE fechap = ".$this->empresa->var2str(\date('Y-m-d',strtotime($this->f_desde))).
                " AND facturascli.fecha < ".$this->empresa->var2str(\date('Y-m-d',strtotime($this->f_desde))).
                " and reciboscli.idfactura = facturascli.idfactura and codalmacen = ".$this->empresa->var2str($this->codalmacen);
        }
        $data = $this->db->select($sql);
        if($data)
        {
            foreach($data as $d)
            {
                $f = new factura_cliente($d);
                $f->transporte = $this->distribucion_ordenescarga_factura->get_transporte_factura($this->empresa->id, $f->idfactura, $f->codalmacen);
                $f->abonos = $this->factura_abonos($f);
                $f->rectificativa = $this->factura_rectificativa($f, 'fuera');
                $f->saldo = ($f->total+$f->rectificativa)-$f->abonos;
                $f->fecha_pago = $d['fechap'];
                $this->detalle['cobros_anteriores'][] = $f;
                $this->pagadas['anteriores'] += $f->abonos;
                $this->total_cobros += $f->abonos;
                $this->cobros_condpago[$f->codpago] += $f->abonos;
            }
        }
    }

    private function egresos(){
        $this->total_egresos = 0;
        $this->total_pagos = 0;
        $this->total_pendientes_pago = 0;
        $this->total_compras = 0;
        $this->total_faltantes_compras = 0;
        $this->pagadas['compras'] = 0;
        $this->pagadas['faltantes_compras'] = 0;
        $this->pendientes['compras'] = 0;
        $this->pendientes['faltantes_compras'] = 0;
        $this->detalle['compras'] = array();
        //Obtenemos las compras que no estén anuladas y sacamos las que estén o no pagadas
        $query_compras = "fecha >= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_desde)))
                ." AND fecha <= ".$this->facturascli->var2str(\date('Y-m-d',strtotime($this->f_hasta)))
                ." AND codalmacen = ".$this->facturascli->var2str($this->codalmacen)
                ." AND anulada = FALSE ORDER BY fecha";
        $sql_compras = "SELECT * FROM facturasprov WHERE $query_compras";
        $lista_compras = $this->db->select($sql_compras);
        //Obtenemos las facturas de compra por pagar
        if($lista_compras){
            foreach($lista_compras as $f){
                $factura = new factura_proveedor($f);
                $factura->total = ($this->empresa->coddivisa == $factura->coddivisa)?$factura->total:$this->euro_convert($this->divisa_convert($factura->total, $factura->coddivisa, 'EUR'));
                $factura->rectificativa = 0;
                $factura->abonos = 0;
                $factura->fecha_pago = 0;
                $factura->vencimiento = false;
                if($factura->pagada and $factura->idfacturarect == ''){
                    $pago_compra = $factura->get_asiento_pago();
                    if($pago_compra){
                        if(\date('Y-m-d',strtotime($pago_compra->fecha))>=\date('Y-m-d',strtotime($this->f_desde)) AND \date('Y-m-d',strtotime($pago_compra->fecha))<=\date('Y-m-d',strtotime($this->f_hasta))){
                            //Esta pagada a la fecha buscada
                            $this->total_pagos += $factura->total;
                            $this->pagadas['compras'] += $factura->total;
                            $this->pagos_condpago[$factura->codpago] += $factura->total;
                            $factura->fecha_pago = ($this->tesoreria)?$pago_compra->fechap:$pago_compra->fecha;
                        }else{
                            //Esta pendiente a la fecha buscada
                            $this->total_pendientes_pago += $factura->total;
                            $this->pendientes['compras'] += $factura->total;
                        }
                    }else{
                        //Asumimos que va aparecer en esta fecha
                        $this->total_pagos += $factura->total;
                        $this->pagadas['compras'] += $factura->total;
                        $this->pagos_condpago[$factura->codpago] += $factura->total;
                    }
                }else{
                    $this->total_pendientes_pago += $factura->total;
                    $this->pendientes['compras'] += $factura->total;
                }
                $this->detalle['compras'][] = $factura;
                $this->total_egresos += $factura->total;
                $this->total_compras += $factura->total;
                $this->egresos_condpago[$factura->codpago] += $factura->total;
            }
        }
        $this->total_general += $this->total_egresos;
    }

    public function shared_extensions(){

    }
}
