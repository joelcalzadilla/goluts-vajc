/**
 * @author Carlos García Gómez      neorazorx@gmail.com
 * @copyright 2015-2017, Carlos García Gómez. All Rights Reserved.
 * @copyright 2015-2017, Jorge Casal Lopez. All Rights Reserved.
 */

function getNumLineas() {
    return ($('#tpv_albaran').find('>tr').length || 0) + 1;
}
var fs_nf0 = 2;
var tpv_url = '';
var siniva = false;
var irpf = 0;
var all_impuestos = [];
var cliente = false;
var fin_busqueda1 = true;
var keyboard_id = false;
var keyboard2_id = 'tpv_efectivo';
var keyboard_tipo = false;
var keyboard_num = false;
var tesoreria = false;

var lineas_cache = '';
var usar_cache = true;
var volver_familias = false;

var focusGrid = {
    currentRow: 0,
    currentCell: 0,
    maxRow: 0,
    maxCell: 0
}

var keyNames = {
    27: "Esc",
    113: "F2",
    114: "F3",
    115: "F4",
    117: "F6",
    118: "F7",
    119: "F8",
    120: "F9",
    122: "F11",
    123: "F12",
    48: "0",
    49: "1",
    50: "2",
    51: "3",
    52: "4",
    53: "5",
    54: "6",
    55: "7",
    56: "8",
    57: "9",
    96: "N-0",
    97: "N-1",
    98: "N-2",
    99: "N-3",
    100: "N-4",
    101: "N-5",
    102: "N-6",
    103: "N-7",
    104: "N-8",
    105: "N-9",
    9:"TAB",
    36:"Ini",
    35:"Fin",
    33:"RePág",
    34:"AvPág",
    "SHIFT+TAB":"SHIFT+TAB",
    "SHIFT+FIN":"SHIFT+Fin",
}

var keymapSections = {
    113: "products",//"F2",
    115: "ticket",//"F4",
    118: "temporary_board"//"F7",
}
var keymap = {
    products: {
        27: "btn-cancel-modal-product", //Esc
        113: "", //F2
        115: "", //F4
        118: "", //F7
        119: "btn-keymap-save-ticket", //F8
        120: "", //F9
        122: "btn-keymap-abrir-caja", //F11
        123: "btn-keymap-abrir-solo-caja", //F12
        37: "", //Arrow left
        38: "", //Arrow up
        39: "", //Arrow right
        40: "", //Arrow down
        48: "", //0
        49: "", //1
        50: "", //2
        51: "", //3
        52: "", //4
        53: "", //5
        54: "", //6
        55: "", //7
        56: "", //8
        57: "", //9
        96: "", //numpad 0
        97: "", //numpad 1
        98: "", //numpad 2
        99: "", //numpad 3
        100: "", //numpad 4
        101: "", //numpad 5
        102: "", //numpad 6
        103: "", //numpad 7
        104: "", //numpad 8
        105: "", //numpad 9,
        33: "btn-gestion-stock",//"RePág",
        34: "btn-save-modal-product",//"AvPág",
    },
    ticket: {
        27: "btn-keymap-cart", //Esc
        113: "", //F2
        114: "", //F3
        115: "", //F4
        117: "", //F6
        118: "btn-open-ventas-modal", //F7 //para abrir funcionalidad de ventas familias por fecha
        119: "btn-keymap-save-ticket", //F8
        120: "btn-keymap-print-last-bill", //F9
        //122: "btn-keymap-abrir-caja", //F11
        122: "btn-open-extractos-modal", //F11
        123: "btn-keymap-abrir-solo-caja", //F12
        
        9: "", //TAB
        37: "", //Arrow left
        38: "", //Arrow up
        39: "", //Arrow right
        40: "", //Arrow down
        48: "", //0
        49: "", //1
        50: "", //2
        51: "", //3
        52: "", //4
        53: "", //5
        54: "", //6
        55: "", //7
        56: "", //8
        57: "", //9
        96: "", //numpad 0
        97: "", //numpad 1
        98: "", //numpad 2
        99: "", //numpad 3
        100: "", //numpad 4
        101: "", //numpad 5
        102: "", //numpad 6
        103: "", //numpad 7
        104: "", //numpad 8
        105: "", //numpad 9
        36: "",//"Ini",
        35: "",//"Fin",
        33: "btn-keymap-cart-history",//"RePág",
        //34: "btn-keymap-box",//"AvPág",
        34: "btn-show-last-sale",//"AvPág",
        "SHIFT+TAB": "",//"SHIFT+TAB"
        "SHIFT+FIN": "btn-keymap-clean-sale"//"SHIFT+FIN"
    },
    temporary_board: {
        //27: "", //Esc
        113: "", //F2
        115: "", //F4
        118: "", //F7
        119: "btn-keymap-save-ticket", //F8
        120: "", //F9
        122: "btn-keymap-abrir-caja", //F11
        123: "btn-keymap-abrir-solo-caja", //F12
        37: "", //Arrow left
        38: "", //Arrow up
        39: "", //Arrow right
        40: "", //Arrow down
        48: "", //0
        49: "", //1
        50: "", //2
        51: "", //3
        52: "", //4
        53: "", //5
        54: "", //6
        55: "", //7
        56: "", //8
        57: "", //9
        96: "", //numpad 0
        97: "", //numpad 1
        98: "", //numpad 2
        99: "", //numpad 3
        100: "", //numpad 4
        101: "", //numpad 5
        102: "", //numpad 6
        103: "", //numpad 7
        104: "", //numpad 8
        105: "", //numpad 9
        36: "",//"Ini",
        35: "",//"Fin",
        33: "btn-keymap-marcaje-cerrar-venta",//"RePág",
        34: "btn-keymap-marcaje-limpiar",//"AvPág",
        "SHIFT+TAB": "",//"SHIFT+TAB"
        "SHIFT+FIN": ""//"SHIFT+FIN"
    },
    payment: {
        27: "", //Esc
        113: "", //F2
        115: "", //F4
        118: "", //F7
        119: "boton_guardar_ticket", //F8
        120: "boton_guardar_imprimir_ticket", //F9
        122: "", //F11
        123: "btn-keymap-abrir-solo-caja", //F12
        37: "", //Arrow left
        38: "", //Arrow up
        39: "", //Arrow right
        40: "", //Arrow down
        48: "", //0
        49: "", //1
        50: "", //2
        51: "", //3
        52: "", //4
        53: "", //5
        54: "", //6
        55: "", //7
        56: "", //8
        57: "", //9
        96: "", //numpad 0
        97: "", //numpad 1
        98: "", //numpad 2
        99: "", //numpad 3
        100: "", //numpad 4
        101: "", //numpad 5
        102: "", //numpad 6
        103: "", //numpad 7
        104: "", //numpad 8
        105: "" //numpad 9
    },
    bill: {
        27: "", //Esc
        113: "", //F2
        115: "", //F4
        118: "", //F7
        119: "btn-keymap-save-ticket", //F8
        120: "", //F9
        122: "btn-keymap-abrir-caja", //F11
        123: "btn-keymap-abrir-solo-caja", //F12
        9: "", //TAB
        37: "", //Arrow left
        38: "", //Arrow up
        39: "", //Arrow right
        40: "", //Arrow down
        48: "", //0
        49: "", //1
        50: "", //2
        51: "", //3
        52: "", //4
        53: "", //5
        54: "", //6
        55: "", //7
        56: "", //8
        57: "", //9
        96: "", //numpad 0
        97: "", //numpad 1
        98: "", //numpad 2
        99: "", //numpad 3
        100: "", //numpad 4
        101: "", //numpad 5
        102: "", //numpad 6
        103: "", //numpad 7
        104: "", //numpad 8
        105: "", //numpad 9
        36: "",//"Ini",
        35: "",//"Fin",
        33: "btn-keymap-print-bill",//"RePág",
        34: "btn-keymap-save-bill",//"AvPág",
        "SHIFT+TAB": ""//"SHIFT+TAB"
    },
    product: {
        27: "btn-cancel-modal-product", //Esc
        113: "", //F2
        115: "", //F4
        118: "", //F7
        119: "btn-keymap-save-ticket", //F8
        120: "btn-keymap-save-ticket", //F9
        122: "btn-keymap-abrir-caja", //F11
        123: "btn-keymap-abrir-solo-caja", //F12
        9: "", //TAB
        37: "", //Arrow left
        38: "", //Arrow up
        39: "", //Arrow right
        40: "", //Arrow down
        48: "", //0
        49: "", //1
        50: "", //2
        51: "", //3
        52: "", //4
        53: "", //5
        54: "", //6
        55: "", //7
        56: "", //8
        57: "", //9
        96: "", //numpad 0
        97: "", //numpad 1
        98: "", //numpad 2
        99: "", //numpad 3
        100: "", //numpad 4
        101: "", //numpad 5
        102: "", //numpad 6
        103: "", //numpad 7
        104: "", //numpad 8
        105: "", //numpad 9
        36: "",//"Ini",
        35: "",//"Fin",
        33: "btn-gestion-stock",//"RePág",
        34: "btn-save-modal-product",//"AvPág",
        "SHIFT+TAB": ""//"SHIFT+TAB"
    },
}

var keymapActive = "products";
var gridParent = "";

function loadKeymapSections() {
    $.each(keymapSections, function (index, value) {
        if (value) {
            if ($(".section-focusable[data-section="+value+"]") && $(".section-focusable[data-section="+value+"]").length > 0) {
                $(".section-focusable[data-section="+value+"]").append("<span class='badge badge-key'>" + keyNames[index] + "</span>");
            }
        }
    });
}

function loadKeymap(view) {
    $(".focus-active").removeClass("focus-active");
    $(".badge-delete-line").remove();
    $(".btn-delete-line").removeClass("btn-delete-line-focus");
    $(".btn-subtract-articulo-marcaje").removeClass("btn-subtract-line-focus");
    $(".badge-subtract-line").remove();
    keymapActive = view;
    gridParent = "";
    $(".section-focusable").removeClass("section-active");
    $(".keymap-child").remove();
    $(".section-focusable[data-section="+view+"]").addClass("section-active");
    $.each(keymap[view], function (index, value) {
        if (value) {
            if ($("#" + value) && $("#" + value).length > 0) {
                $("#" + value).append("<span class='badge badge-key keymap-child'>" + keyNames[index] + "</span>");
            }
        }
    });
    if(view == "ticket"){
        $("#btn-keymap-cart").click();
        if(!$(":focus", ".section-focusable[data-section=ticket]").hasClass("element-focusable")){
            var oldVal = $("#b_codbar").val();
            $("#b_codbar").focus().val('').val(oldVal);;
        }
        gridParent = ".table-products";
    } else {
        $("#b_codbar").blur();
        if(view == "temporary_board"){
            gridParent = ".grid-marcaje";
            var oldVal = $("#anadir_prod_marcaje").val();
            $("#anadir_prod_marcaje").focus().val('').val(oldVal);
        } else if(view == "products"){
            gridParent = $(".grid-articulos", ".section-focusable[data-section=products]").length > 0 ? ".grid-articulos":".grid-catalog";
            var oldVal = $("#b_articulos").val();
            $("#b_articulos").focus().val('').val(oldVal);
        }
    }
}

