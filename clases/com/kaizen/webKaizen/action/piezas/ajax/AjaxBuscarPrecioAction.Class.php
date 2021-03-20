<?php

/**
 *
 * @author Marcos
 * @since 05-07-2012
 *
 */
class AjaxBuscarPrecioAction extends SecureAjaxAction {

	protected $path_html;
	protected $class;
	protected $required;

	/**
	 * se elimina de sesión la pieza seleccionada.
	 */
	public function executeImpl() {

		$cd_pieza = $_GET ['cd_pieza'];		$manager = new PiezaManager();		$oPieza = $manager->getPiezaPorId( $cd_pieza );
		$xtpl = new XTemplate(APP_PATH . $this->path_html);
				$xtpl->assign('qt_costo', $oPieza->getQt_costo());		$xtpl->assign('qt_minimo', $oPieza->getQt_minimo());		
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

	

	public function getFuncion() {
		return "Listar Pieza";
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