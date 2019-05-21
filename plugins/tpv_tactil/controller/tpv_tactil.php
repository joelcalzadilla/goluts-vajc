<?php
/**
 * @author Carlos García Gómez      neorazorx@gmail.com
 * @copyright 2015-2017, Carlos García Gómez. All Rights Reserved. 
 * @copyright 2015-2017, Jorge Casal Lopez. All Rights Reserved.
 */
require_once 'plugins/facturacion_base/extras/fbase_controller.php';
require_once 'extras/phpmailer/class.phpmailer.php';
require_once 'extras/phpmailer/class.smtp.php';

class tpv_tactil extends fbase_controller
{

    public $agente;
    public $referencia;
    public $listaalmacenes;
    public $listafamilias;
    public $listaimpuestos;
    public $almacen;
    public $arqueo;
    public $articulo;
    public $articulos_grid;
    public $busqueda;
    public $cliente;
    public $cliente_s;
    public $comanda;
    public $fabricante;
    public $forma_pago;
    public $historial;
    public $impuesto;
    public $movimiento;
    public $numlineas;
    public $resultado;
    public $serie;
    public $stock;
    public $terminal;
    public $tesoreria;
    public $tpv_config;
    public $ultidfactura;
    public $utlcambio;
    public $ultentregado;
    public $ultventa;

    public function __construct()
    {
        parent::__construct('tpv_tactil', 'TPV Táctil', 'TPV');
    }

    protected function private_core()
    {
        parent::private_core();
        $this->share_extensions();

        $this->agente = $this->user->get_agente();
        $this->almacen = new almacen();
        $this->arqueo = FALSE;
        $this->busqueda = '';
        $this->cliente = new cliente();
        $this->cliente_s = FALSE;
        $this->comanda = FALSE;
        $this->fabricante = new fabricante();
        $this->forma_pago = new forma_pago();
        $this->historial = array();
        $this->impuesto = new impuesto();
        $this->movimiento = FALSE;
        $this->numlineas = 0;
        $this->resultado = array();
        $this->serie = new serie();
        $this->terminal = FALSE;
        $this->tesoreria = class_exists('recibo_cliente');
        $this->ultidfactura = '';
        $this->utlcambio = 0;
        $this->ultentregado = 0;
        $this->ultventa = 0;

        $this->load_config();

        if (isset($_REQUEST['buscar_cliente'])) {
            $this->fbase_buscar_cliente($_REQUEST['buscar_cliente']);
        } else if (isset($_REQUEST['codbar2'])) {
            $this->buscar_articulo();
        } else if ($this->query != '') {
            $this->new_search();
        } else if (isset($_REQUEST['codfamilia'])) {
            $this->get_articulos_familia();
        } else if (isset($_POST['referencia4combi'])) {
            $this->get_combinaciones_articulo();
        } else if (isset($_REQUEST['get_factura'])) {
            $this->get_factura();
        } else if (isset($_REQUEST['add_ref'])) {
            $this->add_ref();
        } else if (isset($_REQUEST['add_ref_marcaje'])) {
            $this->add_ref_marcaje();
        } else if (isset($_REQUEST['remove_ref_marcaje'])) {
            $this->remove_ref_marcaje();
        } else if (isset($_REQUEST['cargar_datos_modal_articulo'])) {
            $this->cargar_datos_modal_articulo();
        } else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "set_articulo_modificado") {
            $this->set_art_modificado();
        } else if (isset($_REQUEST['mover_ref_izquierda'])) {
            $this->mover_ref_izquierda();
        } else if (isset($_REQUEST['mover_ref_derecha'])) {
            $this->mover_ref_derecha();
        } else if (isset($_REQUEST['cod_buscar'])) {
           $busqueda_enc= $_REQUEST['cod_buscar'];
            $this->codbar_lista();
        } else if (isset($_REQUEST['add_art_ref_marcaje'])) {
            $this->add_art_ref_marcaje();
        } else if (isset($_REQUEST['substract_art_ref_marcaje'])) {
            $this->substract_art_ref_marcaje();
        } else if (isset($_REQUEST['clean_marcaje'])) {
            $this->clean_marcaje();
        } else if (isset($_REQUEST['close_marcaje'])) {
            $this->close_marcaje();
        }else if (isset($_REQUEST['finish_marcaje'])) {
            $this->finish_marcaje();
        } else if (isset($_REQUEST['extractos_modal'])) {
            $this->extractos_modal();
        } else if (isset($_REQUEST['ventas_modal'])) {
            $this->ventas_modal();
        } else if ($this->agente) {
            $arqueo = new tpv_arqueo();
            $terminal0 = new terminal_caja();
            foreach ($arqueo->all_by_agente($this->agente->codagente) as $aq) {
                if ($aq->abierta) {
                    $this->arqueo = $aq;
                    $this->terminal = $terminal0->get($aq->idterminal);
                    break;
                }
            }

            if (!$this->arqueo) {
                if (isset($_POST['terminal'])) {
                    $this->terminal = $terminal0->get($_POST['terminal']);
                    if (!$this->terminal) {
                        $this->new_error_msg('Terminal no encontrado.');
                    } else if ($this->terminal->disponible()) {
                        $this->arqueo = new tpv_arqueo();
                        $this->arqueo->idterminal = $this->terminal->id;
                        $this->arqueo->codagente = $this->agente->codagente;
                        $this->arqueo->inicio = floatval($_POST['d_inicial']);
                        $this->arqueo->totalcaja = floatval($_POST['d_inicial']);

                        if ($this->arqueo->save()) {
                            $this->new_message("Arqueo iniciado con " . $this->show_precio($this->arqueo->inicio));
                        } else {
                            $this->new_error_msg("¡Imposible guardar los datos del arqueo!");
                        }
                    } else {
                        $this->new_error_msg('El terminal ya no está disponible.');
                    }
                } else if (isset($_GET['terminal'])) {
                    $this->terminal = $terminal0->get($_GET['terminal']);
                    if ($this->terminal) {
                        $this->terminal->abrir_cajon();
                        $this->terminal->save();
                    } else {
                        $this->new_error_msg('Terminal no encontrado.');
                    }
                }
            }

            if ($this->arqueo) {
                if (isset($_POST['cliente'])) {
                    $this->cliente_s = $this->cliente->get($_POST['cliente']);
                } else if ($this->terminal) {
                    $this->cliente_s = $this->cliente->get($this->terminal->codcliente);
                }

                if (!$this->cliente_s) {
                    foreach ($this->cliente->all() as $cli) {
                        $this->cliente_s = $cli;
                        break;
                    }
                }

                if ($this->cliente_s) {
                    $this->caja_iniciada();
                } else {
                    $this->new_error_msg('No hay ningún cliente. Crea uno, por ejemplo <b>Contado</b>.');
                }
            } else {
                $this->results = $terminal0->disponibles();
            }
        } else {
            echo  "<script type='text/javascript'>";
            echo "window.close();";
            echo "</script>";
            $this->new_error_msg('No tienes un <a href="' . $this->user->url() . '">agente asociado</a>
            a tu usuario, y por tanto no puedes hacer tickets.');
        }
    }

    private function load_config()
    {
        $fsvar = new fs_var();
        $this->tpv_config = array(
            'tpv_ref_varios' => '',
            'tpv_linea_libre' => 1,
            'tpv_familias' => FALSE,
            'tpv_volver_familias' => FALSE,
            'tpv_fpago_efectivo' => FALSE,
            'tpv_fpago_tarjeta' => FALSE,
            'tpv_texto_fin' => '',
            'tpv_preimprimir' => FALSE,
            'tpv_emails_z' => '',
        );
        $this->tpv_config = $fsvar->array_get($this->tpv_config, FALSE);

        $this->articulos_grid = '3x3';
        if (isset($_COOKIE['tpv_tactil_articulos_grid'])) {
            $this->articulos_grid = $_COOKIE['tpv_tactil_articulos_grid'];
        }
    }

    private function caja_iniciada()
    {
        $this->template = 'tpv_tactil2';
        $tpvcom = new tpv_comanda();

        if (isset($_POST['idtpv_comanda'])) {
            /**
             * El ticket estaba aparcado y ahora lo cargamos para finalizar
             */
            $this->comanda = $tpvcom->get($_POST['idtpv_comanda']);
            if ($this->comanda) {
                $this->cliente_s = $this->cliente->get($this->comanda->codcliente);
                $this->ultentregado = $this->comanda->ultentregado;
            }
        }

        if (isset($_REQUEST['delete_comanda'])) {
            $comanda = $tpvcom->get($_REQUEST['delete_comanda']);
            if ($comanda && $comanda->delete()) {
                $this->new_message('Ticket eliminado correctamente.');
            }

            if ($this->terminal->forzar_pin) {
                $this->template = 'tpv_tactil_pin';
            }
        } else if (isset($_GET['idtpv_comanda'])) {
            /// des-aparcamos un ticket
            $this->comanda = $tpvcom->get($_GET['idtpv_comanda']);
            if ($this->comanda) {
                $this->cliente_s = $this->cliente->get($this->comanda->codcliente);
                $this->ultentregado = $this->comanda->ultentregado;
            }
        } else if (isset($_GET['articulos_grid'])) {
            $this->articulos_grid = $_GET['articulos_grid'];
            setcookie('tpv_tactil_articulos_grid', $this->articulos_grid, time() + FS_COOKIES_EXPIRE);
        } else if (isset($_GET['abrir_caja'])) {
            $this->abrir_caja();
        } else if (isset($_REQUEST['abrir_solo_caja'])) {
            $this->abrir_solo_caja();
        } else if (isset($_GET['cerrando'])) {
            $this->template = 'tpv_tactil_cierre';
            $this->terminal->abrir_cajon();
            $this->terminal->save();
        } else if (isset($_POST['cerrar_caja'])) {
            $this->cerrar_caja();
        } else if (isset($_REQUEST['imprimir_extracto'])) {
            $arqueo = new tpv_arqueo();
            $terminal0 = new terminal_caja();
            foreach ($arqueo->all_by_agente($this->agente->codagente) as $aq) {
                if ($aq->abierta) {
                    $this->arqueo = $aq;
                    $this->terminal = $terminal0->get($aq->idterminal);
                    break;
                }
            }
            $this->imprimir_extracto();
        } else if (isset($_REQUEST['imprimir_ventas_familia'])) {
            $arqueo = new tpv_arqueo();
            $terminal0 = new terminal_caja();
            foreach ($arqueo->all_by_agente($this->agente->codagente) as $aq) {
                if ($aq->abierta) {
                    $this->arqueo = $aq;
                    $this->terminal = $terminal0->get($aq->idterminal);
                    break;
                }
            }
            $this->imprimir_ventas_familia();
        } else if (isset($_POST['idfactura'])) {
            /// modificar una factura
            $this->modificar_factura();
        } else if (isset($_POST['cliente'])) {
            if ($this->comanda) {
                $this->comanda->delete();
                $this->comanda = FALSE;
            }

            $this->guardar_ticket();

            if ($this->terminal->forzar_pin) {
                $this->template = 'tpv_tactil_pin';
            }
        } else if (isset($_GET['imprimir'])) {
            $fact0 = new factura_cliente();
            $factura = $fact0->get($_GET['imprimir']);
            if ($factura) {
                $this->imprimir_ticket($factura);
            }
        } else if (isset($_REQUEST['cambio_agente'])) {
            $this->cambiar_agente($_REQUEST['cambio_agente']);
        } else if (isset($_REQUEST['rfid_agente'])) {
            $this->cambiar_agente_rfid($_REQUEST['rfid_agente']);
        } else if ($this->terminal->forzar_pin) {
            $this->template = 'tpv_tactil_pin';
        } else if (isset($_GET['cierre_x'])) {
            $this->cierre_x();
        } else if (isset($_GET['imprimir_extracto'])) {
            $this->imprimir_extracto();
        }

        $comanda = new tpv_comanda();
        $this->historial = $comanda->all_from_arqueo($this->arqueo->idtpv_arqueo, date('Y-m-d'), 100);
        foreach ($this->historial as $h) {
            $this->ultidfactura = $h->idfactura;
            $this->utlcambio = $h->ultcambio;
            $this->ultentregado = $h->ultentregado;
            $this->ultventa = $h->total;
            break;
        }
    }

