<?php

/**
 * Acción para inicializar el contexto para modificar
 * una venta.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ModificarVentaInitAction extends EditarVentaInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Venta";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Venta";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_venta";
	}

	protected function parseEntidad($entidad, XTemplate $xtpl) {				
		$oVenta = FormatUtils::ifEmpty($entidad, new Venta());				
		$oItempagoManager = new ItempagoManager();
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro("cd_venta", $oVenta->getCd_venta(), "=");
		$itemspagos = $oItempagoManager->getItemspago($criterio);
		$this->parsePagos($xtpl, $itemspagos, $oVenta);
		//se muestra el Movimiento.
		$xtpl->assign('url_altacliente', WEB_PATH . 'clientes/doAction?action=alta_cliente_min_init');
		$xtpl->assign('url_editarcliente', WEB_PATH . 'clientes/doAction?action=modificar_cliente_min_init&id=');
		if($this->tienePermisoFuncion(MODIFICAR_PAGO_ACCION)){
			$xtpl->assign('tiene_permiso', 1);
		}else{
			$xtpl->assign('tiene_permiso', 0);
		}
		$this->parseNu_total($xtpl, $oVenta->getNu_totalventa());
		$this->parseDtVenta($xtpl, $oVenta->getDt_fecha());

		$this->parseUsuarios($xtpl, $oVenta->getCd_usuario());
		$this->parseSucursales($xtpl, $oVenta->getCd_sucursal());
		$this->parseFormaspago($xtpl, $oVenta->getCd_formapago());
		$this->parseTipodocs($xtpl, $oVenta->getCliente()->getCd_tipodoc());
		$this->parseUnidad($xtpl, $oVenta->getUnidad());
		$this->parseVenta($xtpl, $oVenta);
		$this->parseCliente($xtpl, $oVenta->getCliente());

	}

	/*protected function parseSucursales(XTemplate $xtpl, $sucursal_actual ="") {
		$sucursalManager = new SucursalManager();
		$sucursales = $sucursalManager->getSucursales();
		foreach ($sucursales as $key => $sucursal) {
			$xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());
			$xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $sucursal_actual));
			$xtpl->parse('main.option_sucursal');
		}
	}*/

	protected function parseEntidadesKaizen($xtpl) {
		$oEntidadManager = new EntidadManager();
		$criterio = new CriterioBusqueda();
		$entidades = $oEntidadManager->getEntidadesDB($criterio);
		foreach ($entidades as $entidad) {
			$xtpl->assign('cd_entidad', $entidad->getCd_entidad());
			$xtpl->assign('ds_entidad', $entidad->getDs_entidad());
			$xtpl->parse('main.option_entidad');
		}
	}


	protected function parseVenta($xtpl, Venta $entidad){
		$xtpl->assign('cd_cliente', $entidad->getCd_cliente());
		$xtpl->assign('funcion_ajax', "Modificar Venta");
		$xtpl->assign('cd_venta', $entidad->getCd_venta());
		$xtpl->assign('cd_usuario', $entidad->getCd_usuario());
		$xtpl->assign('nu_doc', $entidad->getCliente()->getNu_doc());				$arrayFecha = explode(" ", $entidad->getDt_fecha());    	$xtpl->assign('dt_fecha', $arrayFecha[0]);
		//$xtpl->assign('dt_fecha', $entidad->getDt_fecha());
		$xtpl->assign('nu_totalventa', $entidad->getNu_totalventa());
		$xtpl->assign('nu_montosugerido', $entidad->getNu_montosugerido());


	}

	protected function parseCliente($xtpl, Cliente $oCliente){
		$xtpl_cliente = new XTemplate(APP_PATH."ventas/ajax/ajax_datoscliente.html");
		$xtpl_cliente->assign( 'ds_apynom', $oCliente->getDs_apynom());
		$xtpl_cliente->assign( 'ds_direccion', $oCliente->getDs_dircalle()." ".$oCliente->getDs_dirnro()." ".$oCliente->getDs_dirdepto()." ".$oCliente->getDs_dirpiso()  );
		$xtpl_cliente->parse ( 'main' );
		$texto = $xtpl_cliente->text('main');
		$xtpl->assign('datosCliente', $texto);
		$xtpl->parse("main.detalle_cliente");
	}

	protected function parsePagos($xtpl, $listado_pagos, Venta $oVenta) {
		$xtpl_pagos = new XTemplate(APP_PATH . 'ventas/ajax/ajax_altacredito.html');
		$this->parseEntidadesKaizen($xtpl_pagos);
		$_SESSION['pagos'] = serialize($listado_pagos);
		$_SESSION['pagosAnteriores'] = serialize($listado_pagos);
		if ($oVenta->getCd_formapago() == CD_CREDITO) {
			$xtpl_pagos->assign('label_fecha', "Fecha Aprobación Crédito");
		}else{
			$xtpl_pagos->assign('label_fecha', "Fecha Pago");
		}
		$importe_total = 0;
		$importe_acreditado = 0;

		foreach ($listado_pagos as $indice => $pago) {
			$xtpl_pagos->assign('entidad', $pago->getDs_entidad());
			$xtpl_pagos->assign('indice', $indice);
			$xtpl_pagos->assign('cd_formapago', $oVenta->getCd_formapago());
			$xtpl_pagos->assign('importe', $pago->getNu_importe());
			$xtpl_pagos->assign('ds_detalle', $pago->getDs_detalle());

			$xtpl_pagos->assign('fecha_vendedor', $pago->getDt_pago());
			$xtpl_pagos->assign('ds_observacion', $pago->getDs_observacion());
			$xtpl_pagos->assign('importe_pagado', $pago->getNu_pagado());
			$xtpl_pagos->parse('main.pagos');
			$importe_total += $pago->getNu_importe();
			$importe_acreditado += $pago->getNu_pagado();
		}
		//Hago readonly los campos que solo modifica el contador
		if(!$this->tienePermisoFuncion(MODIFICAR_PAGO_ACCION)){
			$xtpl_pagos->assign('campo_readonly', "readonly");
		}
		$xtpl_pagos->assign('nu_importetotal', $importe_total);
		$xtpl_pagos->assign('nu_importeacreditado', $importe_acreditado);
		$xtpl_pagos->parse('main');
		$texto = $xtpl_pagos->text('main');
		$xtpl->assign('listado_pagos', $texto);
		$xtpl->parse("main.detalle_creditos");


	}

	/*protected function parsePagocontado($xtpl, $ds_observacion) {
	 $_SESSION['pagos'] = serialize(new ItemCollection());
	 $_SESSION['pagosAnteriores'] = serialize(new ItemCollection());
	 $xtpl_contado = new XTemplate(APP_PATH . 'ventas/ajax/ajax_pagocontado.html');
	 $xtpl_contado->assign('value_observacion', $ds_observacion);
	 if(!$this->tienePermisoFuncion(MODIFICAR_PAGO_ACCION)){
	 $xtpl_contado->assign('display_observacion',  "style='display:none;'");
	 }
	 $xtpl_contado->parse('main');
	 $texto = $xtpl_contado->text('main');
	 $xtpl->assign('listado_pagos', $texto);
	 $xtpl->parse("main.detalle_creditos");

	 }*/

	protected function getEntidad(){
		$oVenta = null;
		if (isset ( $_GET ['id'] )) {
			$cd_venta = $_GET ['id'];
			$manager = new VentaManager();
			$oVenta = $manager->getVentaPorId( $cd_venta );
		}		
		return $oVenta;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}