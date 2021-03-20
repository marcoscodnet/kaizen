<?php

class AjaxCargarAltaCreditoAction extends SecureAjaxAction {

	protected $path_html;
	protected $class;
	protected $required;
	protected $funcion ="";

	/**
	 * se elimina de sesi�n el producto consumido seleccionado.
	 */
	public function executeImpl() {
		if (isset($_GET ['cd_formapago'])) {
			$cd_formapago = $_GET ['cd_formapago'];
		}

		$this->setPath_html('ventas/ajax/ajax_altacredito.html');
		$xtpl = new XTemplate(APP_PATH . $this->path_html);


		if ($cd_formapago == CD_CREDITO) {
			$xtpl->assign('label_fecha', "Fecha Aprobaci&oacute;n Cr&eacute;dito");
		}else{
			$xtpl->assign('label_fecha', "Fecha Pago");
		}

                /*
		$manager = new ClienteManager();
		try {
			$oCliente = $manager->getClientePorId($cd_cliente);
		} catch (GenericException $ex) {
			$oCliente = new ItemCollection();
		}*/

		$this->parseEntidadKaizen($xtpl);
		$this->parsePagos($xtpl, $oCliente);

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