function changeCurrentGridCell() {
    if(gridParent != ""){
        if($(".element-focusable-parent", gridParent).length > 0){
            var $parent = $(".element-focusable-parent", gridParent);
            focusGrid.maxRow = $parent.length - 1;
            if($(".element-focusable", $parent[focusGrid.currentRow])){
                focusGrid.maxCell = $(".element-focusable", $parent[focusGrid.currentRow]).length - 1;
            }
            if($(".element-focusable", $parent[focusGrid.currentRow])[focusGrid.currentCell]){
                $(".element-focusable", $parent[focusGrid.currentRow])[focusGrid.currentCell].focus();
                if(gridParent == ".table-products"){
                    //Añadir opción de eliminado
                    $(".btn-delete-line",  $parent[focusGrid.currentRow]).addClass("btn-delete-line-focus");
                    $(".btn-delete-line",  $parent[focusGrid.currentRow]).append("<span class='badge badge-key badge-delete-line'>F4</span>");
                } else if(gridParent == ".grid-marcaje"){
                    //Añadir opción de restar
                    var referencia = $($(".element-focusable", $parent[focusGrid.currentRow])[focusGrid.currentCell]).data("referencia");

                    $(".btn-subtract-articulo-marcaje[data-referencia!='"+referencia+"']").removeClass("btn-subtract-line-focus");
                    $(".badge-subtract-line", ".btn-subtract-articulo-marcaje[data-referencia!='"+referencia+"']").remove();

                    if(!$(".btn-subtract-articulo-marcaje[data-referencia='"+referencia+"']",  $parent[focusGrid.currentRow]).hasClass("btn-subtract-line-focus")){
                        $(".btn-subtract-articulo-marcaje[data-referencia='"+referencia+"']",  $parent[focusGrid.currentRow]).addClass("btn-subtract-line-focus");
                        $(".btn-subtract-articulo-marcaje[data-referencia='"+referencia+"']",  $parent[focusGrid.currentRow]).append("<span class='badge badge-key badge-subtract-line'>Supr</span>");
                    }
                }
            }
        } else if($(".element-focusable", gridParent).length > 0){
            focusGrid.maxRow = $(".element-focusable", gridParent).length - 1;
            focusGrid.maxCell = 0;
            if($(".element-focusable", gridParent)[focusGrid.currentRow]){
                $(".element-focusable", gridParent)[focusGrid.currentRow].focus();
                $(".element-focusable").removeClass("focus-active");
                $($(".element-focusable", gridParent)[focusGrid.currentRow]).addClass("focus-active");
                $($(".element-focusable", gridParent)[focusGrid.currentRow]).scrollIntoView();
            }
        }
    }
}

function get_articulos(codfamilia)
{

    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'codfamilia=' + codfamilia + '&codcliente=' + document.f_tpv.cliente.value,
        success: function (datos) {
            var html_btn_familias = $("#btn-keymap-familias").html();
            $("#catalogo").html(datos);
            $('#tabs_catalogo a[href="#articulos1"]').tab('show');

            /// comprobamos si el navegador soporta localstorage
            if (typeof (Storage) !== "undefined" && usar_cache) {
                /// nos guardamos para la caché
                localStorage.setItem("tpv_tactil_fam" + codfamilia, datos);
            }
            $("#btn-keymap-familias").html(html_btn_familias);
            gridParent = ".grid-articulos";
            focusGrid.currentCell = 0;
            focusGrid.currentRow = 0;
            changeCurrentGridCell();
        }
    });
    return false;
}

function get_combinaciones(ref)
{
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'referencia4combi=' + ref + '&codcliente=' + document.f_tpv.cliente.value,
        success: function (datos) {
            $("#modal_articulos").modal('hide');
            $("#div_combinaciones").html(datos);
            $("#modal_combinaciones").modal('show');
        }
    });

    return false;
}

function add_referencia(ref, focusSearchCatalog, resultHtml)
{
    focusSearchCatalog = typeof focusSearchCatalog !== "undefined" ? focusSearchCatalog : false;

    var ajaxCallback = function (datos) {
        if (datos.indexOf('<!--no_encontrado-->') != -1) {
            bootbox.alert('¡Artículo no encontrado!');
        } else {
            $('#tabs_tpv a:first').tab('show');

            if (getNumLineas() == 1) {
                $("#tpv_albaran").html(datos);
            } else {
                $("#tpv_albaran").prepend(datos);
            }

            recalcular();
        }

        $("#modal_articulos").modal('hide');
        if(volver_familias) {
            $('#tabs_catalogo a:first').tab('show');
        }
        if(focusSearchCatalog){
            gridParent = ".grid-articulos";
        } else {
            $("#b_codbar").focus();
        }
    };

    if (resultHtml) {
        setTimeout(function () {
            ajaxCallback(resultHtml);
        }, 0);
    } else {
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: 'add_ref=' + ref + '&numlineas=' + getNumLineas() + '&codcliente=' + document.f_tpv.cliente.value,
            async: false,
            success: ajaxCallback
        });
    }

    return false;
}

function add_referencia_marcaje(ref, posicion)
{
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'add_ref_marcaje=' + ref + '&numlineas=' + getNumLineas() + '&codcliente=' + document.f_tpv.cliente.value + '&posicion='+posicion,
        success: function (datos) {
            if (datos.indexOf('<!--no_encontrado-->') != -1) {
                bootbox.alert('¡Artículo no encontrado!');
            } else {
                $(".block-marcaje").empty();
                $(".block-marcaje").html(datos);
            }

            $("#modal_articulos").modal('hide');
            if(volver_familias) {
                $('#tabs_catalogo a:first').tab('show');
            }
        }
    });

    return false;
}

function abrir_modal_articulo_mod(ref, ref_busc, show_results_sidebar, resultHtml)
{

    var ajaxCallback = function (datos) {
        if (datos == '') {
            bootbox.alert('¡Artículo no encontrado!');
        } else {
            $("#modal_articulo_mod").empty();
            $("#modal_articulo_mod").html(datos);
            $(".modal-title", $("#modal_articulo_mod")).html(ref ? ("Modificar artículo " + ref) : "Crear artículo");
            $(".btn-mod-save", $("#modal_articulo_mod")).html(ref ? "Modificar" : "Guardar");
           
            loadKeymap('product');
            if (show_results_sidebar) {
                $("#modal_articulo_mod").find('.modal-dialog').addClass('modal-dialog-with-sidebar');
            } else {
                $("#modal_articulo_mod").find('.modal-dialog').removeClass('modal-dialog-with-sidebar');
            }
            $("#modal_articulo_mod").modal('show');
            document.f_tpv.descripcion.focus();
        }
    };

    if (resultHtml) {
        setTimeout(function () {
            ajaxCallback(resultHtml);
        }, 0);
    } else {
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: 'cargar_datos_modal_articulo=' + (ref || "")+'&ref_busc='+ref_busc,
            async: false,
            success: ajaxCallback
        });
    }
}

function add_art_ref_marcaje(referencia, focus_search) {
    focus_search = typeof focus_search !== "undefined" ? focus_search : false;
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'add_art_ref_marcaje=' + referencia,
        async: false,
        success: function (datos) {
            if (datos.indexOf('<!--no_encontrado-->') != -1) {
                bootbox.alert('¡Artículo no encontrado!');
            } else {
                $(".block-marcaje").empty();
                $(".block-marcaje").html(datos);
            }

            $("#modal_articulos").modal('hide');
            if(volver_familias) {
                $('#tabs_catalogo a:first').tab('show');
            }
            if(focus_search){
                gridParent = ".grid-marcaje";
                $("#anadir_prod_marcaje").focus();
            }
        }
    });
}

function add_combinacion(ref, desc, pvp, dto, codimpuesto, codigo)
{
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'add_ref=' + ref + '&desc=' + desc + '&pvp=' + pvp + '&dto=' + dto + '&codimpuesto=' + codimpuesto
                + '&numlineas=' + getNumLineas() + '&codcliente=' + document.f_tpv.cliente.value + '&codcombinacion=' + codigo,
        success: function (datos) {
            if (datos.indexOf('<!--no_encontrado-->') != -1) {
                alert('¡Artículo no encontrado!');
            } else {
                $('#tabs_tpv a:first').tab('show')

                if (getNumLineas() == 1) {
                    $("#tpv_albaran").html(datos);
                } else {
                    $("#tpv_albaran").prepend(datos);
                }

                recalcular();
            }

            $("#modal_articulos").modal('hide');
            $("#modal_combinaciones").modal('hide');
        }
    });

    return false;
}

function reajusta_id_atributo(element, attribute, newIndex) {
    if (reajusta_id_atributo.attributeMatchPattern.test(element[attribute])) {
        element[attribute] = element[attribute].replace(reajusta_id_atributo.attributeReplacePattern, newIndex);
    }
}
reajusta_id_atributo.attributeMatchPattern = /^[a-z_]+_\d+$/;
reajusta_id_atributo.attributeReplacePattern = /\d+$/;
function reajustar_ids_lineas() {
    $('#tpv_albaran > tr').each(function (rowIndex, tr) {
        var indiceActual = getNumLineas() - rowIndex - 1;
        reajusta_id_atributo(tr, "id", indiceActual);
        $(tr).find('input').each(function (ignored, input) {
            reajusta_id_atributo(input, "name", indiceActual);
            reajusta_id_atributo(input, "id", indiceActual);
        });
    });
}

