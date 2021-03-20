<?php

/**
 *
 * @author Ma. Jesús
 * @since 19-07-2011
 *
 */
class AjaxBuscarStockPiezaAction extends SecureAjaxAction {

	protected $path_html;
	protected $class;
	protected $required;

	/**
	 * se elimina de sesión la pieza seleccionada.
	 */
	public function executeImpl() {

		$criterio = new CriterioBusqueda();
		if (isset($_GET ['cd_stockpieza']) && ($_GET ['cd_stockpieza'] != "")) {
			$cd_pieza = $_GET ['cd_stockpieza'];
			$criterio->addFiltro("cd_stockpieza", "'$cd_pieza'", "=");
		}

		$manager = new StockPiezaManager();

		try {
			$stockpiezas = $manager->getStockPiezas($criterio);
		} catch (GenericException $ex) {
			$stockpiezas = new ItemCollection();
		}

		$xtpl = new XTemplate(APP_PATH . $this->path_html);
		foreach ($stockpiezas as $key => $entidad) {
			$this->parseEntidad($entidad, $xtpl);
		}
		$xtpl->assign($this->ds_labelTag, $this->ds_label);
		$xtpl->assign($this->ds_idTag, $this->ds_id);

		//seteamos la funciï¿½n de "onchange" en caso de que se haya indicado una.
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

	protected function parseEntidad($entidad, $xtpl) {
		$xtpl->assign('cd_stockpieza', htmlentities($entidad->getCd_stockPieza()));
		$xtpl->assign('ds_descripcion', htmlentities($entidad->getDs_descripcion()));

		$xtpl->assign('option', 'option');
		$xtpl->assign('tag', 'value');
		$xtpl->assign('style', '');
		$xtpl->parse('main.row');
	}

	public function getFuncion() {
		return "Listar Stock Pieza";
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

	public function getOnchange() {
		return $this->onchange;
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