    private function cambiar_agente()
    {
        $agente = $this->agente->get($_REQUEST['cambio_agente']);
        if ($agente) {
            if ($this->agente_en_otro_terminal($agente->codagente)) {
                $this->new_error_msg('Empleado ya asignado a otro terminal abierto.');
            } else if ($agente->pin) {
                if (isset($_REQUEST['pin'])) {
                    if ($agente->pin == $_REQUEST['pin']) {
                        $this->agente = $agente;
                        $this->user->codagente = $this->agente->codagente;
                        $this->user->save();

                        $this->arqueo->codagente = $this->agente->codagente;
                        $this->arqueo->agente = $this->agente;
                        $this->arqueo->save();
                    } else {
                        $this->new_error_msg('PIN incorrecto.');
                        $this->template = 'tpv_tactil_pin';
                    }
                }
            } else {
                $this->agente = $agente;
                $this->user->codagente = $this->agente->codagente;
                $this->user->save();

                $this->arqueo->codagente = $this->agente->codagente;
                $this->arqueo->agente = $this->agente;
                $this->arqueo->save();
            }
        } else {
            $this->new_error_msg('Empleado no encontrado.');
            $this->template = 'tpv_tactil_pin';
        }
    }

    private function cambiar_agente_rfid()
    {
        $agente = $this->agente->get_by_rfid($_REQUEST['rfid_agente']);
        if ($agente) {
            if ($this->agente_en_otro_terminal($agente->codagente)) {
                $this->new_error_msg('Empleado ya asignado a otro terminal abierto.');
            } else {
                $this->agente = $agente;
                $this->user->codagente = $this->agente->codagente;
                $this->user->save();

                $this->arqueo->codagente = $this->agente->codagente;
                $this->arqueo->agente = $this->agente;
                $this->arqueo->save();
            }
        } else {
            $this->new_error_msg('Empleado no encontrado.');
            $this->template = 'tpv_tactil_pin';
        }
    }

    private function agente_en_otro_terminal($codagente)
    {
        $encontrado = false;
        foreach ($this->arqueo->all_by_agente($codagente) as $arq) {
            if ($arq->abierta) {
                $encontrado = TRUE;
                break;
            }
        }

        return $encontrado;
    }

    private function abrir_caja()
    {
        if (isset($_POST['cantidad'])) {
            $mov = new tpv_movimiento();
            $mov->idtpv_arqueo = $this->arqueo->idtpv_arqueo;
            $mov->codagente = $this->user->codagente;
            $mov->descripcion = $_POST['descripcion'];

            if ($_POST['movimiento'] == 'entrada') {
                $mov->cantidad = floatval($_POST['cantidad']);
            } else {
                $mov->cantidad = 0 - floatval($_POST['cantidad']);
            }

            if ($mov->save()) {
                $this->new_message('Movimiento guardado correctamente.');
                $this->arqueo->totalmov += $mov->cantidad;
                $this->arqueo->totalcaja += $mov->cantidad;
                $this->arqueo->save();
            } else {
                $this->new_error_msg('Error al guardar el movimiento de caja.');
            }
        } else {
            $this->movimiento = new tpv_movimiento();
            $this->terminal->abrir_cajon();
        }

        $this->terminal->save();
    }

    private function abrir_solo_caja()
    {
        $this->terminal->abrir_cajon();
        $this->terminal->save();
        $ch = curl_init("http://localhost:10080?terminal={$this->terminal->id}");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

    private function cierre_x()
    {
        $this->imprimir_cierre('CIERRE X');
        $this->new_message('Imprimiendo cierre X...');
    }

    private function cerrar_caja()
    {
        $this->arqueo->abierta = FALSE;
        $this->arqueo->diahasta = Date('d-m-Y');

        if (isset($_POST['m001'])) {
            $this->arqueo->m001 = floatval($_POST['m001']);
        }

        if (isset($_POST['m002'])) {
            $this->arqueo->m002 = floatval($_POST['m002']);
        }

        if (isset($_POST['m005'])) {
            $this->arqueo->m005 = floatval($_POST['m005']);
        }

        if (isset($_POST['m010'])) {
            $this->arqueo->m010 = floatval($_POST['m010']);
        }

        if (isset($_POST['m020'])) {
            $this->arqueo->m020 = floatval($_POST['m020']);
        }

        if (isset($_POST['m050'])) {
            $this->arqueo->m050 = floatval($_POST['m050']);
        }

        if (isset($_POST['m1'])) {
            $this->arqueo->m1 = floatval($_POST['m1']);
        }

        if (isset($_POST['m2'])) {
            $this->arqueo->m2 = floatval($_POST['m2']);
        }

        if (isset($_POST['m50'])) {
            $this->arqueo->m50 = floatval($_POST['m50']);
        }

        if (isset($_POST['m100'])) {
            $this->arqueo->m100 = floatval($_POST['m100']);
        }

        if (isset($_POST['m200'])) {
            $this->arqueo->m200 = floatval($_POST['m200']);
        }

        if (isset($_POST['m500'])) {
            $this->arqueo->m500 = floatval($_POST['m500']);
        }

        if (isset($_POST['m1000'])) {
            $this->arqueo->m1000 = floatval($_POST['m1000']);
        }

        if (isset($_POST['b5'])) {
            $this->arqueo->b5 = floatval($_POST['b5']);
        }

        if (isset($_POST['b10'])) {
            $this->arqueo->b10 = floatval($_POST['b10']);
        }

        if (isset($_POST['b20'])) {
            $this->arqueo->b20 = floatval($_POST['b20']);
        }

        if (isset($_POST['b50'])) {
            $this->arqueo->b50 = floatval($_POST['b50']);
        }

        if (isset($_POST['b100'])) {
            $this->arqueo->b100 = floatval($_POST['b100']);
        }

        if (isset($_POST['b200'])) {
            $this->arqueo->b200 = floatval($_POST['b200']);
        }

        if (isset($_POST['b500'])) {
            $this->arqueo->b500 = floatval($_POST['b500']);
        }

        if (isset($_POST['b1000'])) {
            $this->arqueo->b1000 = floatval($_POST['b1000']);
        }

        if (isset($_POST['b2000'])) {
            $this->arqueo->b2000 = floatval($_POST['b2000']);
        }

        if (isset($_POST['b5000'])) {
            $this->arqueo->b5000 = floatval($_POST['b5000']);
        }

        if (isset($_POST['b10000'])) {
            $this->arqueo->b10000 = floatval($_POST['b10000']);
        }

        if (isset($_POST['b20000'])) {
            $this->arqueo->b20000 = floatval($_POST['b20000']);
        }

        if (isset($_POST['b50000'])) {
            $this->arqueo->b50000 = floatval($_POST['b50000']);
        }

        if (isset($_POST['b100000'])) {
            $this->arqueo->b100000 = floatval($_POST['b100000']);
        }

        if ($this->arqueo->save()) {
            $this->imprimir_cierre();

            /// ¿Enviamos el cierre por email?
            if ($this->empresa->can_send_mail() && $this->tpv_config['tpv_emails_z']) {
                $this->enviar_email_cierre($this->tpv_config['tpv_emails_z'], $this->terminal->tickets);
            }

            /// recargamos la página
            header('location: ' . $this->url() . '&terminal=' . $this->terminal->id);
        } else {
            $this->new_error_msg("¡Imposible cerrar la caja!");
        }
    }

    private function imprimir_cierre($titulo = 'ZETA / CIERRE DE CAJA')
    {
        $this->terminal->abrir_cajon();
        $this->terminal->add_linea("\n== " . $titulo . " ==\n");
        $this->terminal->add_linea($this->empresa->nombrecorto . ' ' . $this->terminal->nombre . "\n");
        $this->terminal->add_linea("Cierre de caja: " . $this->arqueo->idtpv_arqueo . "\n");
        $this->terminal->add_linea("Realizado: " . $this->today() . ' ' . $this->hour() . "\n");
        $this->terminal->add_linea("Cajero/a: " . $this->agente->get_fullname() . "\n");

        $this->terminal->add_linea("\n== DINERO EN CAJA ==\n");
        $this->terminal->add_linea("Apertura: " . $this->arqueo->diadesde . "\n");
        $this->terminal->add_linea("Inicial: " . $this->show_precio($this->arqueo->inicio, FALSE, FALSE) . "\n");
        $this->terminal->add_linea("Ventas en efectivo: " . $this->show_precio($this->arqueo->totalcaja - $this->arqueo->inicio, FALSE, FALSE) . "\n");
        $this->terminal->add_linea("------------------------\n");
        $this->terminal->add_linea("Efectivo en caja: " . $this->show_precio($this->arqueo->totalcaja, FALSE, FALSE) . "\n");

        $this->terminal->add_linea("\n== VENTAS ==\n");
        $this->terminal->add_linea("Operaciones: " . $this->arqueo->num_tickets() . "\n");
        $this->terminal->add_linea("Articulos: " . $this->arqueo->num_articulos() . "\n");
        $this->terminal->add_linea("Unidades: " . $this->arqueo->count_articulos() . "\n");
        $this->terminal->add_linea("Pagos en efectivo: " . $this->show_precio($this->arqueo->totalcaja - $this->arqueo->inicio, FALSE, FALSE) . "\n");
        $this->terminal->add_linea("Pagos con tarjeta: " . $this->show_precio($this->arqueo->totaltarjeta, FALSE, FALSE) . "\n");
        $this->terminal->add_linea("------------------------\n");
        $this->terminal->add_linea(
            "Total ventas: " .
            $this->show_precio($this->arqueo->totalcaja - $this->arqueo->inicio + $this->arqueo->totaltarjeta, FALSE, FALSE) . "\n"
        );

        $this->terminal->add_linea("\n== ARQUEO DE CAJA ==\n");
        $this->terminal->add_linea("Efectivo en caja teorico: " . $this->show_precio($this->arqueo->totalcaja, FALSE, FALSE) . "\n");
        $this->terminal->add_linea("Efectivo contado: " . $this->show_precio($this->arqueo->total_contado(), FALSE, FALSE) . "\n");

        $diferencia = $this->arqueo->total_contado() - $this->arqueo->totalcaja;
        $this->terminal->add_linea("Diferencia: " . $this->show_precio($diferencia, FALSE, FALSE) . "\n");

        $this->terminal->add_linea("\n== VENTAS POR FAMILIA ==\n");
        foreach ($this->arqueo->desglose_familias() as $key => $fam) {
            $this->terminal->add_linea($fam['nombre'] . ' ' . $this->show_numero($fam['cantidad']) . "\n");
        }

        $this->terminal->add_linea("\n\n\n\n\n\n");
        $this->terminal->cortar_papel();
        $this->terminal->save();
    }

    private function enviar_email_cierre($emails, $txt)
    {
        $email_list = explode(',', $emails);
        foreach ($email_list as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail = $this->empresa->new_mail();
                $mail->FromName = $this->user->get_agente_fullname();

                $mail->addAddress($email);
                $mail->Subject = $this->empresa->nombre . ': Cierre de arqueo #' . $this->arqueo->idtpv_arqueo;
                $mail->msgHTML( nl2br($txt) );

                if ($this->empresa->mail_connect($mail) && $mail->send()) {
                    $this->new_message('Mensaje enviado correctamente.');
                    $this->empresa->save_mail($mail);
                } else {
                    $this->new_error_msg("Error al enviar el email: " . $mail->ErrorInfo);
                }
            }
        }
    }