function recalcular(scheduled_execution)
{
    if (recalcular.timeoutId) {
        clearTimeout(recalcular.timeoutId);
    }

    reajustar_ids_lineas();

    var l_uds = 0;
    var l_pvp = 0;
    var l_iva = 0;
    var l_descuen = 0;
    var l_codimpuesto = null;
    var l_re = 0;
    var neto = 0;
    var total_iva = 0;
    var total_re = 0;
    var total_irpf = 0;
    var total_lineas = 0;
    var total_articulos = 0;
    $('#tpv_albaran > tr').each(function (index, element) {
        l_uds = parseFloat($('[id^="cantidad_"]', element).val());
        l_pvp = parseFloat($('[id^="pvp_"]', element).val());
        l_iva = parseFloat($('[id^="iva_"]', element).val());
        l_descuen = parseFloat($('[id^="descuen_"]', element).val());
        l_codimpuesto = parseFloat($('[id^="codimpuesto_"]', element).val());
        if(isNaN($('[id^="pvp_"]', element).val()) || $('[id^="descuen_"]', element).val() == "" || isNaN($('[id^="descuen_"]', element).val()) || $('[id^="cantidad_"]', element).val() == "" || isNaN($('[id^="cantidad_"]', element).val())) {
            $("#tpv_total").html('&nbsp;-&nbsp;');
            $('[id^="pvpt_"]', element).val('-');
            neto = 'error';
        } else {
            $('[id^="pvpt_"]', element).val(number_format(fs_round(l_uds * (l_pvp * (100 + l_iva) / 100) * (100 - l_descuen) / 100, fs_nf0), 2, '.'));
            if (!isNaN(neto)) {
                neto += l_uds * l_pvp * (100 - l_descuen) / 100;
            }

            l_re = 0;
            if (cliente.recargo) {
                for (var i = 0; i < all_impuestos.length; i++) {
                    if (all_impuestos[i].codimpuesto == l_codimpuesto) {
                        l_re = all_impuestos[i].recargo;
                    }
                }
            }


            total_iva += l_uds * l_pvp * (100 - l_descuen) / 100 * l_iva / 100;
            total_re += l_uds * l_pvp * (100 - l_descuen) / 100 * l_re / 100;
            total_irpf += l_uds * l_pvp * (100 - l_descuen) / 100 * irpf / 100;
            total_lineas++;
            total_articulos += l_uds;
        }
    });
    if (!isNaN(neto)) {
        neto = fs_round(neto, fs_nf0);
        total_iva = fs_round(total_iva, fs_nf0);
        total_re = fs_round(total_re, fs_nf0);
        total_irpf = fs_round(total_irpf, fs_nf0);
        $("#tpv_total").html(show_precio((neto + total_iva) + total_re - total_irpf));
        $("#tpv_total2").val(number_format(fs_round((neto + total_iva) + total_re - total_irpf, fs_nf0), 2, '.'));
        $("#total_lineas").html(total_lineas);
        $("#total_articulos").html(total_articulos);

        set_cache_lineas();
    }

    if (!scheduled_execution) {
        recalcular.timeoutId = setTimeout(function () {
            recalcular(true);
        }, 0);
    }
}

function set_cache_lineas()
{
    /// comprobamos si el navegador soporta localstorage
    if (typeof (Storage) !== "undefined" && usar_cache) {
        lineas_cache = '';

        for (var i = 1; i <= getNumLineas() + 100; i++) {
            /// solamente nos guardamos la caché si hay alguna linea de venta
            if ($("#linea_" + i).length > 0) {
                lineas_cache = $("#tpv_albaran").html();
                localStorage.setItem("tpv_tactil_lineas", lineas_cache);
                break;
            }
        }
    }
}

function clean_cache_lineas()
{
    /// comprobamos si el navegador soporta localstorage
    if (typeof (Storage) !== "undefined") {
        lineas_cache = '';
        localStorage.removeItem("tpv_tactil_lineas");
    }
    location.href = $('#btn-keymap-clean-sale').attr("href");
}

function set_pvpi(numOrRowElement)
{
    var num = typeof numOrRowElement === "object" ?
        $(numOrRowElement).closest('[id^="linea_"]').attr('id').replace(/linea_/, '') : numOrRowElement;

    l_pvpi = parseFloat($("#pvpi_" + num).val());
    l_iva = parseFloat($("#iva_" + num).val());

    if (isNaN(l_pvpi)) {
        $("#pvp_" + num).val('-');
        $("#tpv_total").html('&nbsp;-&nbsp;');
        $("#pvpt_" + num).val('-');
    } else {
        $("#pvp_" + num).val(l_pvpi * 100 / (100 + l_iva));
        recalcular();
    }
}

function set_pvpi_factura(numOrRowElement)
{
    var num = typeof numOrRowElement === "object" ?
        $(numOrRowElement).closest('[id^="linea_"]').attr('id').replace(/linea_/, '') : numOrRowElement;

    l_pvpi = parseFloat($("#f_pvpi_" + num).val());
    l_descuen = parseFloat($("#f_descuen_" + num).val());
    l_iva = parseFloat($("#f_iva_" + num).val());
    $("#f_pvp_" + num).val(l_pvpi / ((100 + l_iva)/100));
    $("#f_pvpt_" + num).val(l_pvpi * (100 - l_descuen)/100);
    recalcular_factura();
}

function recalcular_factura()
{
    var l_uds = 0;
    var l_pvp = 0;
    var l_iva = 0;
    var l_descuen = 0;
    var neto = 0;
    var total_iva = 0;

    for (var i = 1; i <= 200; i++) {
        if ($("#f_linea_" + i).length > 0) {
            l_uds = parseFloat($("#f_cantidad_" + i).val());
            l_pvp = parseFloat($("#f_pvp_" + i).val());
            l_descuen = parseFloat($("#f_descuen_" + i).val());
            l_iva = parseFloat($("#f_iva_" + i).val());
            $("#f_pvpt_" + i).val(l_uds * (l_pvp * (100 - l_descuen)/100) * (100 + l_iva)/100);
            neto += fs_round((l_uds * l_pvp * (100 - l_descuen) / 100), fs_nf0);
            total_iva += fs_round((l_uds * l_pvp * (100 - l_descuen) / 100 * l_iva / 100), fs_nf0);
        }
    }

    neto = fs_round(neto, fs_nf0);
    total_iva = fs_round(total_iva, fs_nf0);
    $("#f_total").val((neto + total_iva));
}

function linea_sum_ud(num, value)
{
    var udl = parseInt($("#cantidad_" + num).val()) + parseInt(value);
    $("#cantidad_" + num).val(udl);
    recalcular();
}

function send_ticket()
{
    if (document.f_tpv.codbar.value == '') {
        if (getNumLineas() > 1) {
            save_modal();
        } else {
            bootbox.alert('No has añadido nada para verder.', function(){$("#b_codbar").focus()});
        }
    } else {
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: 'codbar2=' + document.f_tpv.codbar.value + '&numlineas=' + getNumLineas(),
            success: function (datos) {
                if (datos.indexOf('<!--no_encontrado-->') != -1) {
                    bootbox.alert({
                        message: "¡Artículo no encontrado!",
                        callback: function () {
                            $("#codbar").focus();
                        }
                    });
                    document.f_tpv.codbar.value = '';
                } else if (datos.indexOf('get_combinaciones(') != -1) {
                    eval(datos);
                    document.f_tpv.codbar.value = '';
                } else {
                    if (getNumLineas() == 1) {
                        $("#tpv_albaran").html(datos);
                    } else {
                        $("#tpv_albaran").prepend(datos);
                    }

                    document.f_tpv.codbar.value = '';
                    recalcular();
                }
                document.f_tpv.codbar.focus();

            }
        });
    }
}

function save_modal()
{
    if (getNumLineas() > 1) {
        if ($("#tpv_total").html() == '&nbsp;-&nbsp;') {
            bootbox.alert({
                title: "Error de venta",
                buttons: {
                    ok: {
                        label: 'Aceptar',
                        className: 'btn-primary'
                    }
                },
                message: "No es posible realizar ningún cobro. Revisa que no haya cajas vacías en las líneas de la venta."
            });
        } else {
            loadKeymap('payment');
            $("#modal_guardar").modal('show')
            $("#modal_guardar").on('hidden.bs.modal', function () {
                loadKeymap("ticket");
                $("#b_codbar").focus();
            });
        }
    } else {
        bootbox.alert('No has vendido nada.');
    }
}

function aparcar_ticket()
{
    if ($("#tpv_total").html() == '&nbsp;-&nbsp;') {
        bootbox.alert({
            title: "Error de venta",
            buttons: {
                ok: {
                    label: 'Aceptar',
                    className: 'btn-primary'
                }
            },
            message: "No es posible apartar la venta. Revisa que no haya cajas vacías en las líneas de la venta."
        });
    } else {
        if (getNumLineas() > 1) {
            document.f_tpv.aparcar.value = 'TRUE';
            document.f_tpv.tpv_total.disabled = false;
            document.f_tpv.tpv_cambio.disabled = false;
            document.f_tpv.numlineas.value = getNumLineas();

            $.ajax({
                type: 'POST',
                url: tpv_url,
                dataType: 'html',
                data: $('form[name=f_tpv]').serialize(),
                success: function (datos) {
                    /// limpiamos la caché
                    clean_cache_lineas()

                    var newDoc = document.open("text/html", "replace");
                    newDoc.write(datos);
                    newDoc.close();
                }
            });

            return false;
        } else {
            bootbox.alert('No has vendido nada.');
        }
    }
}

function preimprimir_ticket()
{
    if (getNumLineas() > 1) {
        document.f_tpv.aparcar.value = 'TRUE';
        document.f_tpv.preimprimir.value = 'TRUE';
        document.f_tpv.tpv_total.disabled = false;
        document.f_tpv.tpv_cambio.disabled = false;
        document.f_tpv.numlineas.value = getNumLineas();

        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: $('form[name=f_tpv]').serialize(),
            success: function (datos) {
                /// limpiamos la caché
                clean_cache_lineas()

                var newDoc = document.open("text/html", "replace");
                newDoc.write(datos);
                newDoc.close();
            }
        });

        return false;
    } else {
        bootbox.alert('No has vendido nada.');
    }
}

