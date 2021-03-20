/* 
 *  SCRIPTS para KAIZEN.
 *  
 *	Las funciones dentro del script están ordenadas alfabáticamente:  
 *    
 */

/** ****************** A ************************* */
function autorizarUnidad(tiene_permiso) {
    if (tiene_permiso) {
        /* Primero chequeo que no está autorizada */
        var autUnidad = new Ajax(
            '{WEB_PATH}common/ajax/Ajax_cargarLocalidades.php', {
                method : 'get',
                data : $('editarcliente'),
                update : 'loc',
                onComplete : function() {
                    exValidatorA.initialize('editarcliente',
                        exValidatorA.options);
                }
            });
        autUnidad.request();
    }
}

/** ****************** B ************************* */

function buscarProducto(url, script, ds_name, cd_id) {
    var dialogOpts = {
        title : "Buscar Producto",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        buttons : {
            "Seleccionar" : function() {
                jQuery('#ui-dialog').dialog("destroy");
                radio = jQuery('#buscar input:radio:checked');
                valor = radio.val();
                if (valor != undefined) {
                    arrayTexto = valor.split("||");
                    document.getElementById(cd_id).value = arrayTexto[0];
                    document.getElementById(cd_id).focus();
                    if (script != "") {
                        eval(script);
                    }
                }
            }
        },
        height : 400,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function jQuery_confirm(msj) {
    var dialogOpts = {
        title : "",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        buttons : {
            "Si" : function() {
                return true;
            },
            "No" : function() {
                return false;
            }
        },
        height : 200,
        width : 300,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}



function buscarProductoenUnidades(url, script) {
    ds_name = "ds_producto";
    cd_id = "cd_producto";
    buscarProducto(url, script, ds_name, cd_id);
}



function editarCliente(url, title, ds_name, cd_id) {
    var dialogOpts = {
        title : title,
        modal : true,
        autoOpen : false,
        bgiframe : true,
        buttons : {
            "Confirmar" : function() {
                datosCliente();
                jQuery('#ui-dialog').dialog("destroy");

            }
        },
        height : 550,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

/** ****************** C ************************* */

/**
 * diálogo de confirmación.
 * 
 * @param cartel -
 *            mensaje de confirmación.
 * @param a -
 *            tag a html al cual se le setea el link en caso de confirmación.
 * @param hred -
 *            link en caso de confirmación.
 */
function confirmaEliminar(cartel, a, href) {
    jConfirm(cartel, 'Confirmación', function(r) {
        if (r) {
            a.href = href;
            window.location = href;
            return true;
        } else {
            return false;
        }
    });
}

function confirmarCreditos(tiene_permiso, consulta_autorizar, f, validator) {
    cartel = "Tiene datos sin guardar en los créditos. Desea registrar la venta de todas formas?";
    jConfirm(cartel, 'Confirmación', function(r) {
        if (r) {
            validarMontos(tiene_permiso, consulta_autorizar, f, validator);
        } else {
            return false;
        }
    });

}
/** ****************** D ************************* */
function deshabilitarNuMotor() {
    document.getElementById('nu_motor').className = "";
    document.getElementById('nu_cuadro').style['border-color'] = "none";
    document.getElementById('nu_cuadro').style['background-color'] = "none";
    document.getElementById('nu_motor').disabled = true;
    if (document.getElementById('nu_motorrequired_msg') != null) {
        document.getElementById('nu_motorrequired_msg').innerHTML = "";
    }
    exValidatorA.initialize('altaunidadmovimiento', exValidatorA.options);
}

function deshabilitarNuCuadro() {
    document.getElementById('nu_cuadro').className = "";
    document.getElementById('nu_cuadro').style['border-color'] = "none";
    document.getElementById('nu_cuadro').style['background-color'] = "none";
    document.getElementById('nu_cuadro').disabled = true;
    if (document.getElementById('nu_cuadrorequired_msg') != null) {
        document.getElementById('nu_cuadrorequired_msg').innerHTML = "";
    }
    exValidatorA.initialize('altaunidadmovimiento', exValidatorA.options);
}

/** ****************** E ************************* */

/**
 * se evalúa la función "onComplete" en el opener
 * 
 * @param onComplete
 *            función a evaluar en el opener.
 * @return
 */
function evaluar(onComplete) {
    if (onComplete != null && onComplete != '')
        window.opener.eval(onComplete);
}

/**
 * se muestra la imagen de espera en el element html dado
 * 
 * @param elementId
 *            id del elemento html donde se mostrará la imagen de espera.
 * @return
 */
function esperar(elementId) {
    document.getElementById(elementId).innerHTML = "<center><img src='../img/ajax-loader.gif' title='cargando...' alt='cargando...' /> </center>";
}

/** ****************** G ************************* */

/** ****************** H ************************* */

/** ****************** L ************************* */

/**
 * función para listar todos los elementos en un listado.
 */
function listar_todos_productos() {
    formu = document.getElementById('sub_stock').checked = false;
}

function listartodos() {
    formu = document.getElementById('validar').value = "false";
    document.getElementById('campoFiltro').selectedIndex = 0;
    document.getElementById('filtro').value = "";
}

function listar_todos_ventas() {
    document.getElementById('cd_sucursal').selectedIndex = 0;
    document.getElementById('cd_usuario').selectedIndex = 0;
    document.getElementById('cd_cliente').selectedIndex = 0;
    document.getElementById('dt_desde').value = "";
    document.getElementById('dt_hasta').value = "";
}
/**
 * función para listar todos los elementos en un listado.
 */
function listar_todos(action) {
    document.getElementById('validar').value = "false";
    document.getElementById('campoFiltro').selectedIndex = 0;
    document.getElementById('filtro').value = "";
    if (action == 'listar_movimientos') {
        document.getElementById('cd_usuario').selectedIndex = 0;
    }
    if (action == 'listar_ventas') {
        listar_todos_ventas();
    }
    if (action == 'listar_productos') {
        listar_todos_productos();
    }
    submit_self(action);
}

function listar_todas_unidades(action, formName) {
    document.getElementById('validar').value = "false";
    document.getElementById('campoFiltro').selectedIndex = 0;
    document.getElementById('cd_producto').selectedIndex = 0;
    document.getElementById('filtro').value = "";
    if (document.getElementById('autorizada') != undefined) {
        document.getElementById('autorizada').checked = false;
    }
    if (document.getElementById('sinautorizar') != undefined) {
        document.getElementById('sinautorizar').checked = false;
    }
    submit_self(action, formName);
}

/** ****************** M ************************* */

/**
 * mensaje de error formateado con jQuery
 * 
 * @param mensaje -
 *            mensaje de error a mostrar
 */
function mensajeError(mensaje) {
    jAlert("<strong>Error</strong><br/><br/><br/>" + mensaje);
}

/**
 * mensaje de error formateado con jQuery.
 * 
 * @param mensaje -
 *            mensaje de error a mostrar
 */
function mensajeErrorEliminar(mensaje) {
    jAlert("<strong>Eliminar</strong><br/><br/><br/>" + mensaje);
}

function moverUnidad(url) {
    var dialogOpts = {
        title : "Mover Unidad",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        buttons : {
            "Mover" : function() {
                if (document.altamovimiento.submit()) {
                    window.parent.location.refresh();
                    jQuery('#ui-dialog').dialog("destroy");
                }
            }
        },
        height : 400,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");

}

/** ****************** P ************************* */

/**
 * pop up estándar de 750x500
 * 
 * @param a -
 *            tag a html con el link para abrir el popup
 */
function popUp(a) {
    window.open(a.href, a.target,
        'width=750,height=500, ,location=center, scrollbars=YES');
    return false;
}

/**
 * pop up grande de 1024x500
 * 
 * @param a -
 *            tag a html con el link para abrir el popup
 */
function popUpGrande(a) {
    window.open(a.href, a.target,
        'width=1024,height=500, ,location=center, scrollbars=YES');
    return false;

}
/** ****************** S ************************* */

/*
 * Las siguientes funciones "seleccionarXYZ" son invocadas desde los popups de
 * selección de entidades. Se utilizan para llenar los inputs del opener con
 * la información del elemento seleccionado.
 */

/**
 * función llamada en el popup de "seleccionar un contratista". Notar que el
 * opener debe tener los siguientes inputs: - cd_contratista - ds_nombre
 * 
 * @param cd_trabajadorObra
 *            identificador del contratista
 * @param ds_nombre
 *            nombre del contratista
 * @param onComplete
 *            función a evaluar una vez seleccionado el contratista.
 * 
 */
function seleccionarContratista(cd_trabajadorObra, ds_nombre, onComplete) {

    setearInput(window.opener.document.getElementById('cd_contratista'),
        cd_trabajadorObra);
    setearInput(window.opener.document.getElementById('ds_nombre'), ds_nombre);

    evaluar(onComplete);

    window.close();
}

/**
 * función llamada en el popup de "seleccionar un cuadrilla". Notar que el
 * opener debe tener los siguientes inputs: - cd_cuadrilla - ds_responsable -
 * nu_numero
 * 
 * @param cd_trabajadorObra
 *            identificador de la cuadrilla
 * @param ds_responsable
 *            responsable de la cuadrilla
 * @param nu_numero
 *            número de cuadrilla
 * @param onComplete
 *            función a evaluar una vez seleccionada la cuadrilla.
 * 
 */
function seleccionarCuadrilla(cd_trabajadorObra, ds_responsable, nu_numero,
    onComplete) {
    setearInput(window.opener.document.getElementById('cd_cuadrilla'),
        cd_trabajadorObra);
    setearInput(window.opener.document.getElementById('ds_responsable'),
        ds_responsable);
    setearInput(window.opener.document.getElementById('nu_numero'), nu_numero);
    evaluar(onComplete);
    window.close();
}

/**
 * función llamada en el popup de "seleccionar una obra". Notar que el opener
 * debe tener los siguientes inputs: - cd_obra - ds_obra
 * 
 * @param cd_obra
 *            identificador de la obra
 * @param ds_obra
 *            descripción de la obra
 * @param onComplete
 *            función a evaluar una vez seleccionada la obra.
 */
function seleccionarObra(cd_obra, ds_obra, onComplete) {
    setearInput(window.opener.document.getElementById('cd_obra'), cd_obra, 1);
    setearInput(window.opener.document.getElementById('ds_obra'), ds_obra);
    evaluar(onComplete);
    window.close();
}

/**
 * función llamada en el popup de "seleccionar un producto". Notar que el
 * opener debe tener los siguientes inputs: - ds_numero - cd_producto -
 * cd_productoSelected - cd_tipoProducto - ds_producto
 * 
 * @param cd_producto
 *            identificador del producto
 * @param ds_numero
 *            número de producto
 * @param ds_producto
 *            descripción del producto
 * @param ds_cantidad
 *            descripción de la cantidad del producto
 * @param cd_tipoProducto
 *            identificar del tipo de producto asociado al producto
 * @param nu_cantidad
 *            cantidad del producto
 * @param onComplete
 *            función a evaluar una vez seleccionado el producto.
 */
function seleccionarProducto(cd_producto, ds_numero, ds_producto, ds_cantidad,
    cd_tipoProducto, nu_cantidad, onComplete) {

    setearInput(window.opener.document.getElementById('ds_numero'), ds_numero);
    setearInput(window.opener.document.getElementById('cd_producto'),
        cd_producto);
    setearInput(window.opener.document.getElementById('codigo'), cd_producto);
    setearInput(window.opener.document.getElementById('cd_productoSelected'),
        cd_producto);
    setearInput(window.opener.document.getElementById('cd_tipoProducto'),
        cd_tipoProducto);
    setearInput(window.opener.document.getElementById('ds_producto'),
        ds_producto);

    input = window.opener.document.getElementById('cantidad');
    if (input != null)
        input.innerHTML = 'Cantidad disponible: ' + ds_cantidad;

    setearInput(window.opener.document.getElementById('nu_cantidad'),
        nu_cantidad);
    setearInput(window.opener.document.getElementById('nu_cantidadRetirar'),
        nu_cantidad);
    evaluar(onComplete);
    window.close();
}

/**
 * función llamada en el popup de "seleccionar un producto" cuando se invoca
 * indicando que el opener se encargará de mostrar la información del
 * producto seleccionado. Notar que el opener debe definir la función
 * setearProducto(...).
 * 
 * @param cd_producto
 *            identificador del producto
 * @param ds_numero
 *            número de producto
 * @param ds_producto
 *            descripción del producto
 * @param ds_cantidad
 *            descripción de la cantidad del producto
 * @param cd_tipoProducto
 *            identificar del tipo de producto asociado al producto
 * @param nu_cantidad
 *            cantidad del producto
 * @param onComplete
 *            función a evaluar una vez seleccionado el producto.
 */
function seleccionarProductoEnOpener(cd_producto, ds_numero, ds_producto,
    ds_cantidad, cd_tipoProducto, nu_cantidad, onComplete) {

    window.opener.setearProducto(cd_producto, ds_numero, ds_producto,
        ds_cantidad, cd_tipoProducto, nu_cantidad);
    evaluar(onComplete);
    window.close();
}

/**
 * función llamada en el popup de "seleccionar un tipo de producto". Notar que
 * el opener debe tener los siguientes inputs: - cd_tipoProducto - ds_codigoSAP -
 * ds_tipoProducto - ds_unidadMedida
 * 
 * @param cd_tipoProducto
 *            identificar del tipo de producto
 * @param ds_codigoSAP
 *            código sap del tipo de producto
 * @param ds_tipoProducto
 *            descripción del tipo de producto
 * @param ds_unidadMedida
 *            descripción de la unidad de medida del tipo de producto
 * @param onComplete
 *            función a evaluar una vez seleccionado el tipo de producto.
 */
function seleccionarTipoProducto(cd_tipoProducto, ds_codigoSAP,
    ds_tipoProducto, ds_unidadMedida, onComplete) {
    setearInput(window.opener.document.getElementById('cd_tipoProducto'),
        cd_tipoProducto);
    setearInput(window.opener.document.getElementById('ds_codigoSAP'),
        ds_codigoSAP, 1);
    setearInput(window.opener.document.getElementById('ds_tipoProducto'),
        ds_tipoProducto + ' - (' + ds_unidadMedida + ')');
    evaluar(onComplete);
    window.close();
}

/**
 * setea el valor a un input
 * 
 * @param input
 *            input a setear el valor
 * @param value
 *            valor a setear
 * @param setFocus
 *            si pasamos 1, le da el foco al input.
 * @return
 */
function setearInput(input, value, setFocus) {
    if (input != null) {
        input.value = value;
        if (setFocus == 1) {
            input.focus();
        }
    }
}

function submit_self(accion, formName) {
    if (formName == 'undefined' || formName == null)
        formName = 'buscar';
    var form = document.forms[formName];
    form.accion.value = accion;
    form.target = '_self';
    form.submit();
}

function submit_blank(accion, formName) {
    if (formName == 'undefined' || formName == null)
        formName = 'buscar';

    var form = document.forms[formName];
    input = document.getElementById('validar');
    if (input != null)
        input.value = "false";
    form.accion.value = accion;
    form.target = '_blank';
    form.submit();
}

/** ****************** V ************************* */
function validarItems(tiene_permiso, consulta_autorizar, f, validator){
	document.getElementById("btnAceptarVenta").value = "Enviando...";
	document.getElementById('btnAceptarVenta').disabled=true;
	validator.initialize('altaventa', validator.options);
    rta = validator._validateAll();
    if (rta) {
    	f.btnAceptarVenta.disabled = true;
    	cantidad_items = document.getElementById('count').value;
        if (parseInt(cantidad_items) <= 0) {
        	document.getElementById("btnAceptarVenta").value = "Registrar Venta";
        	document.getElementById('btnAceptarVenta').disabled=false;
            jAlert("Se debe ingresar al menos un pago para registrar la venta.");
        }else{
        	cd_cliente = document.getElementById('cd_cliente').value;
        	
        	
        	if((!cd_cliente)||(cd_cliente==0)){
        		document.getElementById("btnAceptarVenta").value = "Registrar Venta";
            	document.getElementById('btnAceptarVenta').disabled=false;
        		jAlert("Debe cargar el cliente, recuerde que si el cliente es nuevo debe guardar los datos antes de presionar Confirmar.");
        	}
        	else{
        		
        		validarAgregarItem(tiene_permiso, consulta_autorizar, f, validator);
        	}
            
            
        }
    }
    else{
    	document.getElementById("btnAceptarVenta").value = "Registrar Venta";
    	document.getElementById('btnAceptarVenta').disabled=false;
    }
}


function validarAgregarItem(tiene_permiso, consulta_autorizar, f, validator) {
    var value_entidad = "";
    var value_nuimporte = "";
    var value_detalle = "";
    if (document.getElementById('cd_entidad') != null) {
        value_entidad = document.getElementById('cd_entidad').value;
    }
    if (document.getElementById('nu_importe') != null) {
        value_nuimporte = document.getElementById('nu_importe').value;
    }
    if (document.getElementById('ds_detalle') != null) {
        value_detalle = document.getElementById('ds_detalle').value;
    }
    if (value_entidad != "" || value_nuimporte != "" || value_detalle != "") {
    	f.btnAceptarVenta.disabled = false;
        confirmarCreditos(tiene_permiso, consulta_autorizar, f, validator);
    } else {
        validarMontos(tiene_permiso, consulta_autorizar, f,
            validator);
    }

}

function validarMontos(tiene_permiso, consulta_autorizar, formulario, validator) {
    if (document.getElementById('nu_importetotal') != null) {
        importe_total = document.getElementById('nu_importetotal').value;
    } else {
        importe_total = 0;
    }

    if (document.getElementById('nu_montosugerido') != null) {
        nu_montosugerido = document.getElementById('nu_montosugerido').value;
    } else {
        nu_montosugerido = 0;
    }
    if (parseInt(importe_total) < parseInt(nu_montosugerido)) {
    	formulario.btnAceptarVenta.disabled = false;
        jAlert("El importe total, debe superar el monto sugerido");
    } else {
        if (consulta_autorizar == '1') {
        	formulario.btnAceptarVenta.disabled = false;
            autorizarUnidadActual(tiene_permiso, consulta_autorizar,
                formulario, validator);
        } else {
            validator.initialize('altaventa', validator.options);
            rta = validator._validateAll();
            if (rta) {
                formulario.submit();
            }
        }
    }

}
function autorizarUnidadActual(tiene_permiso, consulta_autorizar, formulario, validator) {
    jConfirm(
        "Desea autorizar la unidad a vender?",
        "Confirmaci&oacute;n",
        function(r) {
            if (r) {
                jConfirm(
                    "Confirma que desea autorizar la unidad a vender?",
                    "Confirmación",
                    function(rec) {
                        if (rec) {
                            if (document.getElementById('bl_autorizar') != undefined)
                                document.getElementById('bl_autorizar').value = "1";
                            validator.initialize('altaventa',
                                validator.options);
                            rta = validator._validateAll();
                            if (rta) {
                                formulario.submit();
                            }
                        } else {
                            validator.initialize('altaventa',
                                validator.options);
                            rta = validator._validateAll();
                            if (rta) {
                                formulario.submit();
                            }
                        }
                    });
            } else {
                validator.initialize('altaventa', validator.options);
                rta = validator._validateAll();
                if (rta) {
                    formulario.submit();
                }
            }
        });

}

/**
 * se verifica si se ingresó un criterio de búsqueda en las ventas de
 * listados.
 */
function verificarFiltro() {
    if (document.getElementById('filtro').value == "") {
        if (document.getElementById('validar').value == "true") {
            jAlert("Se debe ingresar un criterio de b&uacute;queda");
            return false;
        }
    }
    return true;
}
