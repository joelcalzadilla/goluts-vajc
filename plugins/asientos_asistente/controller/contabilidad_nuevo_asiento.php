<?php

/*
 * This file is part of asientos_asistente
 * Copyright (C) 2014-2017  Carlos Garcia Gomez  neorazorx@gmail.com
 * Copyright (C) 2014-2017  Pablo Zerón Gea pablozg@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_model('asiento.php');
require_model('concepto_partida.php');
require_model('cuenta_banco.php');
require_model('divisa.php');
require_model('ejercicio.php');
require_model('impuesto.php');
require_model('partida.php');
require_model('regularizacion_iva.php');
require_model('subcuenta.php');

require_model('proveedor.php');
require_model('cuenta.php');
require_model('agente.php');

class contabilidad_nuevo_asiento extends fs_controller
{
    public $asiento;
    public $concepto;
    public $cuenta_banco;
    public $divisa;
    public $ejercicio;
    public $impuesto;
    public $lineas;
    public $resultados;
    public $subcuenta;
    public $proveedor;
    public $cuenta;
    public $agente;
    public $continuar = true;
    private $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    private $eje0;
    private $div0;

    public function __construct()
    {
        parent::__construct(__CLASS__, 'Nuevo asiento', 'contabilidad', false, false, true);
    }

    protected function private_core()
    {
        $this->ppage = $this->page->get('contabilidad_asientos');

        $this->asiento = new asiento();
        $this->concepto = new concepto_partida();
        $this->cuenta_banco = new cuenta_banco();
        $this->divisa = new divisa();
        $this->ejercicio = new ejercicio();
        $this->impuesto = new impuesto();
        $this->lineas = array();
        $this->resultados = array();
        $this->subcuenta = new subcuenta();

        $this->proveedor = new proveedor();
        $this->cuenta = new cuenta();
        $this->agente = new agente();

        if (isset($_POST['fecha']) and isset($_POST['query'])) {
            $this->new_search();
        } elseif (isset($_POST['fecha']) and isset($_POST['concepto']) and isset($_POST['divisa'])) {
            if (filter_input(INPUT_POST, 'tipo_asiento') == '1') {
                if (floatval(filter_input(INPUT_POST, 'autonomo')) > 0) {
                    $this->nuevo_asiento_autonomo();
                    return;
                }
                $this->new_error_msg('Importe no válido: ' . filter_input(INPUT_POST, 'autonomo'));
            } elseif (filter_input(INPUT_POST, 'tipo_asiento') == '2') {
                if (floatval(filter_input(INPUT_POST, 'modelo130')) > 0) {
                    $this->nuevo_asiento_modelo130();
                    return;
                }
                $this->new_error_msg('Importe no válido: ' . filter_input(INPUT_POST, 'modelo130'));
            } elseif (filter_input(INPUT_POST, 'tipo_asiento') == '3') {
                if (floatval(filter_input(INPUT_POST, 'traspasos')) > 0) {
                    $this->nuevo_asiento_traspasos();
                    return;
                }
                $this->new_error_msg('Importe no válido: ' . filter_input(INPUT_POST, 'traspasos'));
            } elseif (filter_input(INPUT_POST, 'tipo_asiento') == '4') {
                if (floatval(filter_input(INPUT_POST, 'anticipos')) > 0) {
                    $this->nuevo_asiento_anticipos();
                    return;
                }
                $this->new_error_msg('Importe no válido: ' . filter_input(INPUT_POST, 'anticipos'));
            } elseif (filter_input(INPUT_POST, 'tipo_asiento') == '5') {
                if (floatval(filter_input(INPUT_POST, 'sal_bruto_ajena')) <= 0) {
                    $this->new_error_msg('Salario bruto no válido: ' . filter_input(INPUT_POST, 'sal_bruto_ajena'));
                    return;
                } elseif (floatval(filter_input(INPUT_POST, 'retenciones_ajena')) <= 0) {
                    $this->new_error_msg('Porcentaje retenciones no válido: ' . filter_input(INPUT_POST, 'retenciones_ajena'));
                    return;
                } elseif (floatval(filter_input(INPUT_POST, 'cuota_patronal')) <= 0) {
                    $this->new_error_msg('Cuota patronal no válida: ' . filter_input(INPUT_POST, 'cuota_patronal'));
                    return;
                } elseif (floatval(filter_input(INPUT_POST, 'cuota_obrera')) <= 0) {
                    $this->new_error_msg('Cuota obrera no válida: ' . filter_input(INPUT_POST, 'cuota_obrera'));
                    return;
                }
                $this->nuevo_asiento_nomina_ajena();
            } elseif (filter_input(INPUT_POST, 'tipo_asiento') == '6') {
                if (floatval(filter_input(INPUT_POST, 'importe_alquiler')) <= 0) {
                    $this->new_error_msg('Importe del alquiler no válido: ' . filter_input(INPUT_POST, 'importe_alquiler'));
                    return;
                } elseif (floatval(filter_input(INPUT_POST, 'retenciones_alquiler')) <= 0) {
                    $this->new_error_msg('Rentención (%) no válido: ' . filter_input(INPUT_POST, 'retenciones_alquiler'));
                    return;
                }
                $this->nuevo_asiento_alquiler();
            } else {
                $this->nuevo_asiento();
            }
        } elseif (filter_input(INPUT_GET, 'copy')) {
            $this->copiar_asiento();
            return;
        }
        $this->check_datos_contables();
    }

    private function get_ejercicio($fecha)
    {
        $ejercicio = false;

        $ejercicio = $this->ejercicio->get_by_fecha($fecha);
        if ($ejercicio) {
            $regiva0 = new regularizacion_iva();
            if ($regiva0->get_fecha_inside($fecha)) {
                $this->new_error_msg('No se puede usar la fecha ' . filter_input(INPUT_POST, 'fecha') . ' porque ya hay'
                        . ' una regularización de ' . FS_IVA . ' para ese periodo.');
                $ejercicio = false;
            }
        } else {
            $this->new_error_msg('Ejercicio no encontrado.');
        }

        return $ejercicio;
    }

    private function nuevo_asiento()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            $this->asiento->codejercicio = $this->eje0->codejercicio;
            $this->asiento->idconcepto = filter_input(INPUT_POST, 'idconceptopar');
            $this->asiento->concepto = filter_input(INPUT_POST, 'concepto');
            $this->asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $this->asiento->importe = floatval(filter_input(INPUT_POST, 'importe'));

            if ($this->asiento->save()) {
                $numlineas = intval(filter_input(INPUT_POST, 'numlineas'));
                for ($i = 1; $i <= $numlineas; $i++) {
                    if (isset($_POST['codsubcuenta_' . $i])) {
                        if (filter_input(INPUT_POST, 'codsubcuenta_' . $i) != '' and $this->continuar) {
                            $sub0 = $this->subcuenta->get_by_codigo(filter_input(INPUT_POST, 'codsubcuenta_' . $i), $this->eje0->codejercicio);
                            if ($sub0) {
                                $partida = new partida();
                                $partida->idasiento = $this->asiento->idasiento;
                                $partida->coddivisa = $this->div0->coddivisa;
                                $partida->tasaconv = $this->div0->tasaconv;
                                $partida->idsubcuenta = $sub0->idsubcuenta;
                                $partida->codsubcuenta = $sub0->codsubcuenta;
                                $partida->debe = floatval(filter_input(INPUT_POST, 'debe_' . $i));
                                $partida->haber = floatval(filter_input(INPUT_POST, 'haber_' . $i));
                                $partida->idconcepto = $this->asiento->idconcepto;
                                $partida->concepto = $this->asiento->concepto;
                                $partida->documento = $this->asiento->documento;
                                $partida->tipodocumento = $this->asiento->tipodocumento;

                                if (isset($POST['codcontrapartida_' . $i])) {
                                    if (filter_input(INPUT_POST, 'codcontrapartida_' . $i) != '') {
                                        $subc1 = $this->subcuenta->get_by_codigo(filter_input(INPUT_POST, 'codcontrapartida_' . $i), $this->eje0->codejercicio);
                                        if ($subc1) {
                                            $partida->idcontrapartida = $subc1->idsubcuenta;
                                            $partida->codcontrapartida = $subc1->codsubcuenta;
                                            $partida->cifnif = filter_input(INPUT_POST, 'cifnif_' . $i);
                                            $partida->iva = floatval(filter_input(INPUT_POST, 'iva_' . $i));
                                            $partida->baseimponible = floatval(filter_input(INPUT_POST, 'baseimp_' . $i));
                                        } else {
                                            $this->new_error_msg('Subcuenta ' . filter_input(INPUT_POST, 'codcontrapartida_' . $i) . ' no encontrada.');
                                            $this->continuar = false;
                                        }
                                    }
                                }

                                if (!$partida->save()) {
                                    $this->new_error_msg('Imposible guardar la partida de la subcuenta ' . filter_input(INPUT_POST, 'codsubcuenta_' . $i) . '.');
                                    $this->continuar = false;
                                }
                            } else {
                                $this->new_error_msg('Subcuenta ' . filter_input(INPUT_POST, 'codsubcuenta_' . $i) . ' no encontrada.');
                                $this->continuar = false;
                            }
                        }
                    }
                }

                if ($this->continuar) {
                    $this->asiento->concepto = '';

                    $this->new_message("<a href='" . $this->asiento->url() . "'>Asiento</a> guardado correctamente!");
                    $this->new_change('Asiento ' . $this->asiento->numero, $this->asiento->url(), true);

                    if (filter_input(INPUT_POST, 'redir') == 'TRUE') {
                        header('Location: ' . $this->asiento->url());
                    }
                } else {
                    if ($this->asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function nuevo_asiento_autonomo()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            $codcaja = '5700000000';
            if (filter_input(INPUT_POST, 'banco')) {
                if (filter_input(INPUT_POST, 'banco') != '') {
                    $codcaja = filter_input(INPUT_POST, 'banco');
                }
            }

            $subc = $this->cuenta_banco->get($codcaja);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $codcaja = $subc->codsubcuenta;
                } else {
                    $codcaja = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $codcaja, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
                $desde_desc = $subc->descripcion;
            }

            /// asiento de cuota
            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;
            $asiento->concepto = 'Cuota de autónomo - ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))];
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;
            $asiento->importe = floatval(filter_input(INPUT_POST, 'autonomo'));

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo('6420000000', $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'D');
                } else {
                    $this->new_error_msg('Subcuenta 6420000000 no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo('4760000000', $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'H');
                } else {
                    $this->new_error_msg('Subcuenta 4760000000 no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de autónomo</a> guardado correctamente!");

                    /// asiento de pago
                    $asiento = new asiento();
                    $asiento->codejercicio = $this->eje0->codejercicio;
                    $asiento->concepto = 'Pago de autónomo ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))];
                    $asiento->fecha = filter_input(INPUT_POST, 'fecha');
                    $asiento->editable = false;
                    $asiento->importe = floatval(filter_input(INPUT_POST, 'autonomo'));

                    if ($asiento->save()) {
                        $subc = $this->subcuenta->get_by_codigo('4760000000', $this->eje0->codejercicio);
                        if ($subc) {
                            $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'D');
                        }

                        $subc = $this->subcuenta->get_by_codigo($codcaja, $this->eje0->codejercicio);
                        if ($subc) {
                            $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'H');
                        }


                        $this->new_message("<a href='" . $asiento->url() . "'>Asiento de pago</a> guardado correctamente!");
                    }
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function nuevo_asiento_modelo130()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            $codcaja = '5700000000';
            if (filter_input(INPUT_POST, 'banco130')) {
                if (filter_input(INPUT_POST, 'banco130') != '') {
                    $codcaja = filter_input(INPUT_POST, 'banco130');
                }
            }

            $subc = $this->cuenta_banco->get($codcaja);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $codcaja = $subc->codsubcuenta;
                } else {
                    $codcaja = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $codcaja, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
                $desde_desc = $subc->descripcion;
            }

            /// asiento de cuota
            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;
            $asiento->concepto = 'Pago modelo 130 - ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))];
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;
            $asiento->importe = floatval(filter_input(INPUT_POST, 'modelo130'));

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo('4730000000', $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'D');
                } else {
                    $this->new_error_msg('Subcuenta 4730000000 no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codcaja, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codcaja . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de pago</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function nuevo_asiento_traspasos()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            // Comprueba la existencia de las cuentas origen y destino, en caso contrario las crea.

            $coddestino = '5700000000';
            $destino_desc = 'Caja';

            if (filter_input(INPUT_POST, 'destino')) {
                if (filter_input(INPUT_POST, 'destino') != '') {
                    $coddestino = filter_input(INPUT_POST, 'destino');
                }
            }

            $subc = $this->cuenta_banco->get($coddestino);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $coddestino = $subc->codsubcuenta;
                } else {
                    $coddestino = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $coddestino, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
                $destino_desc = $subc->descripcion;
            }

            $codcaja = '5700000000';
            $desde_desc = 'Caja';
            if (filter_input(INPUT_POST, 'bancotras')) {
                if (filter_input(INPUT_POST, 'bancotras') != '') {
                    $codcaja = filter_input(INPUT_POST, 'bancotras');
                }
            }

            $subc = $this->cuenta_banco->get($codcaja);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $codcaja = $subc->codsubcuenta;
                } else {
                    $codcaja = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $codcaja, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
                $desde_desc = $subc->descripcion;
            }

            /// asiento de cuota
            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;
            $asiento->concepto = 'Traspaso ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))] . ' (' . $desde_desc . ' a ' . $destino_desc . ')';
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;
            $asiento->importe = floatval(filter_input(INPUT_POST, 'traspasos'));

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo($coddestino, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $coddestino . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codcaja, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codcaja . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de traspaso</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function nuevo_asiento_anticipos()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            if (filter_input(INPUT_POST, 'proveedor')) {
                if (filter_input(INPUT_POST, 'proveedor') != '') {
                    $coddestino = 4070000000 + intval(filter_input(INPUT_POST, 'proveedor'));
                }
            }

            $subc = $this->proveedor->get(filter_input(INPUT_POST, 'proveedor'));
            if (!$subc) {
                $this->new_error_msg('Proveedor ' . filter_input(INPUT_POST, 'proveedor') . ' no encontrado.');
                $this->continuar = false;
            }

            $this->crea_subcuentas($this->eje0->codejercicio, '407', $coddestino, 'Anticipos a proveedores - ' . $subc->razonsocial);
            $Razon_social = $subc->razonsocial;

            /////////////////////////////////////////

            $codcaja = '5700000000';
            if (filter_input(INPUT_POST, 'bancoanticipo')) {
                if (filter_input(INPUT_POST, 'bancoanticipo') != '') {
                    $codcaja = filter_input(INPUT_POST, 'bancoanticipo');
                }
            }

            $subc = $this->cuenta_banco->get($codcaja);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $codcaja = $subc->codsubcuenta;
                } else {
                    $codcaja = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $codcaja, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
            }

            $codtipoiva = 'IVA21';
            if (filter_input(INPUT_POST, 'tipoiva')) {
                if (filter_input(INPUT_POST, 'tipoiva') != '') {
                    $codtipoiva = filter_input(INPUT_POST, 'tipoiva');
                }
            }

            $subc = $this->impuesto->get($codtipoiva);
            if ($subc) {
                if (isset($subc->codsubcuentasop)) {
                    $codivasoportado = $subc->codsubcuentasop;
                } else {
                    $codivasoportado = '4720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '472', $codivasoportado, $subc->descripcion);
                $tipoiva = $subc->iva;
            } else {
                $this->new_error_msg('Tipo de IVA  ' . $codtipoiva . ' no encontrado');
            }

            /// asiento de cuota
            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;
            $asiento->concepto = 'Anticipo a ' . $Razon_social;
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;
            $asiento->importe = floatval(filter_input(INPUT_POST, 'anticipos'));
            $parte_iva = round(($asiento->importe * ($tipoiva / 100)), FS_NF0);
            $parte_base = round(($asiento->importe - $parte_iva), FS_NF0);

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo($coddestino, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $parte_base, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $coddestino . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codivasoportado, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $parte_iva, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codivasoportado . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codcaja, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codcaja . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de anticipo</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function nuevo_asiento_nomina_ajena()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            $codcaja = '5700000000';
            if (filter_input(INPUT_POST, 'banco_nomina_ajena')) {
                if (filter_input(INPUT_POST, 'banco_nomina_ajena') != '') {
                    $codcaja = filter_input(INPUT_POST, 'banco_nomina_ajena');
                }
            }

            $subc = $this->cuenta_banco->get($codcaja);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $codcaja = $subc->codsubcuenta;
                } else {
                    $codcaja = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $codcaja, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
            }

            $subc = $this->agente->get(filter_input(INPUT_POST, 'cod_ajena'));
            if ($subc) {
                $Nombre_empleado = $subc->nombre . ' ' . $subc->apellidos;
            }

            /// asiento de la nómina

            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;

            $asiento->concepto = 'Nómina mes de ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))] . ' (' . $Nombre_empleado . ')';
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;


            /// Crea las subcuentas del empleado si no existen
            ///  Cuenta 640

            $codigo_cuenta_640 = 6400000000 + intval(filter_input(INPUT_POST, 'cod_ajena'));

            $subc = $this->subcuenta->get_by_codigo((string) $codigo_cuenta_640, $this->eje0->codejercicio);
            if (!$subc) {
                $this->crea_subcuentas($this->eje0->codejercicio, '640', $codigo_cuenta_640, 'Sueldos y salarios - ' . $Nombre_empleado);
            }

            ///  Cuenta 642

            $codigo_cuenta_642 = 6420000000 + intval(filter_input(INPUT_POST, 'cod_ajena'));

            $subc = $this->subcuenta->get_by_codigo((string) $codigo_cuenta_642, $this->eje0->codejercicio);
            if (!$subc) {
                $this->crea_subcuentas($this->eje0->codejercicio, '642', $codigo_cuenta_642, 'Seguridad social a cargo de la empresa - ' . $Nombre_empleado);
            }

            ///  Cuenta 476

            $codigo_cuenta_476 = 4760000000 + intval(filter_input(INPUT_POST, 'cod_ajena'));

            $subc = $this->subcuenta->get_by_codigo((string) $codigo_cuenta_476, $this->eje0->codejercicio);
            if (!$subc) {
                $this->crea_subcuentas($this->eje0->codejercicio, '476', $codigo_cuenta_476, 'Organismos de la seguridad social, acreedores - ' . $Nombre_empleado);
            }

            ///  Cuenta 4751

            $codigo_cuenta_4751 = 4751000000 + intval(filter_input(INPUT_POST, 'cod_ajena'));

            $subc = $this->subcuenta->get_by_codigo((string) $codigo_cuenta_4751, $this->eje0->codejercicio);
            if (!$subc) {
                $this->crea_subcuentas($this->eje0->codejercicio, '4751', $codigo_cuenta_4751, 'Hacienda pública, acreedora por retenciones practicadas - ' . $Nombre_empleado);
            }

            ///  Cuenta 465

            $codigo_cuenta_465 = 4650000000 + intval(filter_input(INPUT_POST, 'cod_ajena'));

            $subc = $this->subcuenta->get_by_codigo((string) $codigo_cuenta_465, $this->eje0->codejercicio);
            if (!$subc) {
                $this->crea_subcuentas($this->eje0->codejercicio, '465', $codigo_cuenta_465, 'Remuneraciones pendientes de pago - ' . $Nombre_empleado);
            }

            // Inicio del asiento

            $Importe_salario_bruto = floatval(filter_input(INPUT_POST, 'sal_bruto_ajena'));
            $Importe_cuota_patronal = floatval(filter_input(INPUT_POST, 'cuota_patronal'));
            $Importe_cuota_obrera = floatval(filter_input(INPUT_POST, 'cuota_obrera'));
            $Importe_cuota_ajena = $Importe_cuota_patronal + $Importe_cuota_obrera;
            $Importe_retenciones = round(($Importe_salario_bruto * floatval(filter_input(INPUT_POST, 'retenciones_ajena'))) / 100, FS_NF0);
            $Importe_pendiente_pago = $Importe_salario_bruto - $Importe_cuota_obrera - $Importe_retenciones;

            $asiento->importe = $Importe_salario_bruto + $Importe_cuota_patronal;

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_476, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $Importe_cuota_ajena, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_476 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_4751, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_4751, $Importe_retenciones, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_4751 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_465, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_465, $Importe_pendiente_pago, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_465 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_640, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_640, $Importe_salario_bruto, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_640 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_642, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_642, $Importe_cuota_patronal, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_642 . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de nómina por cuenta ajena</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }

            /// asiento pago de la nómina

            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;

            $asiento->concepto = 'Pago nómina mes de ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))] . ' (' . $Nombre_empleado . ')';
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;

            $asiento->importe = $Importe_pendiente_pago;

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_465, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_465, $Importe_pendiente_pago, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_465 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codcaja, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $Importe_pendiente_pago, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codcaja . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de pago de nómina por cuenta ajena</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function nuevo_asiento_alquiler()
    {
        $this->compruebaInput();

        if ($this->continuar) {
            // Establece el codigo de cuenta de pago y si no existe lo crea

            $codcaja = '5700000000';
            if (filter_input(INPUT_POST, 'banco_alquiler')) {
                if (filter_input(INPUT_POST, 'banco_alquiler') != '') {
                    $codcaja = filter_input(INPUT_POST, 'banco_alquiler');
                }
            }

            $subc = $this->cuenta_banco->get($codcaja);
            if ($subc) {
                if (isset($subc->codsubcuenta)) {
                    $codcaja = $subc->codsubcuenta;
                } else {
                    $codcaja = '5720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '572', $codcaja, 'Bancos e instituciones de crédito c/c vista, euros - ' . $subc->descripcion);
            }

            // Crea la subcuenta del tipo de IVA en la cuenta 472 si no existe

            $codtipoiva = 'IVA21';
            if (filter_input(INPUT_POST, 'tipoiva_alquiler')) {
                if (filter_input(INPUT_POST, 'tipoiva_alquiler') != '') {
                    $codtipoiva = filter_input(INPUT_POST, 'tipoiva_alquiler');
                }
            }

            $subc = $this->impuesto->get($codtipoiva);
            if ($subc) {
                if (isset($subc->codsubcuentasop)) {
                    $codivasoportado = $subc->codsubcuentasop;
                } else {
                    $codivasoportado = '4720000000';
                }

                $this->crea_subcuentas($this->eje0->codejercicio, '472', $codivasoportado, $subc->descripcion);
                $tipoiva = $subc->iva;
            } else {
                $this->new_error_msg('Tipo de IVA  ' . $codtipoiva . ' no encontrado');
            }


            /// Crea la subcuenta del acreedor en la cuenta 410 si no existe

            $cod_acreedor = '4100000000';
            if (filter_input(INPUT_POST, 'acreedor_alquiler')) {
                if (filter_input(INPUT_POST, 'acreedor_alquiler') != '') {
                    // Los acreedores se crean a partir de la 41002 para evitor asignaciones erroneas sobre empleados con la mismo código
                    $cod_acreedor = 4100200000 + intval(filter_input(INPUT_POST, 'acreedor_alquiler'));
                }
            }

            // Los acreedores se crean a partir de la 41002 y 47512 para evitor asignaciones erroneas sobre empleados con la mismo código

            $subc = $this->proveedor->get(filter_input(INPUT_POST, 'acreedor_alquiler'));
            if ($subc) {
                // Cuenta 4100
                $this->crea_subcuentas($this->eje0->codejercicio, '4100', $cod_acreedor, 'Acreedores por prestaciones de servicios - ' . $subc->razonsocial);

                // Cuenta 4751
                $codigo_cuenta_4751 = 4751200000 + intval(filter_input(INPUT_POST, 'acreedor_alquiler'));
                $this->crea_subcuentas($this->eje0->codejercicio, '4751', $codigo_cuenta_4751, 'Hacienda pública, acreedora por retenciones practicadas - ' . $subc->razonsocial);

                // Cuenta 621
                $codigo_cuenta_621 = 6210200000 + intval(filter_input(INPUT_POST, 'acreedor_alquiler'));
                $this->crea_subcuentas($this->eje0->codejercicio, '621', $codigo_cuenta_621, 'Arrendamientos y cánones - ' . $subc->razonsocial);

                $acreedor = $subc->razonsocial;
            } else {
                $this->new_error_msg('Código acreedor ' . filter_input(INPUT_POST, 'acreedor_alquiler') . ' no encontrado.');
                $this->continuar = false;
            }

            $descripcion_alquiler = filter_input(INPUT_POST, 'concepto_alquiler') . ' (' . $acreedor . ')';

            /// Asiento del alquiler

            $Importe_alquiler = floatval(filter_input(INPUT_POST, 'importe_alquiler'));
            $Retenciones_alquiler = floatval(filter_input(INPUT_POST, 'retenciones_alquiler'));

            $Importe_iva_alquiler = round(($Importe_alquiler * $tipoiva) / 100, FS_NF0);
            $Importe_retenciones_alquiler = round(($Importe_alquiler * $Retenciones_alquiler) / 100, FS_NF0);
            $Total_importe = $Importe_alquiler + ($Importe_iva_alquiler - $Importe_retenciones_alquiler);

            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;

            $asiento->concepto = 'Alquiler mes de ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))] . ' ' . $descripcion_alquiler;
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;
            $asiento->importe = $Importe_alquiler + $Importe_iva_alquiler;

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_621, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_621, $Importe_alquiler, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_621 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codigo_cuenta_4751, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codigo_cuenta_4751, $Importe_retenciones_alquiler, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codigo_cuenta_4751 . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codivasoportado, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $codivasoportado, $Importe_iva_alquiler, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codivasoportado . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($cod_acreedor, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $cod_acreedor, $Total_importe, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $cod_acreedor . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de alquiler</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }

            /// asiento pago del alquiler

            $asiento = new asiento();
            $asiento->codejercicio = $this->eje0->codejercicio;

            $asiento->concepto = 'Pago alquiler mes de ' . $this->meses[intval(date('m', strtotime(filter_input(INPUT_POST, 'fecha'))))] . ' ' . $descripcion_alquiler;
            $asiento->fecha = filter_input(INPUT_POST, 'fecha');
            $asiento->editable = false;
            $asiento->importe = $Total_importe;

            if ($asiento->save()) {
                $subc = $this->subcuenta->get_by_codigo($cod_acreedor, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $cod_acreedor, $asiento->importe, 'D');
                } else {
                    $this->new_error_msg('Subcuenta ' . $cod_acreedor . ' no encontrada.');
                    $this->continuar = false;
                }

                $subc = $this->subcuenta->get_by_codigo($codcaja, $this->eje0->codejercicio);
                if ($subc) {
                    $this->crea_partida($asiento->idasiento, $this->div0->coddivisa, $this->div0->tasaconv, $asiento->concepto, $subc->idsubcuenta, $subc->codsubcuenta, $asiento->importe, 'H');
                } else {
                    $this->new_error_msg('Subcuenta ' . $codcaja . ' no encontrada.');
                    $this->continuar = false;
                }

                if ($this->continuar) {
                    $this->new_message("<a href='" . $asiento->url() . "'>Asiento de pago de alquiler</a> guardado correctamente!");
                } else {
                    if ($asiento->delete()) {
                        $this->new_error_msg("¡Error en alguna de las partidas! Se ha borrado el asiento.");
                    } else {
                        $this->new_error_msg("¡Error en alguna de las partidas! Además ha sido imposible borrar el asiento.");
                    }
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el asiento!");
            }
        }
    }

    private function copiar_asiento()
    {
        $copia = $this->asiento->get(filter_input(INPUT_GET, 'copy'));
        if ($copia) {
            $this->asiento->concepto = $copia->concepto;

            foreach ($copia->get_partidas() as $part) {
                $subc = $this->subcuenta->get($part->idsubcuenta);
                if ($subc) {
                    $part->desc_subcuenta = $subc->descripcion;
                    $part->saldo = $subc->saldo;
                } else {
                    $part->desc_subcuenta = '';
                    $part->saldo = 0;
                }

                $this->lineas[] = $part;
            }

            $this->new_advice('Copiando asiento ' . $copia->numero . '. Pulsa <b>guardar</b> para terminar.');
        } else {
            $this->new_error_msg('Asiento no encontrado.');
        }
    }

    private function new_search()
    {
        /// cambiamos la plantilla HTML
        $this->template = 'ajax/contabilidad_nuevo_asiento';

        $eje0 = $this->ejercicio->get_by_fecha(filter_input(INPUT_POST, 'fecha'));
        if ($eje0) {
            $this->resultados = $this->subcuenta->search_by_ejercicio($eje0->codejercicio, $this->query);
        } else {
            $this->resultados = array();
            $this->new_error_msg('Ningún ejercicio encontrado para la fecha ' . filter_input(INPUT_POST, 'fecha'));
        }
    }

    private function check_datos_contables()
    {
        $eje = $this->ejercicio->get_by_fecha($this->today());
        if ($eje) {
            $ok = false;
            foreach ($this->subcuenta->all_from_ejercicio($eje->codejercicio, true, 5) as $subc) {
                $ok = true;
                break;
            }

            if (!$ok) {
                $this->new_error_msg('No se encuentran subcuentas para el ejercicio ' . $eje->nombre
                        . ' ¿<a href="' . $eje->url() . '">Has importado los datos de contabilidad</a>?');
            }
        } else {
            $this->new_error_msg('No se encuentra ningún ejercicio abierto para la fecha ' . $this->today());
        }
    }

    private function crea_subcuentas($ejercicio, $cuenta, $codigo_cuenta, $descripcion)
    {

        //$this->new_message('Ejercicio: ' . $ejercicio . ' Cuenta: ' . $cuenta . ' Cod. Cuenta: ' . $codigo_cuenta . ' descripcion: ' . $descripcion);

        $subc0 = $this->subcuenta->get_by_codigo((string) $codigo_cuenta, $ejercicio);
        if (!$subc0) {
            $datoscuenta = $this->cuenta->get_by_codigo($cuenta, $ejercicio);

            $subc0 = new subcuenta();

            $subc0->codcuenta = $cuenta;
            $subc0->codejercicio = $ejercicio;
            $subc0->codsubcuenta = $codigo_cuenta;
            $subc0->descripcion = $descripcion;
            $subc0->idcuenta = $datoscuenta->idcuenta;

            if (!$subc0->save()) {
                $this->new_error_msg('Error al crear la subcuenta ' . $codigo_cuenta);
            } else {
                $this->new_message('Creada subcuenta ' . $codigo_cuenta . ' - ' . $descripcion . ' correctamente');
            }
        }
    }

    private function crea_partida($idasiento, $coddivisa, $tasaconv, $concepto, $idsubcuenta, $codsubcuenta, $importe, $tipo)
    {
        $partida = new partida();
        $partida->idasiento = $idasiento;
        $partida->coddivisa = $coddivisa;
        $partida->tasaconv = $tasaconv;
        $partida->concepto = $concepto;
        $partida->idsubcuenta = $idsubcuenta;
        $partida->codsubcuenta = $codsubcuenta;
        if ($tipo == 'D') {
            $partida->debe = $importe;
        } else {
            $partida->haber = $importe;
        }

        $partida->save();
    }

    public function getAllProveedor()
    {
        /// leemos la lista de la caché
        $provelist = $this->cache->get_array('m_proveedor_all');
        if (!$provelist) {
            /// si no la encontramos en la caché, leemos de la base de datos
            $sql = "SELECT * FROM proveedores ORDER BY lower(nombre) ASC";

            $data = $this->db->select($sql);
            if ($data) {
                foreach ($data as $d) {
                    $provelist[] = new \proveedor($d);
                }
            }

            /// guardamos la lista en la caché
            $this->cache->set('m_proveedor_all', $provelist);
        }


        return $provelist;
    }

    public function getAllAcreedor()
    {
        $provelist = $this->cache->get_array('m_acreedor_all');
        if (!$provelist) {
            /// si no la encontramos en la caché, leemos de la base de datos
            $sql = "SELECT * FROM proveedores WHERE acreedor ORDER BY lower(nombre) ASC";

            $data = $this->db->select($sql);
            if ($data) {
                foreach ($data as $d) {
                    $provelist[] = new \proveedor($d);
                }
            }

            /// guardamos la lista en la caché
            $this->cache->set('m_acreedor_all', $provelist);
        }

        return $provelist;
    }

    private function compruebaInput()
    {
        $this->continuar = true;

        $this->eje0 = $this->get_ejercicio(filter_input(INPUT_POST, 'fecha'));
        if (!$this->eje0) {
            $this->continuar = false;
        }

        $this->div0 = $this->divisa->get(filter_input(INPUT_POST, 'divisa'));
        if (!$this->div0) {
            $this->new_error_msg('Divisa no encontrada.');
            $this->continuar = false;
        }

        if ($this->duplicated_petition(filter_input(INPUT_POST, 'petition_id'))) {
            $this->new_error_msg('Petición duplicada. Has hecho doble clic sobre el botón Guardar
               y se han enviado dos peticiones. Mira en <a href="' . $this->ppage->url() . '">asientos</a>
               para ver si el asiento se ha guardado correctamente.');
            $this->continuar = false;
        }
    }
}