function  guardar_imprimir_ticket() {
    if (document.f_tpv.boton_guardar_imprimir_ticket.disabled) return;
    document.f_tpv.imprimir_ticket.checked = true;
    guardar_ticket();
}
function guardar_ticket()
{
   
    if (document.f_tpv.boton_guardar_ticket.disabled) return;
    if (getNumLineas() > 1) {
        document.f_tpv.boton_guardar_ticket.disabled = true;
        document.f_tpv.boton_guardar_imprimir_ticket.disabled = true;
        document.f_tpv.aparcar.value = 'FALSE';
        document.f_tpv.tpv_total.disabled = false;
        document.f_tpv.tpv_cambio.disabled = false;
        document.f_tpv.numlineas.value = getNumLineas();
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: tpv_url,
                dataType: 'html',
                data: $('form[name=f_tpv]').serialize(),
                async: false,
                success: function (datos) {
                    /// limpiamos la caché
                    clean_cache_lineas()

                    var newDoc = document.open("text/html", "replace");
                    newDoc.write(datos);
                    newDoc.close();
                }
            });
        }, 0);
        return false;
    } else {
        bootbox.alert('No has vendido nada.');
    }
}

function modificar_articulo(referencia) {
    var distribuidora = document.f_tpv.distribuidora.value;
    var codbarras = document.f_tpv.codbarras.value;
    var nreferencia = document.f_tpv.nreferencia.value;
    var familia = document.f_tpv.familia[document.f_tpv.familia.selectedIndex].value;
    var impuesto = document.f_tpv.impuesto[document.f_tpv.impuesto.selectedIndex].value;
    var pvp_iva = document.f_tpv.pvp_iva.value;
    var descripcion = document.f_tpv.descripcion.value;
    var fcodigo = document.f_tpv.fcodigo.value;
    var reservas = document.f_tpv.reservas.value;
    var fecha_recepcion = document.f_tpv.fecha_recepcion.value;
    var stock_vendido_ult_recepcion = document.f_tpv.stock_vendido_ult_recepcion.value;
    var num_ultimo_recibido = document.f_tpv.num_ultimo_recibido.value;
    var uds_recibidas_ult_reparto = document.f_tpv.uds_recibidas_ult_reparto.value;
    var num_anterior = document.f_tpv.num_anterior.value;
    var uds_num_anterior = document.f_tpv.uds_num_anterior.value;
    var num_anterior_del_anterior = document.f_tpv.num_anterior_del_anterior.value;
    var uds_num_anterior_del_anterior = document.f_tpv.uds_num_anterior_del_anterior.value;
    var devuelto_descatalogado = 0;
    var bloqueado = 0;

    if (document.f_tpv.devuelto_descatalogado.checked) {
        devuelto_descatalogado = 1;
    } else {
        devuelto_descatalogado = 0;
    }

    if (document.f_tpv.bloqueado.checked) {
        bloqueado = 1;
    } else {
        bloqueado = 0;
    }

    var data = {
        action:"set_articulo_modificado",
        referencia: referencia || "",
        distribuidora: distribuidora,
        codbarras: codbarras,
        nreferencia: nreferencia,
        familia: familia,
        impuesto: impuesto,
        pvp_iva: pvp_iva,
        descripcion: descripcion,
        fcodigo: fcodigo,
        reservas: reservas,
        fecha_recepcion: fecha_recepcion,
        stock_vendido_ult_recepcion: stock_vendido_ult_recepcion,
        num_ultimo_recibido: num_ultimo_recibido,
        uds_recibidas_ult_reparto: uds_recibidas_ult_reparto,
        num_anterior: num_anterior,
        uds_num_anterior: uds_num_anterior,
        num_anterior_del_anterior: num_anterior_del_anterior,
        uds_num_anterior_del_anterior: uds_num_anterior_del_anterior,
        devuelto_descatalogado: devuelto_descatalogado,
        bloqueado: bloqueado
    }
    $.ajax ({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: data,
        success: function (datos) {

        }
    });
}

function mostrar_factura(id)
{
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'get_factura=' + id,
        success: function (datos) {

            $("#modal_factura").on('show.bs.modal', function (e) {
                setTimeout(function () {
                    loadKeymap('bill');
                    gridParent = ".table-factura";
                    focusGrid.currentRow = 0;
                    focusGrid.currentCell = 0;
                    changeCurrentGridCell();
                }, 500);

            });

            $("#modal_factura").on('hidden.bs.modal', function () {
                $(".element-focusable").removeClass("focus-active");
                loadKeymap('ticket');
            });

            $("#div_modal_factura").html(datos);
            $("#modal_factura").modal('show');
        }
    });

    return false;
}

function buscar_articulos()
{
    if (document.f_buscar_articulos.query.value == '') {
        $("#search_results").html('');
    } else {
        document.f_buscar_articulos.codcliente.value = document.f_tpv.cliente.value;

        fin_busqueda1 = false;
        $.getJSON(tpv_url, $("form[name=f_buscar_articulos]").serialize(), function (json) {
            var items = [];
            var insertar = false;
            $.each(json, function (key, val) {
                var stock = val.stockalm;
                if (val.stockalm != val.stockfis) {
                    stock += ' (' + val.stockfis + ')';
                }

                var tr_aux = '<tr>';
                if (val.bloqueado) {
                    tr_aux = "<tr class=\"danger\">";
                } else if (val.stockfis < val.stockmin) {
                    tr_aux = "<tr class=\"warning\">";
                } else if (val.stockalm > 0) {
                    tr_aux = "<tr class=\"success\">";
                }

                if (val.sevende && (val.stockalm > 0 || val.controlstock)) {
                    var funcion = "add_referencia('" + val.referencia + "')";

                    if($("input[name=config-marcaje]", "form[name=f_buscar_articulos]").val() == 1){
                        funcion = "add_referencia_marcaje('" + val.referencia + "', '"+$("input[name=config-marcaje-posicion]", "form[name=f_buscar_articulos]").val()+"')";
                    } else if($("input[name=config-marcaje]", "form[name=f_buscar_articulos]").val() == 2){
                        funcion = "add_art_ref_marcaje('" + val.referencia + "')";
                    }

                    if (val.tipo == 'atributos') {
                        funcion = "get_combinaciones('" + val.referencia + "')";
                    }

                    items.push(tr_aux + "<td>\n\
                  <a href=\"#\" onclick=\"" + funcion + "\">" + val.referencia + '</a> ' + val.descripcion + "</td>\n\
                  <td class=\"text-right\"><a href=\"#\" onclick=\"" + funcion + "\">" + show_pvp_iva(val.pvp * (100 - val.dtopor) / 100, val.codimpuesto) + "</a></td>\n\
                  <td class=\"text-right\">" + stock + "</td></tr>");
                } else if (val.sevende) {
                    items.push(tr_aux + "<td>\n\
                  <a href=\"#\" onclick=\"alert('Sin stock.')\">" + val.referencia + '</a> ' + val.descripcion + "</td>\n\
                  <td class=\"text-right\"><a href=\"#\" onclick=\"alert('Sin stock.')\">" + show_pvp_iva(val.pvp * (100 - val.dtopor) / 100, val.codimpuesto) + "</a></td>\n\
                  <td class=\"text-right\">" + stock + "</td></tr>");
                }

                if (val.query == document.f_buscar_articulos.query.value) {
                    insertar = true;
                    fin_busqueda1 = true;
                }
            });

            if (items.length == 0 && !fin_busqueda1) {
                items.push("<tr><td colspan=\"4\" class=\"warning\">Sin resultados.</td></tr>");
                insertar = true;
            }

            if (insertar) {
                $("#search_results").html("<div class=\"table-responsive\"><table class=\"table table-hover\"><thead><tr>\n\
               <th class=\"text-left\">Referencia + descripción</th><th class=\"text-right\">Precio</th>\n\
               <th class=\"text-right\">Stock</th></tr></thead>" + items.join('') + "</table></div>");
            }
        });
    }
}

function show_pvp_iva(pvp, codimpuesto)
{
    var iva = 0;
    if (cliente.regimeniva != 'Exento' && !siniva) {
        for (var i = 0; i < all_impuestos.length; i++) {
            if (all_impuestos[i].codimpuesto == codimpuesto) {
                iva = all_impuestos[i].iva;
                break;
            }
        }
    }

    return show_precio(pvp + pvp * iva / 100);
}

function get_keyboard(id, tipo, num)
{
    keyboard_id = id;
    keyboard_tipo = tipo;
    keyboard_num = num;

    $("#modal_keyboard").modal('show');
    $("#i_keyboard").val($("#" + keyboard_id).val());
}

function set_keyboard(key)
{
    if (key == 'back') {
        var str = $("#i_keyboard").val();

        if (str.length > 0) {
            $("#i_keyboard").val(str.substring(0, str.length - 1));
        }
    } else if (key == 'clear') {
        $("#i_keyboard").val('');
    } else if (key == '+/-') {
        $("#i_keyboard").val(0 - parseFloat($("#i_keyboard").val()));
    } else if (key == 'ok') {
        $("#" + keyboard_id).val($("#i_keyboard").val());
        $("#modal_keyboard").modal('hide');

        if (keyboard_tipo == 'pvpi') {
            set_pvpi(keyboard_num);
        }
    } else {
        $("#i_keyboard").val($("#i_keyboard").val() + key);
    }
}

function set_keyboard2(key)
{
    if (key == 'back') {
        var str = $("#" + keyboard2_id).val();

        if (str.length > 0) {
            $("#" + keyboard2_id).val(str.substring(0, str.length - 1));
        }
    } else if (key == 'clear') {
        $("#" + keyboard2_id).val('');
    } else {
        $("#" + keyboard2_id).val($("#" + keyboard2_id).val() + key);
    }

    if (!tesoreria) {
        if (keyboard2_id == 'tpv_efectivo') {
            $("#tpv_tarjeta").val(0);
            $("#tpv_cambio").val(0);
        } else if (keyboard2_id == 'tpv_tarjeta') {
            $("#tpv_efectivo").val(0);
            $("#tpv_cambio").val(0);
        }
    }

    if (keyboard2_id == 'tpv_efectivo') {
        calcular_cambio_efectivo();
    } else if (keyboard2_id == 'tpv_tarjeta') {
        calcular_cambio_tarjeta();
    }
}

function calcular_cambio_efectivo()
{
    var cambio = 0;
    var efectivo = 0;
    if ($("#tpv_efectivo").val() != '') {
        efectivo = parseFloat($("#tpv_efectivo").val());
    }
    var tarjeta = 0;

    if (tesoreria) {
        if ($("#tpv_tarjeta").val() != '') {
            tarjeta = parseFloat($("#tpv_tarjeta").val());
        }

        cambio = efectivo + tarjeta - parseFloat($("#tpv_total2").val());
    } else {
        $("#tpv_tarjeta").val(0);
        cambio = efectivo - parseFloat($("#tpv_total2").val());
    }

    $("#tpv_cambio").val(number_format(parseFloat(cambio), 2, '.', ''));
}

