<?php

class AjaxCargarAltaDestinoAction extends SecureAjaxAction {

	protected $path_html;
	protected $class;
	protected $required;
	protected $funcion ="";

	/**
	 * se elimina de sesi�n la pieza seleccionada.
	 */
	public function executeImpl() {
		if (isset($_GET ['nu_destino'])) {
			$cd_destino = $_GET ['nu_destino'];
		}
		//$this->setPath_html('ventaspiezas/ajax/ajax_altadestino.html');
		switch ($cd_destino) {			case CD_TALLER:				$this->setPath_html('ventaspiezas/ajax/ajax_altadestinotaller.html');				break;			case CD_SALON:				$this->setPath_html('ventaspiezas/ajax/ajax_altadestinosalon.html');				break;			case CD_SUCURSAL:				$this->setPath_html('ventaspiezas/ajax/ajax_altadestinosucursal.html');				break;			default:				$this->setPath_html('ventaspiezas/ajax/ajax_altadestinodefault.html');				break;					}
		/*if ($cd_destino == CD_TALLER) {
			$this->setPath_html('ventaspiezas/ajax/ajax_altadestinotaller.html');
		}

		if ($cd_destino == CD_SALON) {
			$this->setPath_html('ventaspiezas/ajax/ajax_altadestinosalon.html');
		}
		
		if ($cd_destino == CD_SUCURSAL) {
			$this->setPath_html('ventaspiezas/ajax/ajax_altadestinosucursal.html');
		}*/
		
		$xtpl = new XTemplate(APP_PATH . $this->path_html);

                /*
		$manager = new ClienteManager();
		try {
			$oCliente = $manager->getClientePorId($cd_cliente);
		} catch (GenericException $ex) {
			$oCliente = new ItemCollection();
		}*/

		//$this->parseEntidadKaizen($xtpl);
		//$this->parsePagos($xtpl, $oCliente);		$cd_sucursal = "";		if (isset($_GET ['cd_ventapieza'])) {			$cd_ventapieza = $_GET ['cd_ventapieza'];			$manager = new VentaPiezaManager();			$oVentaPieza = $manager->getVentaPiezaPorId($cd_ventapieza);			$xtpl->assign('value_nu_pedidoreparacion', $oVentaPieza->getNu_pedidoreparacion());			$xtpl->assign('value_ds_apynomcliente', $oVentaPieza->getDs_apynomcliente());			$xtpl->assign('value_nu_docCliente', $oVentaPieza->getNu_docCliente());			$xtpl->assign('value_ds_telcliente', $oVentaPieza->getDs_telcliente());			$xtpl->assign('value_ds_motocliente', $oVentaPieza->getDs_motocliente());			$cd_sucursal = $oVentaPieza->getCd_sucursal();		}		
		
		$this->parseSucursales($xtpl, $cd_sucursal);
		
		//seteamos la funci�n de "onchange" en caso de que se haya indicado una.
		if (!empty($this->onchange)) {
			$xtpl->assign('onchange', "javascript:" . $this->onchange . ";");
		}

		if (!empty($this->class)) {
			$xtpl->assign('class', "$this->class");
		}

		if ($this->required) {
			$xtpl->assign('required', "(*)");
		}

		/*}else{
			$this->setPath_html('ventas/ajax/ajax_pagocontado.html');
			$xtpl = new XTemplate(APP_PATH . $this->path_html);
			$_SESSION['pagos'] = serialize(new ItemCollection());


			}*/
		session_start ();
		$cd_usuario = $_SESSION ["cd_usuarioSession"];
		$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, MODIFICAR_PAGO_ACCION );
		if(! $tienePermiso){
			$xtpl->assign('campo_readonly', "readonly");
			$xtpl->assign('tiene_permiso', "true");
		}
		$xtpl->assign('WEB_PATH', WEB_PATH);
		$xtpl->parse('main');
		$texto = $xtpl->text('main');

		return $texto;
	}
	
	protected function parseSucursales(XTemplate $xtpl, $cd_selected ="") {
        $sucursalManager = new SucursalManager();
        $sucursales = $sucursalManager->getSucursales();
        $usuarioKManager = new UsuarioKaizenManager();
        $oUsuario = $usuarioKManager->getUsuarioPorId($_SESSION['cd_usuarioSession']);
        //$cd_selected = $oUsuario->getCd_sucursal();
        foreach ($sucursales as $key => $sucursal) {
            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());
            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));
            $xtpl->parse('main.option_sucursal');
        }
    }

	protected function parseEntidadKaizen($xtpl) {
		$oEntidadManager = new EntidadManager();
		$criterio = new CriterioBusqueda();
		$entidades = $oEntidadManager->getEntidadesDB($criterio);
		foreach ($entidades as $entidad) {
			$xtpl->assign('cd_entidad', $entidad->getCd_entidad());
			$xtpl->assign('ds_entidad', htmlentities($entidad->getDs_entidad()));
			$xtpl->parse('main.option_entidad');
		}
	}

	protected function parsePagos($xtpl) {
		$importe_total = 0;
		$importe_acreditado = 0;
		if (isset($_SESSION['pagos'])) {
			$pagos = unserialize($_SESSION['pagos']);
		} else {
			$pagos = new ItemCollection();
		}
		$cd_formapago = $_GET['cd_formapago'];
		foreach ($pagos as $indice => $pago) {
			$xtpl->assign('entidad', $pago->getDs_entidad());
			$xtpl->assign('indice', $indice);
			$xtpl->assign('cd_formapago', $cd_formapago);
			$xtpl->assign('importe', $pago->getNu_importe());
			$xtpl->assign('importe_pagado', $pago->getNu_pagado());
			$xtpl->assign('fecha_vendedor', $pago->getDt_pago());
			$importe_total += $pago->getNu_importe();
			$importe_acreditado += $pago->getNu_pagado();
			$xtpl->parse('main.pagos');
		}
                $xtpl->assign('cantidad_items', $pagos->size());
		$xtpl->assign('nu_importetotal', $importe_total);
		$xtpl->assign('nu_importeacreditado', $importe_acreditado);
	}

	public function getFuncion() {
		if($this->funcion == ""){
			return "Alta Venta";
		}else{
			return $this->funcion;
		}
	}

	public function setFuncion($value){
		$this->funcion = $value;
	}

	public function getPath_html() {
		return $this->path_html;
	}

	public function getClass() {
		return $this->class;
	}

	public function getRequired() {
		return $this->required;
	}

	/*
	 * setea el value para onchange del combo.
	 */

	public function setPath_html($value) {
		$this->path_html = $value;
	}

	public function setOnchange($value) {
		$this->onchange = $value;
	}

	public function setClass($value) {
		$this->class = $value;
	}

	public function setRequired($value) {
		$this->required = $value;
	}

}