    private function buscar_articulo()
    {
        $this->resultado = array();
        $articulo = new articulo();
        $artcod = new articulo_codbarras();
        foreach ($artcod->search($_REQUEST['codbar2']) as $ac) {
            $this->resultado[] = $articulo->get($ac->referencia);
            break;
        }

        if (empty($this->resultado)) {
            /// buscamos por código de barras de la combinación
            $combi0 = new articulo_combinacion();
            foreach ($combi0->search($this->query) as $combi) {
                $art = $articulo->get($combi->referencia);
                if ($art) {
                    $art->codbarras = $combi->codbarras;
                    $this->resultado[] = $art;
                }
            }

            foreach ($articulo->search_by_codbar($_REQUEST['codbar2']) as $ac) {
                $this->resultado[] = $articulo->get($ac->referencia);
                break;
            }
        }

        $this->precios_resultados($this->resultado);

        $this->numlineas = 0;
        if (isset($_POST['numlineas'])) {
            $this->numlineas = $_POST['numlineas'];
        }

        if ($this->resultado) {
            if ($this->resultado[0]->tipo) {
                $this->template = FALSE;
                echo "get_combinaciones('" . $this->resultado[0]->referencia . "')";
            } else {
                $this->template = 'ajax/tpv_tactil_lineas';
            }
        } else {
            $this->template = FALSE;
            echo '<!--no_encontrado-->';
        }
    }

    private function precios_resultados(&$res)
    {
        if ($this->agente) {
            $arqueo = new tpv_arqueo();
            $terminal0 = new terminal_caja();
            foreach ($arqueo->all_by_agente($this->agente->codagente) as $aq) {
                if ($aq->abierta) {
                    $this->arqueo = $aq;
                    $this->terminal = $terminal0->get($aq->idterminal);
                    break;
                }
            }
        }

        if ($this->terminal) {
            $serie = $this->serie->get($this->terminal->codserie);
            $stock = new stock();
        }

        foreach ($res as $i => $value) {
            $res[$i]->query = $this->query;
            $res[$i]->dtopor = 0;
            $res[$i]->cantidad = isset($value->cantidad) ? $value->cantidad : 1;

            $res[$i]->stockalm = $value->stockfis;
            if ($this->terminal) {
                if ($this->multi_almacen) {
                    $res[$i]->stockalm = $stock->total_from_articulo($value->referencia, $this->terminal->codalmacen);
                }

                if ($serie->siniva) {
                    $res[$i]->codimpuesto = NULL;
                }
            }
        }

        if (isset($_REQUEST['codcliente'])) {
            $cliente = $this->cliente->get($_REQUEST['codcliente']);
            $tarifa0 = new tarifa();

            if ($cliente) {
                if ($cliente->regimeniva == 'Exento') {
                    foreach ($res as $i => $value) {
                        $res[$i]->codimpuesto = NULL;
                    }
                }

                if ($cliente->codtarifa) {
                    $tarifa = $tarifa0->get($cliente->codtarifa);
                    if ($tarifa) {
                        $tarifa->set_precios($res);
                    }
                } else if ($cliente->codgrupo) {
                    $grupo0 = new grupo_clientes();

                    $grupo = $grupo0->get($cliente->codgrupo);
                    if ($grupo) {
                        $tarifa = $tarifa0->get($grupo->codtarifa);
                        if ($tarifa) {
                            $tarifa->set_precios($res);
                        }
                    }
                }

                /// aplicamos el descuento al precio
                foreach ($res as $i => $value) {
                    if ($value->dtopor != 0) {
                        $res[$i]->pvp -= $value->pvp * $value->dtopor / 100;
                    }
                }
            }
        }
    }

    private function get_articulos_familia()
    {
        $this->template = 'ajax/tpv_tactil_codfamilia';

        $familia = new familia();
        $fam = $familia->get($_REQUEST['codfamilia']);
        if ($fam) {
            foreach ($fam->get_articulos(0, 150) as $art) {
                if (!$art->bloqueado) {
                    $this->resultado[] = $art;
                }
            }
            $this->precios_resultados($this->resultado);
        }
    }

    private function get_combinaciones_articulo()
    {
        /// cambiamos la plantilla HTML
        $this->template = 'ajax/tpv_tactil_combinaciones';

        $this->results = array();

        /// obtenemos el artículo
        $art0 = new articulo();
        $articulo = $art0->get($_POST['referencia4combi']);
        if ($articulo) {
            /// usamos precios_resultados para obtener el precio de tarifa
            $aux = array($articulo);
            $this->precios_resultados($aux);

            $comb1 = new articulo_combinacion();
            foreach ($comb1->all_from_ref($_POST['referencia4combi']) as $com) {
                if (isset($this->results[$com->codigo])) {
                    $this->results[$com->codigo]['desc'] .= ', ' . $com->nombreatributo . ' - ' . $com->valor;
                    $this->results[$com->codigo]['txt'] .= ', ' . $com->nombreatributo . ' - ' . $com->valor;
                } else {
                    $this->results[$com->codigo] = array(
                        'ref' => $_POST['referencia4combi'],
                        'desc' => $aux[0]->descripcion . " | " . $com->nombreatributo . ' - ' . $com->valor,
                        'pvp' => floatval($aux[0]->pvp) + $com->impactoprecio,
                        'dto' => floatval($aux[0]->dtopor),
                        'codimpuesto' => $aux[0]->codimpuesto,
                        'iva' => $aux[0]->get_iva(),
                        'cantidad' => 1,
                        'txt' => $com->nombreatributo . ' - ' . $com->valor,
                        'codigo' => $com->codigo,
                        'stockfis' => $com->stockfis,
                    );
                }
            }
        }
    }

    private function get_factura()
    {
        $this->template = 'ajax/tpv_tactil_factura';
        $fact0 = new factura_cliente();
        $this->resultado = $fact0->get($_REQUEST['get_factura']);
    }

    private function add_ref($ref = null)
    {
        $this->template = 'ajax/tpv_tactil_lineas';
        $this->resultado = array();

        $art0 = new articulo();
        $articulo = $art0->get($ref ?: $_REQUEST['add_ref']);
        if ($articulo) {
            $this->resultado[] = $articulo;
            $this->precios_resultados($this->resultado);

            if (isset($_POST['desc'])) {
                $this->resultado[0]->descripcion = base64_decode($_POST['desc']);
                $this->resultado[0]->pvp = floatval($_POST['pvp']);
                $this->resultado[0]->dtopor = floatval($_POST['dto']);
            }

            if (isset($_POST['codcombinacion'])) {
                $this->resultado[0]->codcombinacion = $_POST['codcombinacion'];
            }

            $this->numlineas = 0;
            if (isset($_POST['numlineas'])) {
                $this->numlineas = $_POST['numlineas'];
            }
        }
    }

    private function add_ref_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = true;