function calcular_cambio_tarjeta()
{
    var cambio = 0;
    var efectivo = 0;
    var tarjeta = 0;
    if ($("#tpv_tarjeta").val() != '') {
        tarjeta = parseFloat($("#tpv_tarjeta").val());
    }

    if (tesoreria) {
        if ($("#tpv_efectivo").val() != '') {
            efectivo = parseFloat($("#tpv_efectivo").val());
        }

        if (efectivo > tarjeta) {
            tarjeta = 0;
            $("#tpv_tarjeta").val(tarjeta);
        }

        if (tarjeta > efectivo + parseFloat($("#tpv_total2").val())) {
            tarjeta = parseFloat($("#tpv_total2").val()) - efectivo;
            $("#tpv_tarjeta").val(tarjeta);
        }

        cambio = efectivo + tarjeta - parseFloat($("#tpv_total2").val());
    } else {
        $("#tpv_efectivo").val(0);
        if (tarjeta > parseFloat($("#tpv_total2").val())) {
            tarjeta = parseFloat($("#tpv_total2").val());
            $("#tpv_tarjeta").val(tarjeta);
        }

        cambio = tarjeta - parseFloat($("#tpv_total2").val());
    }

    $("#tpv_cambio").val(number_format(parseFloat(cambio), 2, '.', ''));
}

function clean_productos_marcaje(){
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'clean_marcaje',
        success: function (datos) {
            $(".block-marcaje").empty();
            $(".block-marcaje").html(datos);
            $("#modal_articulos").modal('hide');
            if (volver_familias) {
                $('#tabs_catalogo a:first').tab('show');
            }
        }
    });
}


function finish_productos_marcaje(){
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'finish_marcaje',
        success: function (datos) {
            $(".block-marcaje").empty();
            $(".block-marcaje").html(datos);
            $("#modal_articulos").modal('hide');
            if (volver_familias) {
                $('#tabs_catalogo a:first').tab('show');
            }
            gridParent = ".grid-marcaje";
            $("#anadir_prod_marcaje").focus();
        }
    });
}

function extractos_modal(fecha) {
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'extractos_modal=&fecha=' + (fecha || ""),
        success: function (datos) {
            $("#modal_extractos").html(datos);
            $("#modal_extractos").modal('show');
        }
    });
}

function ventas_modal() {
    $.ajax({
        type: 'POST',
        url: tpv_url,
        dataType: 'html',
        data: 'ventas_modal',
        success: function (datos) {
            $("#modal_ventas").html(datos);
            $("#modal_ventas").modal('show');
        }
    });
}

