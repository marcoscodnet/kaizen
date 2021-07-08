<?php



class AjaxEliminarCreditoAction extends SecureAjaxAction {



	protected $path_html;

	protected $class;

	protected $required;

	protected $tienePermisoEditarPago = false;

	protected $funcion ="";



	/**

	 * se elimina de sesi�n el producto consumido seleccionado.

	 */

	public function executeImpl() {

		$itemPago = new Itempago();



		if (isset($_SESSION['pagos'])) {

			if (isset($_GET ['indice'])) {

				$indice = $_GET ['indice'];

				$tmp_pagos = unserialize($_SESSION['pagos']);

				if ($tmp_pagos->size() == 1) {

					$tmp_pagos = new ItemCollection();

				} else {

					$tmp_pagos->removeItemByKey($indice);

				}



				$_SESSION['pagos'] = serialize($tmp_pagos);

			}

		}



		$xtpl = new XTemplate(APP_PATH . $this->path_html);

                $xtpl->assign('cantidad_items', $tmp_pagos->size());

		session_start ();

		$cd_usuario = $_SESSION ["cd_usuarioSession"];

		$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, MODIFICAR_PAGO_ACCION );

		$this->setTienePermisoEditarPago($tienePermiso);

		if(! $this->getTienePermisoEditarPago()){

			$xtpl->assign('campo_readonly', "readonly");

			$xtpl->assign('tiene_permiso', "true");

		}



		$this->parseEntidadKaizen($xtpl);

		$this->parsePagos($xtpl);

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



		$xtpl->assign('WEB_PATH', WEB_PATH);

		$xtpl->parse('main');

		$texto = $xtpl->text('main');



		return $texto;

	}



	protected function parseEntidadKaizen($xtpl) {

		$oEntidadManager = new EntidadManager();

		$criterio = new CriterioBusqueda();
        $criterio->addFiltro('bl_activo', 1, "=");

		$entidades = $oEntidadManager->getEntidadesDB($criterio);

		foreach ($entidades as $entidad) {

			$xtpl->assign('cd_entidad', $entidad->getCd_entidad());

			$xtpl->assign('ds_entidad', $entidad->getDs_entidad());

			$xtpl->parse('main.option_entidad');

		}

	}



	protected function parsePagos($xtpl) {

		$importe_total = 0;

		$importe_acreditado = 0;

		if (isset($_SESSION['pagos'])) {

			$pagos = unserialize($_SESSION['pagos']);

		} else {

			$pagos = array();

		}

		if ($_GET['cd_formapago'] == CD_CREDITO) {

			$xtpl->assign('label_fecha', "Fecha Aprobaci&oacute;n Cr&eacute;dito");

		}else{

			$xtpl->assign('label_fecha', "Fecha Pago");

		}

		$cd_formapago = $_GET['cd_formapago'];

		foreach ($pagos as $indice => $pago) {

			$xtpl->assign('fecha_vendedor', $pago->getDt_pago());

			$xtpl->assign('entidad', $pago->getDs_entidad());

			$xtpl->assign('indice', $indice);

			$xtpl->assign('cd_formapago', $cd_formapago);

			$xtpl->assign('importe', $pago->getNu_importe());

			$xtpl->assign('importe_pagado', $pago->getNu_pagado());



			$importe_total += $pago->getNu_importe();

			$importe_acreditado += $pago->getNu_pagado();

			$xtpl->parse('main.pagos');

		}

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



	protected function getTienePermisoEditarPago(){

		return $this->tienePermisoEditarPago;

	}



	protected function setTienePermisoEditarPago($value){

		$this->tienePermisoEditarPago = $value;

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