        $sql = "INSERT INTO tpv_articulos_favoritos (referencia,posicion) VALUES('".$_REQUEST['add_ref_marcaje']."', '".$_REQUEST['posicion']."')";
        $this->db->exec($sql);
    }

    private function remove_ref_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = true;

        $sql = "DELETE FROM tpv_articulos_favoritos WHERE referencia = '".$_REQUEST['remove_ref_marcaje']."';";
        $this->db->exec($sql);
    }

    private function mover_ref_izquierda()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = true;
        $sql = "SELECT * FROM tpv_articulos_favoritos WHERE referencia = '".$_REQUEST['mover_ref_izquierda']."';";
        $data = $this->db->select($sql);
        if ($data) {
            $sql = "SELECT posicion FROM tpv_articulos_favoritos WHERE referencia = '".$_REQUEST['mover_ref_izquierda']."';";
            $posicion = $this->db->select($sql)[0]["posicion"];
            $posicion2 = $posicion - 1;
            $sql = "UPDATE tpv_articulos_favoritos SET posicion = '0' WHERE referencia = '".$_REQUEST['mover_ref_izquierda']."';";
            $this->db->exec($sql);
            $data = $this->db->select("SELECT referencia FROM tpv_articulos_favoritos WHERE posicion ='".$posicion2."';");
            if ($data) {
                $sql = "UPDATE tpv_articulos_favoritos SET posicion = '" . $posicion . "' WHERE referencia ='" . $data[0]["referencia"] . "';";
                $this->db->exec($sql);
            }
            $sql = "UPDATE tpv_articulos_favoritos SET posicion = '".$posicion2."' WHERE posicion ='0';";
            $this->db->exec($sql);
        } else {
            $art_vacio_posicion = $_REQUEST['posicion_art'];
            $nueva_pos = $art_vacio_posicion - 1;
            $sql = "SELECT referencia FROM tpv_articulos_favoritos WHERE posicion = '".$nueva_pos."';";
            $data = $this->db->select($sql);
            if ($data) {
                $sql = "UPDATE tpv_articulos_favoritos SET posicion = '".$art_vacio_posicion."' WHERE referencia = '".$data[0]["referencia"]."';";
                $this->db->exec($sql);
            }
        }

    }

    private function mover_ref_derecha()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = true;
        $sql = "SELECT * FROM tpv_articulos_favoritos WHERE referencia = '".$_REQUEST['mover_ref_derecha']."';";
        $data = $this->db->select($sql);
        if ($data) {
            $sql = "SELECT posicion FROM tpv_articulos_favoritos WHERE referencia = '".$_REQUEST['mover_ref_derecha']."';";
            $posicion = $this->db->select($sql)[0]["posicion"];
            $posicion2 = $posicion + 1;
            $sql = "UPDATE tpv_articulos_favoritos SET posicion = '0' WHERE referencia = '".$_REQUEST['mover_ref_derecha']."';";
            $this->db->exec($sql);
            $data = $this->db->select("SELECT referencia FROM tpv_articulos_favoritos WHERE posicion ='".$posicion2."';");
            if ($data) {
                $sql = "UPDATE tpv_articulos_favoritos SET posicion = '" . $posicion . "' WHERE referencia ='" . $data[0]["referencia"] . "';";
                $this->db->exec($sql);
            }
            $sql = "UPDATE tpv_articulos_favoritos SET posicion = '".$posicion2."' WHERE posicion ='0';";
            $this->db->exec($sql);
        } else {
            $art_vacio_posicion = $_REQUEST['posicion_art'];
            $nueva_pos = $art_vacio_posicion + 1;
            $sql = "SELECT referencia FROM tpv_articulos_favoritos WHERE posicion = '".$nueva_pos."';";
            $data = $this->db->select($sql);
            if ($data) {
                $sql = "UPDATE tpv_articulos_favoritos SET posicion = '".$art_vacio_posicion."' WHERE referencia = '".$data[0]["referencia"]."';";
                $this->db->exec($sql);
            }
        }
    }

    private function codbar_lista()
    {
        
        $lista = array();
        if ($_REQUEST['cod_buscar'] != "") {
             
            /*$hora_inicial = new DateTime();
            $hora_inicial = $hora_inicial -> getTimestamp();  */
            
            $hora_inicial = date("Y-m-d H:i:s");
            
            $sql_base = "SELECT codbarras, referencia, descripcion, pvp, codimpuesto, '' AS codfamilia, '' AS codfabricante, '' AS factualizado, '' AS costemedio, '' AS preciocoste, '' AS stockfis, '' AS stockmin, '' AS stockmax, '' AS controlstock, '' AS nostock, '' AS bloqueado, '' AS secompra, '' AS sevende, '' AS equivalencia, '' AS codbarras, '' AS observaciones, '' AS distribuidora, '' AS reservas, '' AS fecha_recepcion, '' AS num_ultimo_recibido, '' AS uds_recibidas_ult_reparto, '' AS stock_vendido_ult_recepcion, '' AS num_anterior, '' AS uds_num_anterior, '' AS num_anterior_del_anterior, '' AS uds_num_anterior_del_anterior, '' AS pvp_anterior, '' AS fcodigo, '' AS notas, '' AS devuelto_descatalogado, '' AS imagen, '' AS publico, '' AS tipo, '' AS partnumber, '' AS codsubcuentacom, '' AS codsubcuentairpfcom, '' AS trazabilidad FROM articulos WHERE ";
            $sql_modifiers = " ORDER BY descripcion ASC LIMIT 100";
            $sql_where = "(codbarras_numerico='" . $_REQUEST['cod_buscar'] . "' OR referencia_numerica='" . $_REQUEST['cod_buscar'] . "' OR codbarras='" . $_REQUEST['cod_buscar'] . "' OR referencia='" . $_REQUEST['cod_buscar'] . "') AND bloqueado = 0";
            $lista = $this->db->select($sql_base . $sql_where . $sql_modifiers);
            if (count($lista)==0) {
                $sql_where = "(codbarras_numerico LIKE '" . $_REQUEST['cod_buscar'] . "%' OR referencia_numerica LIKE '" . $_REQUEST['cod_buscar'] . "%' OR codbarras LIKE '" . $_REQUEST['cod_buscar'] . "%' OR referencia LIKE '" . $_REQUEST['cod_buscar'] . "%' OR descripcion LIKE '" . $_REQUEST['cod_buscar'] . "%') AND bloqueado = 0";
                $lista = $this->db->select($sql_base . $sql_where . $sql_modifiers);
                /*if (count($lista)==0) {
                    $sql_where = "codbarras_numerico LIKE '%" . $_REQUEST['cod_buscar'] . "%' OR referencia_numerica LIKE '%" . $_REQUEST['cod_buscar'] . "%' OR codbarras LIKE '%" . $_REQUEST['cod_buscar'] . "%' OR referencia LIKE '%" . $_REQUEST['cod_buscar'] . "%' OR descripcion LIKE '%" . $_REQUEST['cod_buscar'] . "%'";
                    $lista = $this->db->select($sql_base . $sql_where . $sql_modifiers);
                }*/
            }
        }
        if (count($lista) == 1) {
            if (isset($_REQUEST["direct_view"])) {
                if ($_REQUEST["direct_view"] === 'add_ref') {
                    $this->add_ref($lista[0]["referencia"]);
                } elseif ($_REQUEST["direct_view"] === 'cargar_datos_modal_articulo') {
                   $this->cargar_datos_modal_articulo($lista[0]["referencia"]);
                    /*$this->cargar_datos_modal_articulo($lista[0]["referencia"],$_REQUEST['cod_buscar']);*/
                }
                if ($this->template) {
                    $lista[0]["view"] = $this->compile_template_as_index();
                }
            }
        } elseif(count($lista) > 1){
            foreach ($lista as $key => $item) {
                $articulo = new articulo($item);
                $lista[$key]["precio"] = $articulo ? $articulo->pvp_iva() : "-";
            }
        }
        $sql = "INSERT INTO fs_performance_log (fe_inicio,fe_final,descripcion) VALUES('$hora_inicial',CURRENT_TIME,'codbar_lista()')";
        /*$sql = "INSERT INTO fs_performance_log (fe_inicio,fe_final,descripcion) VALUES(CURRENT_TIME,CURRENT_TIME,'codbar_lista()')";*/
            
        $this->db->exec($sql);
        
        echo json_encode($lista);
        die();
    }

    private function cargar_datos_modal_articulo($ref=NULL) {
        $this->template = 'ajax/tpv_tactil_modificar_articulo';

            $lista=[];
            $this->ref_busc = $_REQUEST['ref_busc'];

         if ($this->ref_busc) {
            $sql_base = "SELECT codbarras, referencia, descripcion, pvp, codimpuesto FROM articulos WHERE ";
            $sql_modifiers = " LIMIT 100";
             $sql_where = "(codbarras_numerico LIKE '" . $_REQUEST['ref_busc'] . "%' OR referencia_numerica LIKE '" .  $_REQUEST['ref_busc'] . "%' OR codbarras LIKE '" .  $_REQUEST['ref_busc'] . "%' OR referencia LIKE '" .  $_REQUEST['ref_busc'] . "%' OR descripcion LIKE '" .  $_REQUEST['ref_busc'] . "%') AND bloqueado = 0";
           /* $sql_where = "descripcion like '%" . $art_buscado . "%'";*/

            $lista = $this->db->select($sql_base . $sql_where . $sql_modifiers);
        }

        $this->listaArticulo=[];

        for ($i = 0; $i < count($lista); $i++) {
            $al = new articulo();
            $al->codbarras = $lista[$i]['codbarras'];
            $al->referencia = $lista[$i]['referencia'];
            $al->descripcion = $lista[$i]['descripcion'];
            $al->pvp = $lista[$i]['pvp'];
            array_push($this->listaArticulo, $al);
        }

        $sql = "SELECT codalmacen, nombre FROM almacenes";
        $almacenes = $this->db->select($sql);
        $this->listaalmacenes = [];
        for ($i = 0; $i < count($almacenes); $i++) {
            $al = new almacen();
            $al->nombre = $almacenes[$i]['nombre'];
            $al->codalmacen = $almacenes[$i]['codalmacen'];
            array_push($this->listaalmacenes, $al);
        }
        $sql = "SELECT codfamilia, descripcion FROM familias order by codfamilia";
        $familias = $this->db->select($sql);
        $this->listafamilias = [];
        for ($i = 0; $i < count($familias); $i++) {
            $fam = new familia();
            $fam->descripcion = $familias[$i]['descripcion'];
            $fam->codfamilia = $familias[$i]['codfamilia'];
            array_push($this->listafamilias, $fam);
        }
        $sql = "SELECT codimpuesto, descripcion FROM impuestos order by iva ASC";
        $impuestos = $this->db->select($sql);
        $this->listaimpuestos = [];
        for ($i = 0; $i < count($impuestos); $i++) {
            $imp = new impuesto();
            $imp->descripcion = $impuestos[$i]['descripcion'];
            $imp->codimpuesto = $impuestos[$i]['codimpuesto'];
            array_push($this->listaimpuestos, $imp);
        }

        $ref = $ref ?: $_REQUEST['cargar_datos_modal_articulo'];
        $this->referencia = $ref;

        if ($ref) {
            $sql = "SELECT * FROM articulos WHERE referencia='" . $ref . "';";
            $art_data = $this->db->select($sql);
            $this->articulo = new articulo($art_data[0]);
            $this->articulo->stock_vendido_ult_recepcion = str_replace(".00", "", (string)number_format ($this->articulo->stock_vendido_ult_recepcion, 2, ".", ""));
            $this->articulo->num_ultimo_recibido = str_replace(".00", "", (string)number_format ($this->articulo->num_ultimo_recibido, 2, ".", ""));
            $this->articulo->uds_recibidas_ult_reparto = str_replace(".00", "", (string)number_format ($this->articulo->uds_recibidas_ult_reparto, 2, ".", ""));
            $this->articulo->num_anterior = str_replace(".00", "", (string)number_format ($this->articulo->num_anterior, 2, ".", ""));
            $this->articulo->uds_num_anterior = str_replace(".00", "", (string)number_format ($this->articulo->uds_num_anterior, 2, ".", ""));
            $this->articulo->num_anterior_del_anterior = str_replace(".00", "", (string)number_format ($this->articulo->num_anterior_del_anterior, 2, ".", ""));
            $this->articulo->uds_num_anterior_del_anterior = str_replace(".00", "", (string)number_format ($this->articulo->uds_num_anterior_del_anterior, 2, ".", ""));
            $sql = "SELECT * FROM fs_goluts.stocks WHERE referencia='" . $ref . "';";
            $stock_data = $this->db->select($sql);
            $this->stock = new stock($stock_data[0]);
            $this->stock->cantidad = str_replace(".00", "", (string)number_format ($this->stock->cantidad, 2, ".", ""));
            if ($this->stock->cantidad == '') {
                $this->stock->cantidad = 0;
            }
        } else {
            $this->articulo = new articulo();
            $this->stock = new stock();
        }
        /*echo json_encode($this->lista);
        die();*/

    }

    private function set_art_modificado()
    {
        if ($_REQUEST['referencia']) {
            $art = new articulo();
            $articulo = $art->get($_REQUEST['referencia']);
            //$articulo->referencia = $_REQUEST['nreferencia'];
            //$articulo->codbarras = $_REQUEST['codbarras'];
        } else {
            $articulo = new articulo();
            $articulo->referencia = $_REQUEST['codbarras'];
            $articulo->codbarras = $_REQUEST['codbarras'];
        }
        $articulo->distribuidora = $_REQUEST['distribuidora'];
        $articulo->codfamilia = $_REQUEST['familia'];
        $articulo->descripcion = $_REQUEST['descripcion'];
        $articulo->reservas = $_REQUEST['reservas'];
        $articulo->fecha_recepcion = $_REQUEST['fecha_recepcion'];
        $articulo->stock_vendido_ult_recepcion = $_REQUEST['stock_vendido_ult_recepcion'];
        $articulo->num_ultimo_recibido = $_REQUEST['num_ultimo_recibido'];
        $articulo->uds_recibidas_ult_reparto = $_REQUEST['uds_recibidas_ult_reparto'];
        $articulo->num_anterior = $_REQUEST['num_anterior'];
        $articulo->uds_num_anterior = $_REQUEST['uds_num_anterior'];
        $articulo->num_anterior_del_anterior = $_REQUEST['num_anterior_del_anterior'];
        $articulo->uds_num_anterior_del_anterior = $_REQUEST['uds_num_anterior_del_anterior'];
        $articulo->devuelto_descatalogado = $_REQUEST['devuelto_descatalogado'];
        $articulo->bloqueado = $_REQUEST['bloqueado'];
        $articulo->set_impuesto($_REQUEST['impuesto']);
        $articulo->set_pvp_iva($_REQUEST['pvp_iva']);
        $articulo->save();
        if (!$_REQUEST['referencia']) {
            $sql_stock = "INSERT INTO stocks (referencia, disponible, stockmin, reservada, horaultreg, nombre, pterecibir, fechaultreg, codalmacen, cantidadultreg, cantidad, stockmax, ubicacion)
VALUES ('{$_REQUEST['codbarras']}', 0, 0, 0, NULL, 'ALMACEN GENERAL', 0, NULL, 'ALG', 0, 0, 0, '');";
            $this->db->exec($sql_stock);
        }
    }

    private function add_art_ref_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = false;

        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        $referencia = $_REQUEST["add_art_ref_marcaje"];
        if($id_comanda_marcaje > 0){
            $sql_check = "SELECT * FROM tpv_lineas_comanda_marcaje WHERE idtpv_comanda = '".$id_comanda_marcaje."' AND referencia = '".$referencia."'";
            $result = $this->db->select($sql_check);
            if($result && is_array($result) && count($result) == 1){
                //Actualizamos línea
                $sql = "UPDATE tpv_lineas_comanda_marcaje SET cantidad = cantidad + 1 WHERE id = '".$result[0]["id"]."'";
                $this->db->exec($sql);
            } else {
                //Insertamos
                $Articulo = new articulo();
                $articulo = $Articulo->get($referencia);
                if($articulo){
                    $sql = "INSERT INTO tpv_lineas_comanda_marcaje (idtpv_comanda,referencia, cantidad, descripcion) VALUES('".$id_comanda_marcaje."', '".$referencia."', 1, '".$articulo->descripcion."')";
                    $this->db->exec($sql);
                }
            }
        }
    }

    private function substract_art_ref_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = false;

        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        $referencia = $_REQUEST["substract_art_ref_marcaje"];
        if($id_comanda_marcaje > 0){
            $sql_check = "SELECT * FROM tpv_lineas_comanda_marcaje WHERE idtpv_comanda = '".$id_comanda_marcaje."' AND referencia = '".$referencia."'";
            $result = $this->db->select($sql_check);
            if($result && is_array($result) && count($result) == 1){
                //Actualizamos línea
                $sql = "UPDATE tpv_lineas_comanda_marcaje SET cantidad = cantidad - 1 WHERE id = '".$result[0]["id"]."'";
                $this->db->exec($sql);
            } else {
                //Insertamos
                $Articulo = new articulo();
                $articulo = $Articulo->get($referencia);
                if($articulo){
                    $sql = "INSERT INTO tpv_lineas_comanda_marcaje (idtpv_comanda,referencia, cantidad, descripcion) VALUES('".$id_comanda_marcaje."', '".$referencia."', -1, '".$articulo->descripcion."')";
                    $this->db->exec($sql);
                }
            }
        }
    }

    private function clean_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = false;
        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        if($id_comanda_marcaje > 0){
            $sql = "DELETE FROM tpv_lineas_comanda_marcaje WHERE idtpv_comanda = '".$id_comanda_marcaje."'";
            $this->db->exec($sql);
        }
    }

    private function close_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_lineas_marcaje';
        $this->resultado = array();
        $this->resultado['lineas'] = array();
        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        if($id_comanda_marcaje > 0){

            $sql = "SELECT tpv_lineas_comanda_marcaje.* FROM tpv_lineas_comanda_marcaje LEFT JOIN tpv_articulos_favoritos ON tpv_lineas_comanda_marcaje.referencia = tpv_articulos_favoritos.referencia WHERE idtpv_comanda = '".$id_comanda_marcaje."' ORDER BY tpv_articulos_favoritos.posicion ASC";
            $lineas_comanda = $this->db->select($sql);
            $this->numlineas = $_REQUEST['numlineas'] + 1 + count($lineas_comanda);
            if($lineas_comanda && is_array($lineas_comanda) && count($lineas_comanda) > 0){
                foreach ($lineas_comanda as $key => $linea_comanda) {
                    $art0 = new articulo();
                    $articulo = $art0->get($linea_comanda['referencia']);
                    if ($articulo) {
                        $this->numlineas--;
                        $articulo->linea = $this->numlineas;
                        $articulo->cantidad = $linea_comanda["cantidad"];
                        $this->resultado['lineas'][$key] = $articulo;
                        $this->precios_resultados($this->resultado["lineas"]);
                    }
                }
            }
        }
    }

    private function finish_marcaje()
    {
        $this->template = 'ajax/tpv_tactil_items_marcaje';
        $this->resultado = array();
        $this->resultado["display_config"] = false;
        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        if($id_comanda_marcaje > 0){
            $fecha = date("Y-m-d H:i:s");
            $sql = "UPDATE tpv_comandas_marcaje SET fecha_fin = '".$fecha."', finalizado = 1 WHERE id = '".$id_comanda_marcaje."'";
            $this->db->exec($sql);
        }
    }

    private function get_comanda_marcaje_activa(){
        $id_comanda_marcaje = 0;
        if($this->agente){
            $sql = "SELECT id FROM tpv_comandas_marcaje WHERE cod_agente = '".$this->agente->codagente."' AND IFNULL(finalizado, 0) = 0";
            $result =$this->db->select($sql);
            if($result && is_array($result) && count($result) == 1 && $result[0]["id"] > 0){
                $id_comanda_marcaje = $result[0]["id"];
            } else {
                //Generamos comanda
                $fecha = date("Y-m-d H:i:s");
                $sql = "INSERT INTO tpv_comandas_marcaje (cod_agente,fecha_inicio,finalizado) VALUES('".$this->agente->codagente."', '".$fecha."', 0)";
                $result =$this->db->exec($sql);
                if($result){
                    $id_comanda_marcaje = $this->db->lastval();
                }
            }
        }
        return $id_comanda_marcaje;
    }