$(document).ready(function () {

    var width_codbar_item = $("#b_codbar").width() + parseInt($("#b_codbar").css('padding-right')) + parseInt($("#b_codbar").css('padding-left')) +2;
    var width_prod_marcaje_item = $("#anadir_prod_marcaje").width() + parseInt($("#anadir_prod_marcaje").css('padding-right')) + parseInt($("#anadir_prod_marcaje").css('padding-left')) +2;
    var width_b_articulos_item = $("#b_articulos").width() + parseInt($("#b_articulos").css('padding-right')) + parseInt($("#b_articulos").css('padding-left')) +2;

        
    $("#b_borrar_ticket").click(function () {
        window.location.href = "{$fsc->url()}&delete=" + prompt('Introduce el código del ticket:');
    });

    $("#b_codbar").keypress(function (e) {
        
        if (e.which == 13) {
            e.preventDefault();
            var cod_buscar = $(this).val();
            if($(this).val() != "") {
                $.ajax({
                    type: 'POST',
                    url: tpv_url,
                    dataType: 'json',
                    data: {
                        'cod_buscar': cod_buscar,
                        'direct_view': 'add_ref',
                        'numlineas': getNumLineas(),
                        'codcliente': document.f_tpv.cliente.value,
                    },
                    async: false,
                    success: function (lista) {
                            if (lista.length > 0) {
                                $("#barcod_buscador").remove();
                                for (var i = 0; i < lista.length; i++) {
                                    if (lista[i].codbarras == '') {
                                        lista[i].codbarras = '- - -';
                                    }
                                }
                                if (lista.length > 0) {
                                    var t1 = "<div id='barcod_buscador' class='table-responsive  grid-search-result-barcod' style='border: 1px solid #ddd;position: absolute;z-index: 100;border-top: none;background: white;left: 15px; height: 350px;'><table class='table table-hover' style='margin-bottom: 0;'><thead><tr>" +
                                        "<th class='text-left'>Código</th><th class='text-left'>Referencia</th><th class='text-left'>Artículo</th><th class='text-left'>Precio</th></tr></thead>";
                                    var t2 = "";
                                    for (var i = 0; i < lista.length; i++) {
                                        t2 += "<tr class='barcode_item element-focusable' style='cursor: pointer'><td class='text-left'>" + lista[i].codbarras + "</td><td class='text-left'>" + lista[i].referencia + "</td><td class='text-left'>" + lista[i].descripcion + "</td><td class='text-left'>" + lista[i].precio + "</td></tr>";
                                    }
                                    var t3 = "</table></div>";
                                    $("#b_codbar").parent().parent().append(t1 + t2 + t3);
                                    $("#barcod_buscador").data('open', true);
                                }
                                if (lista.length == 1) {
                                    $("#b_codbar").val(lista[0].referencia);
                                    $("#barcod_buscador").remove();
                                    $("#barcod_buscador").data('open', false);
                                    if ($("#b_codbar").val() == "") {
                                        gridParent = ".table-products";
                                        focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ? $(".element-focusable-parent", gridParent).length - 1 : 0;
                                        focusGrid.currentCell = 2; //Cantidad
                                        changeCurrentGridCell();
                                    } else {
                                        add_referencia(lista[0].referencia, undefined, lista[0].view);
                                        $("#b_codbar").val("");
                                    }
                                } else if(lista.length > 1){
                                    gridParent = ".grid-search-result-barcod";
                                    focusGrid.currentRow = 0;
                                    focusGrid.currentCell = 0;
                                    $("#b_codbar").blur();
                                    changeCurrentGridCell();
                                }
                            } else {
                                bootbox.alert('¡Artículo no encontrado!', function () {
                                    setTimeout(function () {
                                        $("#b_codbar").val('').focus();
                                    }, 500);
                                });
                            }
                    }
                });
            } else {
                gridParent = ".table-products";
                focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ?  0 : 0;
                focusGrid.currentCell = $(".ticket-recovery").length > 0 ? 1 : 2; //Cantidad
                changeCurrentGridCell();
            }
        }
    });

    $("#b_codbar").keydown(function (e) {
        if (e.keyCode == 107) {
            gridParent = ".table-products";
            focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ?  0 : 0;
            focusGrid.currentCell = $(".ticket-recovery").length > 0 ? 2 : 3; //Precio
            changeCurrentGridCell();
            return false;
        }
    });

    $(document).on('keydown', '.price-direct-access-input', function(e) {
        if (e.keyCode == 107 || e.keyCode == 13) {
            e.preventDefault();
            $("#b_codbar").focus();
        }
    });

    $("#b_codbar").keyup(function (e) {
        e.preventDefault();
        $("#barcod_buscador").remove();
        $("#barcod_buscador").data('open', false);
    });

    $(document).on('click', '.barcode_item', function(e) {
        e.preventDefault();
        $("#b_codbar").val($(this).children().first().next().html());
        $("#barcod_buscador").remove();
        $("#barcod_buscador").data('open', false);
        if($("#b_codbar").val() == ""){
            gridParent = ".table-products";
            focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ?  $(".element-focusable-parent", gridParent).length - 1 : 0;
            focusGrid.currentCell = 2; //Cantidad
            changeCurrentGridCell();
        } else {
            add_referencia(document.f_tpv.codbar.value);
            $("#b_codbar").val("");
        }
    });

    $(document).on('keypress', '.only-numbers', function(e) {
        if (e.which != 8 && e.which != 9 && e.which != 45 && e.which != 46 && e.which != 48 && e.which != 49 && e.which != 50 && e.which != 51 && e.which != 52 && e.which != 53 && e.which != 54 && e.which != 55 && e.which != 56 && e.which != 57) {
            e.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '#anadir_prod_marcaje', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            var ref_buscar = $(this).val();
            if($(this).val() != "") {
                $.ajax({
                    type: 'POST',
                    url: tpv_url,
                    dataType: 'json',
                    data: {'cod_buscar': ref_buscar},
                    success: function (lista) {
                        if (lista.length > 0) {
                            $("#prod_marcaje_buscador").remove();
                            for (var i = 0; i < lista.length; i++) {
                                if (lista[i].codbarras == '') {
                                    lista[i].codbarras = '- - -';
                                }
                            }
                            if (lista.length > 0) {
                                var t1 = "<div id='prod_marcaje_buscador' class='table-responsive grid-search-result-marcaje' style='border: 1px solid #ddd;position: absolute; right:15px;z-index: 100;border-top: none;background: white; height: 350px;'><table class='table table-hover' style='margin-bottom: 0;'><thead><tr>" +
                                    "<th class='text-left'>Referencia</th><th class='text-left'>Código</th><th class='text-left'>Artículo</th><th class='text-left'>Precio</th></tr></thead>";
                                var t2 = "";
                                for (var i = 0; i < lista.length; i++) {
                                    t2 += "<tr class='prod_marcaje_item  element-focusable' style='cursor: pointer'><td class='text-left'>"+lista[i].referencia+"</td><td class='text-left'>"+lista[i].codbarras+"</td><td class='text-left'>"+lista[i].descripcion+"</td><td class='text-left'>"+lista[i].precio+"</td></tr>";
                                }
                                var t3 = "</table></div>";
                                $("#anadir_prod_marcaje").parent().append(t1+t2+t3);
                                $("#prod_marcaje_buscador").data('open', true);
                            }
                            if (lista.length == 1) {
                                $("#anadir_prod_marcaje").val(lista[0].referencia);
                                $("#prod_marcaje_buscador").remove();
                                $("#prod_marcaje_buscador").data('open', false);
                                if($("#anadir_prod_marcaje").val() == ""){
                                    gridParent = ".table-products";
                                    focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ?  $(".element-focusable-parent", gridParent).length - 1 : 0;
                                    focusGrid.currentCell = 2; //Cantidad
                                    changeCurrentGridCell();
                                } else {
                                    add_art_ref_marcaje(lista[0].referencia, true);
                                    $("#anadir_prod_marcaje").val("");
                                }
                            } else if(lista.length > 1){
                                gridParent = ".grid-search-result-marcaje";
                                focusGrid.currentRow = 0;
                                focusGrid.currentCell = 0;
                                $("#anadir_prod_marcaje").blur();
                                changeCurrentGridCell();
                            }
                        }
                    }
                });
            }
        }
    });

    $(document).on('click', '.prod_marcaje_item', function(e) {
        e.preventDefault();
        var ref = $(this).children().first().html();
        $("#anadir_prod_marcaje").val(ref);
        $("#prod_marcaje_buscador").remove();
        $("#prod_marcaje_buscador").data('open', false);
        if($("#anadir_prod_marcaje").val() == ""){
            gridParent = ".table-products";
            focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ?  $(".element-focusable-parent", gridParent).length - 1 : 0;
            focusGrid.currentCell = 2; //Cantidad
            changeCurrentGridCell();
        } else {
            add_art_ref_marcaje(ref, true);
            $("#anadir_prod_marcaje").val("");
        }
    });

    $("#anadir_prod_marcaje").keyup(function (e) {
        e.preventDefault();
        $("#prod_marcaje_buscador").remove();
        $("#prod_marcaje_buscador").data('open', false);
    });

    $(document).on('keypress', '#b_articulos', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            var ref_buscar = $(this).val();
            if($(this).val() != "") {
                $.ajax({
                    type: 'POST',
                    url: tpv_url,
                    dataType: 'json',
                    data: {
                        'cod_buscar': ref_buscar,
                        'direct_view': 'cargar_datos_modal_articulo',
                    },
                    async: false,
                    success: function (lista) {
                        for(var i = 0; i<lista.length; i++) {
                            if (lista[i].codbarras == '') {
                                lista[i].codbarras = '- - -';
                            }
                        }
                        if (lista.length > 0) {
                            $("#b_articulos_buscador").remove();
                            if (lista.length > 0) {
                                var t1 = "<div id='b_articulos_buscador' class='table-responsive grid-search-result-catalog' style='border: 1px solid #ddd;position: absolute;z-index: 100;border-top: none;background: white; height: 350px;'><table class='table table-hover' style='margin-bottom: 0;'><thead><tr>" +
                                    "<th class='text-left'>Referencia</th><th class='text-left'>Código</th><th class='text-left'>Artículo</th><th class='text-left'>Precio</th></tr></thead>";
                                var t2 = "";
                                for (var i = 0; i < lista.length; i++) {
                                    t2 += "<tr id='ba_"+i+"' class='b_articulos_item element-focusable' style='cursor: pointer'><td class='text-left'>"+lista[i].referencia+"</td><td class='text-left'>"+lista[i].codbarras+"</td><td class='text-left'>"+lista[i].descripcion+"</td><td class='text-left'>"+lista[i].precio+"</td></tr>";
                                }
                                var t3 = "</table></div>";
                                $("#b_articulos").parent().append(t1+t2+t3);
                                $("#b_articulos_buscador").data('open', true);
                            }
                            $("#ba_0").focus();
                            if (lista.length == 1) {
                                $("#b_articulos").val(lista[0].referencia);
                                $("#b_articulos_buscador").remove();
                                $("#b_articulos_buscador").data('open', false);
                                $("#b_articulos_buscador").remove();
                                $("#b_articulos_buscador").data('open', false);
                               
                                abrir_modal_articulo_mod(lista[0].referencia, ref_buscar, false, lista[0].view);
                                $("#b_articulos").val("");
                            } else if(lista.length > 1){
                                gridParent = ".grid-search-result-catalog";
                                focusGrid.currentRow = 0;
                                focusGrid.currentCell = 0;
                                $("#b_articulos").blur();
                                changeCurrentGridCell();
                            }
                        } else {
                            bootbox.alert('¡Artículo no encontrado!', function () {
                                setTimeout(function () {
                                    $("#b_articulos").val('').focus();
                                }, 500);
                            });
                        }
                    }
                });
            }
        }
    });

    $(document).on('click', '.b_articulos_item', function(e) {
        e.preventDefault();
        var ref_busc = $("#b_articulos").val();
        var ref = $(this).children().first().html();
        $("#b_articulos").val(ref);
        $("#b_articulos_buscador").remove();
        $("#b_articulos_buscador").data('open', false);
    
        abrir_modal_articulo_mod(ref,ref_busc,true);
        $("#b_articulos").val("");
    });
    
     $(document).on('click', '.clickable-row', function(e) {
        e.preventDefault();
        var ref = $(this).closest("tr").find("td.valor_ref").text();
        var ref_busc = $("#ref_buscada").val();
        
        abrir_modal_articulo_mod(ref,ref_busc,true);
         $(this).closest("tr").find("td.valor_ref").val("");
    });

    $("#b_articulos").keyup(function (e) {
        e.preventDefault();
        $("#b_articulos_buscador").remove();
        $("#b_articulos_buscador").data('open', false);
    });

    $("#b_buscar_art").click(function () {
        document.f_buscar_articulos.query.value = "";
        $("#search_results").html("");
        $("input[name=config-marcaje]", "form[name=f_buscar_articulos]").val(0);
        $("#modal_articulos").modal('show');
        document.f_buscar_articulos.query.focus();
    });
    $("#f_buscar_articulos").keyup(function () {
        buscar_articulos();
    });
    $("#f_buscar_articulos").submit(function (event) {
        event.preventDefault();
        buscar_articulos();
    });
    $("#tpv_efectivo").keyup(function (e) {
        calcular_cambio_efectivo();
    });
    $("#tpv_tarjeta").click(function () {

        keyboard2_id = 'tpv_tarjeta';
        if (!tesoreria) {
            $("#tpv_efectivo").val(0);
            $("#tpv_cambio").val(0);
        } else if ($("#tpv_efectivo").val() == '') {
            $("#tpv_efectivo").val(0);
        }
        $("#tpv_tarjeta").val(number_format(parseFloat($("#tpv_total2").val() - parseFloat($("#tpv_efectivo").val())), 2, '.', ''));

        calcular_cambio_tarjeta();
    });
    $("#tpv_tarjeta").keyup(function (e) {
        calcular_cambio_tarjeta();
    });
    $('#tpv_efectivo, #tpv_tarjeta').keypress(function (e) {
        if (e.which == 13) {
            guardar_ticket();
        }
    });

    $(document).on('click', '.btn-configurar-marcaje', function (e) {
        e.preventDefault();
        if($(".row-config-marcaje").is(":visible")){
            $(".row-config-marcaje").hide();
            $(".row-marcaje").show();
            $("#b_derecha").show();
            $("#anadir_prod_marcaje").focus();
        } else {
            $(".row-marcaje").hide();
            $(".row-config-marcaje").show();
            $("#b_derecha").hide();
        }
    });

    $(document).on('click', '.btn-select-articulo-marcaje', function (e) {
        e.preventDefault();
        document.f_buscar_articulos.query.value = "";
        $("#search_results").html("");
        $("input[name=config-marcaje]", "form[name=f_buscar_articulos]").val(1);
        $("input[name=config-marcaje-posicion]", "form[name=f_buscar_articulos]").val($(this).data("posicion"));
        $("#modal_articulos").modal('show');
    });

    $(document).on('click', '.btn-remove-articulo-marcaje', function (e) {
        e.preventDefault();
        var referencia = $(this).data("referencia");
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: 'remove_ref_marcaje=' + referencia,
            success: function (datos) {
                if (datos.indexOf('<!--no_encontrado-->') != -1) {
                    bootbox.alert('¡Artículo no encontrado!');
                } else {
                    $(".block-marcaje").empty();
                    $(".block-marcaje").html(datos);
                }

                $("#modal_articulos").modal('hide');
                if(volver_familias) {
                    $('#tabs_catalogo a:first').tab('show');
                }
            }
        });
    });

    $(document).on('click', '.btn-mover-izquierda', function (e) {
        e.preventDefault();
        var referencia = $(this).data("referencia");
        var posicion = $(this).data("posicion");
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: {'mover_ref_izquierda': referencia, 'posicion_art': posicion},
            success: function (datos) {
                if (datos.indexOf('<!--no_encontrado-->') != -1) {
                    bootbox.alert('¡Artículo no encontrado!');
                } else {
                    $(".block-marcaje").empty();
                    $(".block-marcaje").html(datos);
                }

                $("#modal_articulos").modal('hide');
                if(volver_familias) {
                    $('#tabs_catalogo a:first').tab('show');
                }
            }
        });
    });

    $(document).on('click', '.btn-mover-derecha', function (e) {
        e.preventDefault();
        var referencia = $(this).data("referencia");
        var posicion = $(this).data("posicion");
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: {'mover_ref_derecha': referencia, 'posicion_art': posicion},
            success: function (datos) {
                if (datos.indexOf('<!--no_encontrado-->') != -1) {
                    bootbox.alert('¡Artículo no encontrado!');
                } else {
                    $(".block-marcaje").empty();
                    $(".block-marcaje").html(datos);
                }

                $("#modal_articulos").modal('hide');
                if(volver_familias) {
                    $('#tabs_catalogo a:first').tab('show');
                }
            }
        });
    });

    $(document).on('click', '.btn-add-articulo-marcaje', function (e) {
        e.preventDefault();
        gridParent = ".grid-marcaje";
        var referencia = $(this).data("referencia");
        add_art_ref_marcaje(referencia);
    });


    $(document).on('click', '.btn-subtract-articulo-marcaje', function (e) {
        e.preventDefault();
        var referencia = $(this).data("referencia");
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: 'substract_art_ref_marcaje=' + referencia,
            success: function (datos) {
                if (datos.indexOf('<!--no_encontrado-->') != -1) {
                    bootbox.alert('¡Artículo no encontrado!');
                } else {
                    $(".block-marcaje").empty();
                    $(".block-marcaje").html(datos);
                }

                $("#modal_articulos").modal('hide');
                if(volver_familias) {
                    $('#tabs_catalogo a:first').tab('show');
                }
                changeCurrentGridCell();
            }
        });
    });

    $(document).on('click', '.btn-cerrar-venta-marcaje', function (e) {
        e.preventDefault();
        bootbox.confirm("¿Está seguro que desea <strong>cerrar la venta</strong>?",
            function (result) {
                if(result){
                    $.ajax({
                        type: 'POST',
                        url: tpv_url,
                        dataType: 'html',
                        data: 'close_marcaje' + '&numlineas=' + (getNumLineas()-1),
                        success: function (datos) {
                            if (getNumLineas() == 1) {
                                $("#tpv_albaran").html(datos);
                            } else {
                                $("#tpv_albaran").prepend(datos);
                            }
                            recalcular();
                            finish_productos_marcaje();
                        }
                    });
                    setTimeout(function () {
                        loadKeymap("temporary_board");
                        gridParent = ".grid-marcaje";
                        changeCurrentGridCell();
                        $("#anadir_prod_marcaje").focus();
                    }, 300);

                } else {
                    setTimeout(function () {
                        gridParent = ".grid-marcaje";
                        changeCurrentGridCell();
                        $("#anadir_prod_marcaje").focus();
                    }, 300);
                }
            });
    });


    $(document).on('click', '.btn-limpiar-marcaje', function (e) {
        e.preventDefault();
        bootbox.confirm("¿Está seguro que desea <strong>limpiar el área de marcaje</strong>?",
            function (result) {
                if(result){
                    clean_productos_marcaje();
                    setTimeout(function () {
                        gridParent = ".grid-marcaje";
                        changeCurrentGridCell();
                        $("#anadir_prod_marcaje").focus();
                    }, 300);
                } else {
                    setTimeout(function () {
                        gridParent = ".grid-marcaje";
                        changeCurrentGridCell();
                        $("#anadir_prod_marcaje").focus();
                    }, 300);
                }
            });
    });

    $(document).on('click', '#b_buscar_art_additional_marca', function (e) {
        e.preventDefault();
        document.f_buscar_articulos.query.value = "";
        $("#search_results").html("");
        $("input[name=config-marcaje]", "form[name=f_buscar_articulos]").val(2);
        $("#modal_articulos").modal('show');
    });

    $(document).on('click', '#btn-keymap-clean-sale', function (e) {
        e.preventDefault();
        bootbox.confirm("¿Está seguro que desea <strong>cancelar la venta</strong>?",
            function (result) {
                if(result){
                    clean_cache_lineas();
                    setTimeout(function () {
                        loadKeymap("ticket");
                        $("#b_codbar").focus();
                    }, 300);

                } else {
                    setTimeout(function () {
                        gridParent = ".grid-marcaje";
                        changeCurrentGridCell();
                    }, 300);
                }
            });
    });

    $(document).on('click', '#btn-keymap-abrir-caja', function (e) {
        e.preventDefault();
        location.href = $(this).attr("href");
    });

    $(document).on('click', '#btn-keymap-abrir-solo-caja', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: tpv_url,
            dataType: 'html',
            data: 'page=tpv_tactil&abrir_solo_caja=TRUE'
        });
    });

    $(document).on('click', '#btn-imprimir-extracto', function (e) {
        e.preventDefault();
        location.href = $(this).attr("href");
    });
    
     $(document).on('click', '#btn-imprimir-ventas-familias', function (e) {
        e.preventDefault();
        var checkvalue = [];
        var start_date= $("#datepicker_from").val();
        var end_date= $("#datepicker_to").val();
        
            $.each($("input[name='checkboxVentas']:checked"), function(){            
                checkvalue.push($(this).val());
            });
           
          /* alert($(this).attr("href")+'?familias='+checkvalue+'?desde='+start_date+'?hasta='+end_date);*/
           location.href=$(this).attr("href")+'&familias='+checkvalue+'&desde='+start_date+'&hasta='+end_date;           
    });

    $(document).on('click', '#btn-keymap-print-bill', function (e) {
        e.preventDefault();
        location.href = $(this).attr("href");
    });

    $(document).on('click', '#btn-keymap-save-bill', function (e) {
        e.preventDefault();
        $("form[name=f_factura]").submit();
    });

    $(document).on('click', '#btn-keymap-cart', function (e) {
        $(".element-focusable.focus-active").removeClass("focus-active");
        $("#b_codbar").focus();
    });

    $(document).on('click', '.action-recovery-ticket', function (e) {
        e.preventDefault();
        location.href = $(this).attr("href");
        $("#btn-keymap-cart").trigger("click");
    });

    $(document).on('click', '#btn-keymap-print-last-bill', function (e) {
        e.preventDefault();
        location.href = $(this).attr("href");
    });

    $(document).on('click', '#btn-keymap-cart-history', function (e) {
        e.preventDefault();
        $(this).blur();
        setTimeout(function () {
            gridParent = ".table-cart-history";
            focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ?  $(".element-focusable-parent", gridParent).length - 1 : 0;
            focusGrid.currentCell = 0;
            changeCurrentGridCell();
        }, 200);

    });

    $(document).on('click', '#btn-keymap-familias', function (e) {
        gridParent = ".grid-catalog";
        $("#b_articulos").focus();
    });

    $(document).on('click', '.btn-gestion-stock', function (e) {
        var referencia = $(this).data("referencia")
        window.open("index.php?page=ventas_articulo&ref="+referencia+"#stock");
    });

    $(document).on('hidden.bs.modal', '#modal_articulo_mod', function (e) {
        $("#b_articulos").focus();
        loadKeymap('products');
    })

    $(document).on('show.bs.modal', '#modal_guardar', function (e) {
        $("#tpv_efectivo").focus();
        setTimeout(function () {
            $("#tpv_efectivo").focus();
        }, 100);
    });

    $(document).on('hidden.bs.modal', '#modal_guardar', function (e) {
        var section = $(".section-focusable.section-active").length > 0 ? $(".section-focusable.section-active").data("section") : "";
        switch (section){
            case "products":
                $("#b_codbar").focus();
                break;
            case "ticket":
                $("#b_articulos").focus();
                break;
            case "temporary_board":
                $("#anadir_prod_marcaje").focus();
                break;
            default:
                $("#b_codbar").focus();
                break;
        }
    })

    $(document).on('focus', '.element-focusable', function (e) {
        var $this = $(this);
        if($("#modal_guardar").is(":visible")){
            $(".element-focusable").removeClass("element-focus");
            $this.addClass("element-focus");
            if($this.prop("tagName") == "INPUT"){
                $this.select();
            }
        } else {
            if($this.hasClass("element-edit-mode")){
                if(($this.prop("tagName") == "TEXTAREA" || $this.prop("tagName") == "INPUT") && $this.prop("type") != "checkbox"){
                    $this[0].selectionStart = $this[0].selectionEnd = $this.val().length;
                }
            } else {
                $this.select();
                if (gridParent != ".grid-articles") {
                    if ($(this).attr('id') != "b_articulos" && $(this).attr('id') != "b_codbar" && $(this).attr('id') != "anadir_prod_marcaje") {
                        $(".element-focusable").removeClass("element-edit-mode");
                        $this.addClass("element-nav-mode");
                        $(".element-focusable").removeClass("element-focus");
                        $this.addClass("element-focus");
                    } else if ($(this).attr('id') == "b_articulos" && $(this).val() == "") {
                        $(".element-focusable").removeClass("element-focus");
                        $this.addClass("element-focus");
                    }
                }
            }
        }


    });

    $(document).on('focus', '#b_codbar', function (e) {
        if ($("#b_codbar").get(0).setSelectionRange) {
            var len = $("#b_codbar").val().length * 2;
            setTimeout(function() {
                $("#b_codbar").get(0).setSelectionRange(len, len);
            }, 1);

        } else {
            $("#b_codbar").val($("#b_codbar").val());

        }
        this.scrollTop = 999999;
    });

    $(document).on('focus', '#b_articulos', function (e) {
        if ($("#b_articulos").get(0).setSelectionRange) {
            var len = $("#b_articulos").val().length * 2;
            setTimeout(function() {
                $("#b_articulos").get(0).setSelectionRange(len, len);
            }, 1);

        } else {
            $("#b_articulos").val($("#b_articulos").val());

        }
        this.scrollTop = 999999;
    });

    $(document).on('focus', '#anadir_prod_marcaje', function (e) {
        $("#prod_marcaje_buscador").remove();
        if ($("#anadir_prod_marcaje").get(0).setSelectionRange) {
            var len = $("#anadir_prod_marcaje").val().length * 2;
            setTimeout(function() {
                $("#anadir_prod_marcaje").get(0).setSelectionRange(len, len);
            }, 1);

        } else {
            $("#anadir_prod_marcaje").val($("#anadir_prod_marcaje").val());

        }
        this.scrollTop = 999999;
    });

    $(document).on('blur', '.only-numbers', function (e) {
        if ($(this).val() == "") {
            $(this).val(0);
            set_pvpi(this);
        }
    });

    $(document).on('click', '.section-focusable', function (e) {
        var section = $(this).data("section");
        if(section != "" && section != keymapActive){
            loadKeymap(section);
        }
    });

    $(document).on('click', '.element-focusable', function (e) {
        var $this = $(this);
        if($this.prop("type") != "checkbox"){
            if(gridParent == ".table-products"){
                $(".badge-delete-line").remove();
                $(".btn-delete-line").removeClass("btn-delete-line-focus");
            }
            focusGrid.maxCell = $(".element-focusable", $this.closest(".element-focusable-parent")).length - 1;
            focusGrid.currentCell = $(".element-focusable", $this.closest(".element-focusable-parent")).index(this);
            focusGrid.maxRow = $(".element-focusable-parent", gridParent).length - 1;
            focusGrid.currentRow = $(".element-focusable-parent", $(gridParent)).index($this.closest(".element-focusable-parent"));
            changeCurrentGridCell();
            $this.removeClass("element-nav-mode");
            if(gridParent != ".grid-articulos"){
                $this.addClass("element-edit-mode");
            }
            window.getSelection().removeAllRanges();
            $this.focus();
            if($this.hasClass("element-keep-focus-click")){
                setTimeout(function () {
                    changeCurrentGridCell();
                }, 2000);
            }
        }

    });

    $(document).on('blur', '.element-focusable', function (e) {
        $(this).removeClass("element-edit-mode");
        $(".badge-delete-line").remove();
        $(".btn-delete-line").removeClass("btn-delete-line-focus");
    });


    $(document).on('click', 'body', function (e) {
        if (e.originalEvent !== undefined) {
            if(gridParent != ""){
                $(".element-focusable.focus-active", gridParent).removeClass("focus-active");
            }
        }
    });

    $(document).on('click', 'html', function (e) {
        if($("#prod_marcaje_buscador").data('open')) {
            $("#prod_marcaje_buscador").remove();
        }
        if ($("#b_articulos_buscador").data('open')) {
            $("#b_articulos_buscador").remove();
        }
        if ($("#barcod_buscador").data('open')) {
            $("#barcod_buscador").remove();
        }
    });

    $(document).on('keypress', '.element-focusable.element-nav-mode', function (e) {
        if(e.keyCode == 13){
            if($(this).prop("type") == "checkbox"){
                $(this).prop("checked", !$(this).prop("checked"));
            } else {
                if ($(this).hasClass("element-on-edit-input-search") /*&& focusGrid.currentRow == focusGrid.minRow*/) {
                    $("#b_codbar").focus();
                } else {
                    $(this).removeClass("element-nav-mode");
                    if(gridParent != ".grid-articulos"){
                        $(this).addClass("element-edit-mode");
                        if ($(this).attr('id') == "b_articulos" && $(this).val() == "") {
                            gridParent = ".grid-catalog";
                            focusGrid.currentRow = 0;
                            focusGrid.currentCell = 0;
                            changeCurrentGridCell();
                            return false;
                        }
                    }
                    window.getSelection().removeAllRanges();
                    $(this).focus();
                }
            }
        } else {
            $(this).removeClass("element-nav-mode");
            if(gridParent != ".grid-articulos"){
                $(this).addClass("element-edit-mode");
            }
        }
    });

    $(document).on('keypress', '.element-focusable.element-edit-mode', function (e) {
        if (e.keyCode == 13) {
            if ($(this).hasClass("element-on-edit-input-search") /*&& focusGrid.currentRow == focusGrid.minRow*/) {
                $("#b_codbar").focus();
            } else {
                if ($(this).attr('id') != "b_codbar" && $(this).attr('id') != "b_articulos" && $(this).attr('id') != "anadir_prod_marcaje") {
                    $(this).removeClass("element-edit-mode");
                    $(this).addClass("element-nav-mode");
                    $(this).focus();
                }
            }
        }
    });

    $(document).on('keydown', 'body', function (e) {
        if($("#b_articulos_buscador").is(":visible") && e.keyCode == 27){
            $("#b_articulos").focus();
        } else if($("#barcod_buscador").is(":visible") && e.keyCode == 27){
            $("#b_codbar").focus();
        } else if($("#prod_marcaje_buscador").is(":visible") && e.keyCode == 27){
            $("#anadir_prod_marcaje").focus();
        }

        if(typeof keymapSections[e.keyCode] !== "undefined" && keymapSections[e.keyCode] != ""){
            e.preventDefault();
            e.returnValue = false;
        }
        if(typeof keymap[keymapActive] !== "undefined" && typeof keymap[keymapActive][e.keyCode] !== "undefined" && keymap[keymapActive][e.keyCode] != ""){
            e.preventDefault();
            e.returnValue = false;
            return false;
        }
    });
    $(document).on('keyup', 'body', function (e) {
        if(typeof keymapSections[e.keyCode] !== "undefined" && keymapSections[e.keyCode] != ""){
            e.preventDefault();
            loadKeymap(keymapSections[e.keyCode]);
            return false;
        }
        if(typeof keymap[keymapActive] !== "undefined" && typeof keymap[keymapActive][e.keyCode] !== "undefined" && keymap[keymapActive][e.keyCode] != ""){
            e.preventDefault();
            $("#"+keymap[keymapActive][e.keyCode]).click();
            return false;
        }
    })

    var map = {16: false, 9: false, 35:false};
    $(document).keydown(function(e) {
        if (!$("#modal_articulo_mod").is(":visible") && !$("#modal_guardar").is(":visible")) {

            if (e.keyCode in map) {
                map[e.keyCode] = true;
                if (map[16] && map[9]) { //SHIFT+TAB
                    // FIRE EVENT
                    if ($(".element-edit-mode", gridParent).length > 0 || $("a.element-focus").length > 0 || $("button.element-focus").length > 0) {
                        if (focusGrid.currentCell > 0) {
                            focusGrid.currentCell--;
                            changeCurrentGridCell();
                        } else if (focusGrid.currentRow > 0) {
                            focusGrid.currentRow--;
                            changeCurrentGridCell();
                        }
                    } else if (typeof keymap[keymapActive] !== "undefined" && typeof keymap[keymapActive]["SHIFT+TAB"] !== "undefined" && keymap[keymapActive]["SHIFT+TAB"] != "") {
                        e.preventDefault();
                        $("#" + keymap[keymapActive]["SHIFT+TAB"]).click();
                    }
                    return false;
                } else if (map[16] && map[35]) { //SHIFT+FIN
                    if (typeof keymap[keymapActive] !== "undefined" && typeof keymap[keymapActive]["SHIFT+FIN"] !== "undefined" && keymap[keymapActive]["SHIFT+FIN"] != "") {
                        e.preventDefault();
                        $("#" + keymap[keymapActive]["SHIFT+FIN"]).click();
                    }
                    return false;
                }
            }

            if (e.keyCode == 13 && $(".element-focusable.focus-active").length == 1) {
                e.preventDefault();
                $(".element-focusable.focus-active").click();
                $(".element-focusable.focus-active").removeClass("focus-active");
                return false;
            }

            //F4 elimina la línea que tenga el foco
            if (e.keyCode == 115 && $(".btn-delete-line-focus").length > 0) {
                $(".btn-delete-line-focus").click();
                return false;
            }

            //Supr resta artículo de marcaje que tenga el foco
            if (e.keyCode == 46 && $(".btn-subtract-line-focus").length > 0) {
                $(".btn-subtract-line-focus").click();
                return false;
            }

            //Controlar botón tab para moverse por el grid
            if (e.keyCode == 9) {
                if ($(".element-edit-mode", gridParent).length > 0 || $("a.element-focus").length > 0 || $("button.element-focus").length > 0) {
                    if (focusGrid.currentCell < focusGrid.maxCell) {
                        focusGrid.currentCell++;
                        changeCurrentGridCell();
                    } else if (focusGrid.currentRow < focusGrid.maxRow) {
                        focusGrid.currentRow++;
                        focusGrid.currentCell = 1;
                        changeCurrentGridCell();
                    }

                }
                return false;
            }

            if (e.keyCode == 27 && gridParent == ".grid-catalog") {
                focusGrid.currentRow = 0;
                var oldVal = $("#b_articulos").val();
                $("#b_articulos").focus().val('').val(oldVal);
            }

            //Controlamos las flechas para movernos por grid activo

            if ($(":focus") && $(":focus").attr('id') == "b_codbar") {
                if (e.keyCode == 38) {
                    gridParent = ".table-products";
                    focusGrid.currentRow = $(".element-focusable-parent", gridParent).length > 0 ? $(".element-focusable-parent", gridParent).length - 1 : 0;
                    focusGrid.currentCell = 1;
                    changeCurrentGridCell();
                    return false;
                } else if (e.keyCode == 40) {
                    gridParent = ".table-products";
                    focusGrid.currentRow = 0;
                    focusGrid.currentCell = 1;
                    changeCurrentGridCell();
                    return false;
                }
            }

            if ($(":focus") && $(":focus").attr('id') == "anadir_prod_marcaje") {
                if (e.keyCode == 38) {
                    return false;
                } else if (e.keyCode == 40) {
                    gridParent = ".grid-marcaje";
                    focusGrid.currentRow = 0;
                    focusGrid.currentCell = 0;
                    changeCurrentGridCell();
                    return false;
                }
            }

            if ($(":focus") && $(":focus").attr('id') == "b_articulos") {
                if (e.keyCode == 38) {
                    return false;
                } else if (e.keyCode == 40) {
                    gridParent = ".grid-catalog";
                    focusGrid.currentRow = 0;
                    focusGrid.currentCell = 0;
                    changeCurrentGridCell();
                    return false;
                }
            }

            if (e.keyCode == 37 && $(".element-edit-mode").length == 0) {
                if (!$("#b_codbar").is(":focus") && !$("#b_articulos").is(":focus") && !$("#anadir_prod_marcaje").is(":focus")) {
                    if (focusGrid.currentCell > 0) {
                        focusGrid.currentCell--;
                        changeCurrentGridCell();
                        return false;
                    }
                }
            } else if (e.keyCode == 38) {
                if (focusGrid.currentRow > 0) {
                    focusGrid.currentRow--;
                    changeCurrentGridCell();
                    return false;
                } else if (gridParent == ".table-products" && focusGrid.currentRow == 0) {
                    $("#b_codbar").focus();
                } else if (gridParent == ".grid-marcaje" && focusGrid.currentRow == 0) {
                    $("#anadir_prod_marcaje").focus();
                } else if (gridParent == ".grid-catalog" && focusGrid.currentRow == 0) {
                    $("#b_articulos").focus();
                }
            } else if (e.keyCode == 39 && $(".element-edit-mode").length == 0) {
                if (!$("#b_codbar").is(":focus") && !$("#b_articulos").is(":focus") && !$("#anadir_prod_marcaje").is(":focus")) {
                    if (focusGrid.currentCell < focusGrid.maxCell) {
                        focusGrid.currentCell++;
                        changeCurrentGridCell();
                        return false;
                    }
                }
            } else if (e.keyCode == 40) {
                if (focusGrid.currentRow < focusGrid.maxRow) {
                    focusGrid.currentRow++;
                    changeCurrentGridCell();
                    return false;
                } else if (gridParent == ".table-products" && focusGrid.currentRow == focusGrid.maxRow) {
                    $("#b_codbar").focus();
                }
            }
        }
    }).keyup(function(e) {
        if (e.keyCode in map) {
            map[e.keyCode] = false;
        }
    });

    loadKeymapSections();
    loadKeymap('ticket');

    /// comprobamos si el navegador soporta localstorage
    if (typeof (Storage) !== "undefined" && usar_cache) {
        lineas_cache = localStorage.getItem("tpv_tactil_lineas");
        if (typeof (lineas_cache) == "string") {
            if (lineas_cache.length > 4) {
                $("#tpv_albaran").html(lineas_cache);
            } else {
                localStorage.removeItem("tpv_tactil_lineas");
            }
        }
    }
});

$(window).resize(function () {
    var width_codbar_item = $("#b_codbar").width() + parseInt($("#b_codbar").css('padding-right')) + parseInt($("#b_codbar").css('padding-left')) + 1;
    var width_prod_marcaje_item = $("#anadir_prod_marcaje").width() + parseInt($("#anadir_prod_marcaje").css('padding-right')) + parseInt($("#anadir_prod_marcaje").css('padding-left')) + 1;
    var width_b_articulos_item = $("#b_articulos").width() + parseInt($("#b_articulos").css('padding-right')) + parseInt($("#b_articulos").css('padding-left'));
});