private function preimprimir_ticket(){
    $comanda = new tpv_comanda();
    $comanda->idtpv_arqueo = $this->arqueo->idtpv_arqueo;
    $comanda->fecha = $_POST['fecha'];
    $comanda->codalmacen = $this->terminal->codalmacen;

    $comanda->codpago = $forma_pago->codpago;
    if ($forma_pago2) {
        $comanda->codpago2 = $forma_pago2->codpago;
    }

    if (floatval($_POST['tpv_efectivo']) > 0) {
        $comanda->totalpago = floatval($_POST['tpv_efectivo']);
        if (isset($_POST['tpv_tarjeta']) && floatval($_POST['tpv_tarjeta']) > 0) {
            $comanda->totalpago2 = floatval($_POST['tpv_tarjeta']);
         }
    } else if (isset($_POST['tpv_tarjeta'])) {
        $comanda->totalpago = floatval($_POST['tpv_tarjeta']);
    }

    $comanda->observaciones = $_POST['observaciones'];
    $comanda->numero2 = $_POST['numero2'];
    $comanda->porcomision = $this->agente->porcomision;
    $comanda->ultentregado = floatval($_POST['tpv_efectivo']);
    $comanda->ultcambio = floatval($_POST['tpv_cambio']);
    $comanda->codcliente = $cliente->codcliente;
    $comanda->cifnif = $cliente->cifnif;
    $comanda->nombrecliente = $cliente->razonsocial;
    foreach ($cliente->get_direcciones() as $d) {
        if ($d->domfacturacion) {
            $comanda->ciudad = $d->ciudad;
            $comanda->coddir = $d->id;
            $comanda->codpais = $d->codpais;
            $comanda->codpostal = $d->codpostal;
            $comanda->direccion = $d->direccion;
            $comanda->provincia = $d->provincia;
            break;
        }
    }

    $articulo = new articulo();
    $n = floatval($_POST['numlineas']);

    for ($i = 0; $i < $n; $i++) {
        if (isset($_POST['referencia_' . $i])) {
            $art0 = $articulo->get($_POST['referencia_' . $i]);
            if ($art0) {
                $linea = new linea_comanda();
                $linea->idtpv_comanda = $comanda->idtpv_comanda;
                $linea->referencia = $art0->referencia;
                $linea->descripcion = $_POST['desc_' . $i];
                $linea->codimpuesto = $art0->codimpuesto;
                $linea->iva = floatval($_POST['iva_' . $i]);
                $linea->pvpunitario = floatval($_POST['pvp_' . $i]);
                $linea->cantidad = floatval($_POST['cantidad_' . $i]);
                $linea->dtopor = floatval($_POST['descuen_' . $i]);
                $linea->pvpsindto = $linea->pvpunitario * $linea->cantidad;
                $linea->pvptotal = $linea->pvpunitario * (100 - $linea->dtopor) / 100 * $linea->cantidad;

                if ($_POST['codcombinacion_' . $i]) {
                    $linea->codcombinacion = $_POST['codcombinacion_' . $i];
                }

                $comanda->neto += $linea->pvptotal;
                $comanda->totaliva += ($linea->pvptotal * $linea->iva / 100);
            }
        }
    }

    $comanda->neto = round($comanda->neto, FS_NF0);
    $comanda->totaliva = round($comanda->totaliva, FS_NF0);
    $comanda->total = ($comanda->neto + $comanda->totaliva);
    if ($comanda->totalpago > $comanda->total) {
        $comanda->totalpago = $comanda->total;
    }

    $this->terminal->preimprimir_ticket_tactil($comanda, $this->empresa);
    $this->terminal->save();

}

    private function guardar_ticket()
    {
        $continuar = TRUE;
        $ej0 = new ejercicio();
        $ejercicio = $ej0->get_by_fecha($_POST['fecha']);
        $hora_inicial = date("Y-m-d H:i:s");
        
        if (!$ejercicio) {
            $this->new_error_msg('Ejercicio no encontrado.');
            $continuar = FALSE;
        }

        $serie0 = new serie();
        $serie = $serie0->get($_POST['serie']);
        if (!$serie) {
            $this->new_error_msg('Serie no encontrada.');
            $continuar = FALSE;
        }

        $forma_pago = $this->forma_pago->get($this->tpv_config['tpv_fpago_efectivo']);
        $forma_pago2 = FALSE;
        if (isset($_POST['tpv_tarjeta']) && floatval($_POST['tpv_tarjeta']) > 0) {
            if (floatval($_POST['tpv_efectivo']) > 0) {
                $forma_pago2 = $this->forma_pago->get($this->tpv_config['tpv_fpago_tarjeta']);
            } else {
                $forma_pago = $this->forma_pago->get($this->tpv_config['tpv_fpago_tarjeta']);
            }
        }

        if (!$forma_pago) {
            $this->new_error_msg('Forma de pago no encontrada.');
            $continuar = FALSE;
        }

        $div0 = new divisa();
        $divisa = $div0->get($this->empresa->coddivisa);
        if (!$divisa) {
            $this->new_error_msg('Divisa no encontrada.');
            $continuar = FALSE;
        }

        $cliente = $this->cliente->get($_POST['cliente']);
        if (!$cliente) {
            $this->new_error_msg('Cliente no encontrado.');
            $continuar = FALSE;
        }

        $comanda = new tpv_comanda();

        if ($this->duplicated_petition($_POST['petition_id'])) {
            $this->new_error_msg('Petición duplicada. Has hecho doble clic sobre el botón Guardar
               y se han enviado dos peticiones.');
            $continuar = FALSE;
        }

        if ($continuar) {
            $comanda->idtpv_arqueo = $this->arqueo->idtpv_arqueo;
            $comanda->fecha = $_POST['fecha'];
            $comanda->codalmacen = $this->terminal->codalmacen;

            $comanda->codpago = $forma_pago->codpago;
            if ($forma_pago2) {
                $comanda->codpago2 = $forma_pago2->codpago;
            }

            if (floatval($_POST['tpv_efectivo']) > 0) {
                $comanda->totalpago = floatval($_POST['tpv_efectivo']);
                if (isset($_POST['tpv_tarjeta']) && floatval($_POST['tpv_tarjeta']) > 0) {
                    $comanda->totalpago2 = floatval($_POST['tpv_tarjeta']);
                }
            } else if (isset($_POST['tpv_tarjeta'])) {
                $comanda->totalpago = floatval($_POST['tpv_tarjeta']);
            }

            $comanda->observaciones = $_POST['observaciones'];
            $comanda->numero2 = $_POST['numero2'];
            $comanda->porcomision = $this->agente->porcomision;
            $comanda->ultentregado = floatval($_POST['tpv_efectivo']);
            $comanda->ultcambio = floatval($_POST['tpv_cambio']);
            $comanda->codcliente = $cliente->codcliente;
            $comanda->cifnif = $cliente->cifnif;
            $comanda->nombrecliente = $cliente->razonsocial;
            foreach ($cliente->get_direcciones() as $d) {
                if ($d->domfacturacion) {
                    $comanda->ciudad = $d->ciudad;
                    $comanda->coddir = $d->id;
                    $comanda->codpais = $d->codpais;
                    $comanda->codpostal = $d->codpostal;
                    $comanda->direccion = $d->direccion;
                    $comanda->provincia = $d->provincia;
                    break;
                }
            }

            if (is_null($comanda->codcliente)) {
                $this->new_error_msg("No hay ninguna dirección asociada al cliente.");
            } else if ($comanda->save()) {
                $articulo = new articulo();

                $n = floatval($_POST['numlineas']);

                for ($i = 0; $i < $n; $i++) {
                    if (isset($_POST['referencia_' . $i])) {
                        $art0 = $articulo->get($_POST['referencia_' . $i]);
                        if ($art0) {
                            $linea = new linea_comanda();
                            $linea->idtpv_comanda = $comanda->idtpv_comanda;
                            $linea->referencia = $art0->referencia;
                            $linea->descripcion = $_POST['desc_' . $i];
                            $linea->codimpuesto = $art0->codimpuesto;
                            $linea->iva = floatval($_POST['iva_' . $i]);
                            $linea->pvpunitario = floatval($_POST['pvp_' . $i]);
                            $linea->cantidad = floatval($_POST['cantidad_' . $i]);
                            $linea->dtopor = floatval($_POST['descuen_' . $i]);
                            $linea->pvpsindto = $linea->pvpunitario * $linea->cantidad;
                            $linea->pvptotal = $linea->pvpunitario * (100 - $linea->dtopor) / 100 * $linea->cantidad;

                            if (!empty($_POST['codcombinacion_' . $i])) {
                                $linea->codcombinacion = $_POST['codcombinacion_' . $i];
                            }

                            if ($linea->save()) {
                                /// descontamos del stock
                                $art0->sum_stock($comanda->codalmacen, 0 - $linea->cantidad, FALSE, $linea->codcombinacion);
                                $comanda->neto += $linea->pvptotal;
                                $comanda->totaliva += ($linea->pvptotal * $linea->iva / 100);
                            } else {
                                $this->new_error_msg("¡Imposible guardar la línea con referencia: " . $linea->referencia);
                                $continuar = FALSE;
                            }
                        } else {
                            $this->new_error_msg("Artículo no encontrado: " . $_POST['referencia_' . $i]);
                            $continuar = FALSE;
                        }
                    }
                }

                if ($continuar) {
                    /// redondeamos
                    $comanda->neto = round($comanda->neto, FS_NF0);
                    $comanda->totaliva = round($comanda->totaliva, FS_NF0);
                    $comanda->total = ($comanda->neto + $comanda->totaliva);
                    if ($comanda->totalpago > $comanda->total) {
                        $comanda->totalpago = $comanda->total;
                    }

                    if (abs(floatval($_POST['tpv_total']) - $comanda->total) >= .02) {
                        $this->new_error_msg("El total difiere entre la vista y el controlador (" . $_POST['tpv_total'] .
                            " frente a " . $comanda->total . "). Debes informar del error.");
                        $comanda->delete();
                    } else if ($comanda->save()) {
                        if ($_POST['aparcar'] == 'FALSE') {

                            $this->generar_factura($comanda, $ejercicio, $serie, $divisa, $forma_pago, $cliente);
                        } else if ($_POST['preimprimir'] == 'TRUE') {
                            $this->terminal->preimprimir_ticket_tactil($comanda, $this->empresa);
                            $this->terminal->save();

                            $this->new_message("Ticket aparcado.");
                        } else {
                            $this->new_message("Ticket aparcado.");
                        }
                    } else {
                        $this->new_error_msg("¡Imposible actualizar el ticket!");
                    }
                } else if ($comanda->delete()) {
                    $this->new_message("Ticket eliminado correctamente.");
                } else {
                    $this->new_error_msg("¡Imposible eliminar el ticket!");
                }
            } else {
                $this->new_error_msg("¡Imposible guardar el ticket!");
            }
            $sql = "INSERT INTO fs_performance_log (fe_inicio,fe_final,descripcion) VALUES('$hora_inicial',CURRENT_TIME,'guardar_ticket()')";
        /*$sql = "INSERT INTO fs_performance_log (fe_inicio,fe_final,descripcion) VALUES(CURRENT_TIME,CURRENT_TIME,'codbar_lista()')";*/
            
        $this->db->exec($sql);
        }
    }

    /**
     * Añade el ticket a la cola de impresión.
     * @param factura_cliente $factura
     */
    private function imprimir_ticket($factura, $numtickets = 1, $cajon = FALSE)
    {
        if ($cajon) {
            $this->terminal->abrir_cajon();
        }

        while ($numtickets > 0) {
            $efectivo = NULL;
            if (isset($_POST['tpv_efectivo'])) {
                $efectivo = $_POST['tpv_efectivo'];
            }

            $tarjeta = NULL;
            if (isset($_POST['tpv_tarjeta'])) {
                $tarjeta = $_POST['tpv_tarjeta'];
            }

            $cambio = NULL;
            if (isset($_POST['tpv_cambio'])) {
                $cambio = $_POST['tpv_cambio'];
            }

            if (isset($_REQUEST['imprimir']) || isset($_POST['imprimir_ticket'])) {
                $this->terminal->imprimir_ticket_tactil($factura, $this->empresa, $efectivo, $tarjeta, $cambio, $this->tpv_config['tpv_texto_fin']);
            }

            if (isset($_POST['regalo'])) {
                $this->terminal->imprimir_ticket_tactil_regalo($factura, $this->empresa, $this->tpv_config['tpv_texto_fin']);
            }

            $numtickets--;
        }

        $this->terminal->save();
    }

    /**
     * 
     * @param tpv_comanda $comanda
     * @param ejercicio $ejercicio
     * @param serie $serie
     * @param divisa $divisa
     */
    private function generar_factura(&$comanda, &$ejercicio, &$serie, &$divisa, &$forma_pago, &$cliente)
    {
        $factura = new factura_cliente();
        $factura->cifnif = $comanda->cifnif;
        $factura->ciudad = $comanda->ciudad;
        $factura->codagente = $this->agente->codagente;
        $factura->codalmacen = $comanda->codalmacen;
        $factura->codcliente = $comanda->codcliente;
        $factura->coddir = $comanda->coddir;
        $factura->coddivisa = $divisa->coddivisa;
        $factura->codejercicio = $ejercicio->codejercicio;
        $factura->codpago = $comanda->codpago;
        $factura->codpais = $comanda->codpais;
        $factura->codpostal = $comanda->codpostal;
        $factura->codserie = $serie->codserie;
        $factura->direccion = $comanda->direccion;
        $factura->neto = $comanda->neto;
        $factura->nombrecliente = $comanda->nombrecliente;
        $factura->observaciones = $comanda->observaciones;
        $factura->porcomision = $this->agente->porcomision;
        $factura->provincia = $comanda->provincia;
        $factura->tasaconv = $divisa->tasaconv;
        $factura->total = $comanda->total;
        $factura->totaliva = $comanda->totaliva;

        $factura->set_fecha_hora($factura->fecha, $factura->hora);
        $factura->vencimiento = $forma_pago->calcular_vencimiento($factura->fecha, $cliente->diaspago);

        /// función auxiliar para implementar en los plugins que lo necesiten
        if (!fs_generar_numero2($factura)) {
            $factura->numero2 = $comanda->numero2;
        }

        if ($factura->save()) {
            $comanda->idfactura = $factura->idfactura;
            $comanda->save();

            foreach ($comanda->get_lineas() as $lin) {

                $linea = new linea_factura_cliente();
                $linea->idfactura = $factura->idfactura;
                $linea->cantidad = $lin->cantidad;
                $linea->codimpuesto = $lin->codimpuesto;
                $linea->descripcion = $lin->descripcion;
                $linea->dtopor = $lin->dtopor;
                $linea->irpf = $lin->irpf;
                $linea->iva = $lin->iva;
                $linea->dtopor = $lin->dtopor;
                $linea->pvpsindto = $lin->pvpsindto;
                $linea->pvptotal = $lin->pvptotal;
                $linea->pvpunitario = $lin->pvpunitario;
                $linea->recargo = $lin->recargo;
                $linea->referencia = $lin->referencia;
                $linea->codcombinacion = $lin->codcombinacion;
                $linea->save();
            }

            $asiento_factura = new asiento_factura();
            if ($this->tesoreria) {
                if ($comanda->totalpago != 0 AND $comanda->totalpago2 != 0) {
                    $asiento_factura->generar_asiento_venta($factura);
                    $this->generar_recibos($factura);
                } else {
                    $factura->pagada = TRUE;
                    $factura->save();

                    $asiento_factura->generar_asiento_venta($factura);
                }
            } else {
                $factura->pagada = TRUE;
                $factura->save();

                if ($this->empresa->contintegrada) {
                    $asiento_factura->generar_asiento_venta($factura);
                }
            }

            $this->arqueo->totalcaja += floatval($_POST['tpv_efectivo']) - floatval($_POST['tpv_cambio']);
            if (isset($_POST['tpv_tarjeta'])) {
                $this->arqueo->totaltarjeta += floatval($_POST['tpv_tarjeta']);
            }
            $this->arqueo->save();

            $this->imprimir_ticket($factura, $this->terminal->num_tickets, TRUE);
        } else {
            $this->new_error_msg('Error al guardar la factura.');
        }
    }

    private function aux_articulos_num()
    {
        $num = 15;
        if ($this->articulos_grid == '3x3') {
            $num = 15;
        }

        return $num;
    }

    public function aux_articulos_tabs()
    {
        $tabs = array();
        $num = $this->aux_articulos_num();

        for ($i = 0; $i * $num <= count($this->resultado); $i++) {
            $tabs[] = $i + 1;
        }

        return $tabs;
    }

    public function aux_articulos_grid()
    {
        $num = $this->aux_articulos_num();
        $articulos = array();

        $num2 = 0;
        foreach ($this->aux_articulos_tabs() as $tab) {
            $arttab = array();
            foreach ($this->resultado as $i => $value) {
                if ($i >= $num2 AND $i < $num2 + $num) {
                    $value->funcion_js = "return add_referencia('" . urlencode($value->referencia) . "', true)";
                    if ($value->tipo == 'atributos') {
                        $value->funcion_js = "return get_combinaciones('" . urlencode($value->referencia) . "')";
                    }

                    $arttab[] = $value;
                }
            }

            $articulos[$tab] = $arttab;
            $num2 += $num;
        }

        return $articulos;
    }

    public function familias($todas = FALSE)
    {
        $familias = array();

        $familia = new familia();
        if ($todas) {
            $familias = $familia->all();
        } else if ($this->tpv_config['tpv_familias']) {
            $aux = explode(',', $this->tpv_config['tpv_familias']);
            if ($aux) {
                foreach ($familia->all() as $fam) {
                    if (in_array($fam->codfamilia, $aux)) {
                        $familias[] = $fam;
                    }
                }
            }
        }

        return $familias;
    }

    private function modificar_factura()
    {
        $fact0 = new factura_cliente();
        $factura = $fact0->get($_POST['idfactura']);
        if ($factura) {
            $articulo = new articulo();
            $asient0 = new asiento();

            /// paso 1, eliminamos el asiento asociado
            if (!is_null($factura->idasiento)) {
                $asiento = $asient0->get($factura->idasiento);
                if ($asiento) {
                    if ($asiento->delete()) {
                        $factura->idasiento = NULL;
                    }
                } else {
                    $factura->idasiento = NULL;
                }
            }

            /// paso 2, eliminamos las líneas
            foreach ($factura->get_lineas() as $linea) {
                $linea->delete();
            }

            /// paso 3, eliminar la líneas de IVA
            foreach ($factura->get_lineas_iva() as $liva) {
                $liva->delete();
            }

            /// paso 4, guardamos las nuevas
            $continuar = TRUE;
            $factura->neto = 0;
            $factura->totaliva = 0;
            $factura->totalirpf = 0;
            $factura->totalrecargo = 0;
            for ($i = 1; $i < 200; $i++) {
                if (isset($_POST['f_referencia_' . $i])) {
                    $art0 = $articulo->get($_POST['f_referencia_' . $i]);
                    if ($art0) {
                        $sql = "SELECT idtpv_comanda FROM tpv_comandas WHERE idfactura='".$_POST['idfactura']."'";
                        $idtpv_comanda = $this->db->select($sql)[0]['idtpv_comanda'];
                        $linea = new linea_factura_cliente();
                        $linea->idfactura = $factura->idfactura;
                        $linea->referencia = $art0->referencia;
                        $linea->descripcion = $_POST['f_desc_' . $i];
                        $linea->codimpuesto = $art0->codimpuesto;
                        $linea->iva = floatval($_POST['f_iva_' . $i]);
                        $linea->dtopor = floatval($_POST['f_descuen_' . $i]);
                        $linea->pvpunitario = floatval($_POST['f_pvp_' . $i]);
                        $linea->cantidad = floatval($_POST['f_cantidad_' . $i]);
                        $linea->pvpsindto = $linea->pvpunitario * $linea->cantidad;
                        $linea->pvptotal = ($linea->pvpunitario * (100 - $linea->dtopor)/100) * $linea->cantidad;
                        $sql = "UPDATE tpv_lineascomanda SET dtopor='".$linea->dtopor."', iva='".$linea->iva."', pvpsindto='".$linea->pvpsindto."', pvptotal='".$linea->pvptotal."', pvpunitario='".$linea->pvpunitario."' WHERE idtpv_comanda='".$idtpv_comanda."' AND referencia='".$_POST['f_referencia_' . $i]."'";
                        $this->db->exec($sql);
                        if (isset($_POST['f_codcombinacion_' . $i])) {
                            $linea->codcombinacion = $_POST['f_codcombinacion_' . $i];
                        }

                        if ($linea->save()) {
                            /// descontamos del stock
                            $art0->sum_stock($factura->codalmacen, 0 - $linea->cantidad, FALSE, $linea->codcombinacion);

                            $factura->neto += $linea->pvptotal;
                            $factura->totaliva += ($linea->pvptotal * $linea->iva / 100);
                        } else {
                            $this->new_error_msg("¡Imposible guardar la línea con referencia: " . $linea->referencia);
                            $continuar = FALSE;
                        }
                    } else {
                        $this->new_error_msg("Artículo no encontrado: " . $_POST['f_referencia_' . $i]);
                        $continuar = FALSE;
                    }
                }
            }
            //die();

            if ($continuar) {
                /// redondeamos
                $factura->neto = round($factura->neto, FS_NF0);
                $factura->totaliva = round($factura->totaliva, FS_NF0);
                $factura->total = $factura->neto + $factura->totaliva;
                $fecha = date("Y-m-d");
                $hora = date("H:i:s");
                $sql = "SELECT ultentregado FROM tpv_comandas WHERE idfactura='".$_POST['idfactura']."'";
                $entreg = $this->db->select($sql);
                $vuelta = $entreg[0]['ultentregado'] - $factura->total;
                $sql = "UPDATE tpv_comandas SET totalpago='".$factura->total."', fecha='".$fecha."', hora='".$hora."', neto='".$factura->neto."', total='".$factura->total."', totaliva='".$factura->totaliva."', ultcambio='".$vuelta."' WHERE idfactura='".$_POST['idfactura']."'";
                $this->db->exec($sql);
                if ($factura->save()) {
                    $this->new_message('<a href="' . $factura->url() . '" class="text-capitalize">'
                        . FS_FACTURA . '</a> modificada correctamente.');
                } else {
                    $this->new_error_msg("Error al modificar la factura.");
                }
            } else {
                $this->new_error_msg("Error al modificar la factura.");
            }
        } else {
            $this->new_error_msg('Factura no encontrada.');
        }
    }

    /**
     * 
     * @param factura_cliente $factura
     */
    private function generar_recibos($factura)
    {
        $ref0 = new recibo_factura();

        $formap = $this->forma_pago->get($this->tpv_config['tpv_fpago_efectivo']);
        if ($formap) {
            $recibo = new recibo_cliente();
            $recibo->cifnif = $factura->cifnif;
            $recibo->coddivisa = $factura->coddivisa;
            $recibo->tasaconv = $factura->tasaconv;
            $recibo->codcliente = $factura->codcliente;
            $recibo->estado = 'Pagado';
            $recibo->fecha = $factura->fecha;
            $recibo->fechav = $factura->fecha;
            $recibo->idfactura = $factura->idfactura;
            $recibo->importe = floatval($_POST['tpv_efectivo']) - floatval($_POST['tpv_cambio']);
            $recibo->codpago = $formap->codpago;
            $recibo->nombrecliente = $factura->nombrecliente;
            $recibo->numero = $recibo->new_numero($recibo->idfactura);
            $recibo->codigo = $factura->codigo . '-' . sprintf('%02s', $recibo->numero);
            if ($recibo->save()) {
                $ref0->nuevo_pago_cli($recibo);
            }
        }

        $formap = $this->forma_pago->get($this->tpv_config['tpv_fpago_tarjeta']);
        if ($formap) {
            $recibo = new recibo_cliente();
            $recibo->cifnif = $factura->cifnif;
            $recibo->coddivisa = $factura->coddivisa;
            $recibo->tasaconv = $factura->tasaconv;
            $recibo->codcliente = $factura->codcliente;
            $recibo->estado = 'Pagado';
            $recibo->fecha = $factura->fecha;
            $recibo->fechav = $factura->fecha;
            $recibo->idfactura = $factura->idfactura;
            $recibo->importe = floatval($_POST['tpv_tarjeta']);
            $recibo->codpago = $formap->codpago;
            $recibo->nombrecliente = $factura->nombrecliente;
            $recibo->numero = $recibo->new_numero($recibo->idfactura);
            $recibo->codigo = $factura->codigo . '-' . sprintf('%02s', $recibo->numero);
            if ($recibo->save()) {
                $ref0->nuevo_pago_cli($recibo);
            }
        }
    }

    private function share_extensions()
    {
        $fsext = new fs_extension();
        $fsext->name = 'api_remote_printer';
        $fsext->from = __CLASS__;
        $fsext->type = 'api';
        $fsext->text = 'remote_printer';
        $fsext->save();
    }

    private function new_search()
    {
        /// desactivamos la plantilla HTML
        $this->template = FALSE;
        $articulo = new articulo();
        $stock = new stock();

        $codfamilia = '';
        if (isset($_REQUEST['codfamilia'])) {
            $codfamilia = $_REQUEST['codfamilia'];
        }
        $codfabricante = '';
        if (isset($_REQUEST['codfabricante'])) {
            $codfabricante = $_REQUEST['codfabricante'];
        }
        $con_stock = isset($_REQUEST['con_stock']);
        $resultados = $articulo->search($this->query, 0, $codfamilia, $con_stock, $codfabricante);

        $this->precios_resultados($resultados);

        header('Content-Type: application/json');
        echo json_encode($resultados);
    }

    public function articulos_favoritos()
    {
        $articulos = array();
        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        if($id_comanda_marcaje > 0){
            $data = $this->db->select("SELECT articulos.*, tpv_articulos_favoritos.posicion, IFNULL(tpv_lineas_comanda_marcaje.cantidad, 0) as cantidad FROM articulos
  INNER JOIN tpv_articulos_favoritos ON articulos.referencia = tpv_articulos_favoritos.referencia
  LEFT JOIN tpv_lineas_comanda_marcaje ON tpv_lineas_comanda_marcaje.idtpv_comanda = ".$id_comanda_marcaje." AND tpv_articulos_favoritos.referencia = tpv_lineas_comanda_marcaje.referencia
ORDER BY tpv_articulos_favoritos.posicion ASC");
        } else {
            $data = $this->db->select("SELECT articulos.*, tpv_articulos_favoritos.posicion  FROM articulos INNER JOIN tpv_articulos_favoritos ON articulos.referencia = tpv_articulos_favoritos.referencia ORDER BY tpv_articulos_favoritos.posicion ASC");
        }

        if($data){
            foreach ($data as $item) {
                $articulo = new \articulo($item);
                $articulo->cantidad = isset($item["cantidad"]) ? $item["cantidad"] : 0;
                $articulos[] = $articulo;
            }
        }
        return $articulos;
    }

    public function articulos_marcaje_no_favoritos()
    {
        $articulos = array();
        $id_comanda_marcaje = $this->get_comanda_marcaje_activa();
        if($id_comanda_marcaje > 0){

            $data = $this->db->select("SELECT articulos.*, tpv_lineas_comanda_marcaje.cantidad FROM articulos
  INNER JOIN tpv_lineas_comanda_marcaje ON tpv_lineas_comanda_marcaje.idtpv_comanda = '".$id_comanda_marcaje."' AND tpv_lineas_comanda_marcaje.referencia = articulos.referencia
WHERE articulos.referencia NOT IN (SELECT referencia FROM tpv_articulos_favoritos)");

            if($data){
                foreach ($data as $item) {
                    $articulo = new \articulo($item);
                    $articulo->cantidad = isset($item["cantidad"]) ? $item["cantidad"] : 0;
                    $articulos[] = $articulo;
                }
            }
        }
        return $articulos;
    }


    public function articulos_favoritos_config()
    {
        $articulos = array();
        for ($i = 0; $i < 15; $i++) {
            $obj = new stdClass();
            $obj->posicion = $i+1;
            $obj->referencia = "";
            $articulos[$i] = $obj;
        }
        $data = $this->db->select("SELECT articulos.*, tpv_articulos_favoritos.posicion  FROM articulos INNER JOIN tpv_articulos_favoritos ON articulos.referencia = tpv_articulos_favoritos.referencia ORDER BY tpv_articulos_favoritos.posicion ASC");
        if($data){
            foreach ($data as $item) {
                $articulo = new \articulo($item);
                $articulo->posicion = $item["posicion"];
                $articulos[$item["posicion"]-1] = $articulo;
            }
        }
        return $articulos;
    } 
    
    private function ventas_modal(){
         $this->template = 'ajax/tpv_tactil_venta_familias';
         ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $familia = new familia();
        $todasLasFamilias = $familia->all();
         $familiasParaExtracto = [];
        foreach ($todasLasFamilias as $keyFamilia => $familia) {
            $familiasParaExtracto[$familia->codfamilia] = [
                "id" => $keyFamilia,
                "descripcion" => $familia->descripcion,
                "codigo" => $familia->codfamilia,
                "vendido" => 0,
                "vendido_format" => 0,
                "ventas" => false
            ];
        }
        $this->resultado["familiasParaExtracto"] = ["familias" => $familiasParaExtracto];
    }

    private function ventas_modal_result() {
        $this->template = 'ajax/tpv_tactil_venta_familias';

        $familias_seleccionadas = $_GET['familias'];
        $fecha_inicial = $_GET['desde'];
        $fecha_final = $_GET['hasta'];

        echo $fecha_final;
        echo $fecha_inicial;

         $todasLasFamilias = array();

        $familia = new familia();
        if ($familias_seleccionadas) {
            $aux = explode(',',$familias_seleccionadas);
            if ($aux) {
                foreach ($familia->all() as $fam) {
                    if (in_array($fam->codfamilia, $aux)) {
                        $todasLasFamilias[] = $fam;
                    }
                }
            }
        }

        $familiasParaExtracto = [];
        foreach ($todasLasFamilias as $keyFamilia => $familia) {
            $familiasParaExtracto[$familia->codfamilia] = [
                "id" => $keyFamilia,
                "descripcion" => $familia->descripcion,
                "codigo" => $familia->codfamilia,
                "vendido" => 0,
                "vendido_format" => 0,
                "ventas" => false
            ];
        }
        if (!$familiasParaExtracto) {
            return;
        }

        $comandaObj = new tpv_comanda();

        $comandasParaExtracto = $comandaObj->all_desde($fecha_inicial, $fecha_final);
        $totalVendidoHoy = 0;

        foreach ($comandasParaExtracto as $keyComanda => $comanda) {
            $lineaComandaObj = new linea_comanda();
            $lineasPorComanda = $lineaComandaObj->all_from_comanda($comanda->idtpv_comanda);
            foreach ($lineasPorComanda as $keyLineaComanda => $lineaComanda) {
                $articuloObj = new articulo();
                $articulo = $articuloObj->get($lineaComanda->referencia);
                if (!isset($familiasParaExtracto[$articulo->codfamilia])) continue;
                $pvpTotalLinea = round($lineaComanda->pvptotal * ($lineaComanda->iva / 100 + 1), 2);
                $familiasParaExtracto[$articulo->codfamilia]["vendido"] += $pvpTotalLinea;
                $totalVendidoHoy += $pvpTotalLinea;
                $familiasParaExtracto[$articulo->codfamilia]["vendido_format"] =
                    number_format($familiasParaExtracto[$articulo->codfamilia]["vendido"], 2, '.', '');
                if(!$familiasParaExtracto[$articulo->codfamilia]["ventas"]){
                    $familiasParaExtracto[$articulo->codfamilia]["ventas"] = true;
                }
            }
        }

        $this->resultado["familiasParaExtracto"] = ["familias" => $familiasParaExtracto, "totalVendidoHoy" => $totalVendidoHoy];
    }
    
     private function imprimir_ventas_familia() {
        $this->ventas_modal_result();
        $familias = $this->familiasParaExtracto();
         if ($familias) {
             $total = $this->totalVendidoHoy();
             $fecha_inicial = $_GET['desde'];
             $fecha_final = $_GET['hasta'];
             $empresa = $this->empresa;
             $agente = $this->agente->get_fullname();
             $dia = $this->today();
             $hora = $this->hour();
             $this->terminal->imprimir_ventas_familia($familias, $total, $empresa, $agente, $fecha_inicial, $fecha_final, $dia, $hora);
         }
         $this->template = "tpv_tactil2";
    }


private function extractos_modal() {
        $this->template = 'ajax/tpv_tactil_extracto_familias';
        $fecha = empty($_REQUEST['fecha']) ? date('d-m-Y') : $_REQUEST['fecha'];
        $familia = new familia();
        $todasLasFamilias = $familia->all();

        $familiasParaExtracto = [];
        foreach ($todasLasFamilias as $keyFamilia => $familia) {
            $familiasParaExtracto[$familia->codfamilia] = [
                "id" => $keyFamilia,
                "descripcion" => $familia->descripcion,
                "codigo" => $familia->codfamilia,
                "vendido" => 0,
                "vendido_format" => 0,
                "ventas" => false
            ];
        }

        $comandaObj = new tpv_comanda();
        $comandasParaExtracto = $comandaObj->all_desde($fecha, $fecha);
        $totalVendidoHoy = 0;

        foreach ($comandasParaExtracto as $keyComanda => $comanda) {
            $lineaComandaObj = new linea_comanda();
            $lineasPorComanda = $lineaComandaObj->all_from_comanda($comanda->idtpv_comanda);
            $totalVendidoHoy += $comanda->total;
            foreach ($lineasPorComanda as $keyLineaComanda => $lineaComanda) {
                $articuloObj = new articulo();
                $articulo = $articuloObj->get($lineaComanda->referencia);
                $familiasParaExtracto[$articulo->codfamilia]["vendido"] += round($lineaComanda->pvptotal * ($lineaComanda->iva / 100 + 1), 2);
                $familiasParaExtracto[$articulo->codfamilia]["vendido_format"] =
                    number_format($familiasParaExtracto[$articulo->codfamilia]["vendido"], 2, '.', '');
                if(!$familiasParaExtracto[$articulo->codfamilia]["ventas"]){
                    $familiasParaExtracto[$articulo->codfamilia]["ventas"] = true;
                }
            }
        }

        $this->resultado["fecha"] = $fecha;
        $this->resultado["familiasParaExtracto"] = ["familias" => $familiasParaExtracto, "totalVendidoHoy" => $totalVendidoHoy];
    }
    
     public function totalVendidoHoy() {
        return $this->resultado["familiasParaExtracto"]["totalVendidoHoy"];
    }
    public function totalVendidoHoyFormat() {
        return number_format($this->totalVendidoHoy(), 2, '.', '');
    }
    public function familiasParaExtracto() {
        return $this->resultado ? $this->resultado["familiasParaExtracto"]["familias"] : null;
    }

    private function imprimir_extracto() {
        $this->extractos_modal();
        $familias = $this->familiasParaExtracto();
        $total = $this->totalVendidoHoy();
        $empresa = $this->empresa;
        $agente = $this->agente->get_fullname();
        $dia = empty($_REQUEST["fecha"]) ? $this->today() : $_REQUEST["fecha"];
        //$hora = $dia === $this->today() ? $this->hour() : "";
        $hora = "";
        $this->terminal->imprimir_extracto($familias, $total, $empresa, $agente, $dia, $hora);
        $this->template = "tpv_tactil2";
    }

    private function compile_template_as_index()
    {
        /// configuramos rain.tpl
        raintpl::configure('base_url', NULL);
        raintpl::configure('tpl_dir', 'view/');
        raintpl::configure('path_replace', FALSE);

        /// ¿Se puede escribir sobre la carpeta temporal?
        if (is_writable('tmp')) {
            raintpl::configure('cache_dir', 'tmp/' . FS_TMP_NAME);
        }

        $tpl = new RainTPL();
        $tpl->assign('fsc', $this);

        if (filter_input(INPUT_POST, 'user')) {
            $tpl->assign('nlogin', filter_input(INPUT_POST, 'user'));
        } elseif (filter_input(INPUT_COOKIE, 'user')) {
            $tpl->assign('nlogin', filter_input(INPUT_COOKIE, 'user'));
        } else {
            $tpl->assign('nlogin', '');
        }

        return $tpl->draw($this->template, true);
    }
}
