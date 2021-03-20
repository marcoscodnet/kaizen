<?php
/**
 * Acción para ediar de sesión un contratitsta utilizando Ajax.
 *
 * @author Lucrecia
 * @since 09-04-2010
 *
 */
abstract class EditarContratistaDeObraAction extends SecureAjaxAction{


	/**
	 * se edita el trabajador y se muestra la
	 * lista de trabajadores de sesión.
	 */
	public function executeImpl(){

		$this->editarTrabajadorObra();

		return $this->getMostrarTrabajadores();
	}


	public function getFuncion(){
		return null; //TODO "Asignar Trabajadores a Obra";
	}

	public function getMostrarTrabajadores(){

		//parseamos el html con los trabajadores.
		$xtpl = $this->getXTemplate();

		$count = count($_SESSION['trabajadores_obra']);
		for($i=0;$i<$count;$i++) {
			$oTrabajadorObra =   unserialize( $_SESSION['trabajadores_obra'][$i] );
				
			//vemos si es contratista
			$cd_tipoTrabajador = $oTrabajadorObra->getCd_tipoTrabajador();
			if( $cd_tipoTrabajador==$this->getTipoTrabajador()){

				$this->parseTrabajadorObra( $oTrabajadorObra, $xtpl);

				$xtpl->assign ( 'indice', stripslashes ( $i ) );
				$xtpl->parse ( 'main.option_trabajador' );
			}

		}

		//parsea los errores.
		if($this->tieneErrores()){
			$this->mostrarErrores($xtpl);
				
		}
		
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		
		$xtpl->parse ( 'main' );
		$texto = $xtpl->text('main');
		return $texto;
	}

	protected function existeEnSesion(TrabajadorObra $oTrabajadorObra){
		$count = count($_SESSION['trabajadores_obra']);
		for($i=0;$i<$count;$i++) {
			$oNext =   unserialize( $_SESSION['trabajadores_obra'][$i] );

			if($oNext->getCd_trabajadorObra()==$oTrabajadorObra->getCd_trabajadorObra())
				return true;
		}
		return false;
		
	}
	
	protected function tieneErrores(){
		return false;//TODO !empty($this->errorProducto) || !empty($this->errorTipoProducto) || !empty($this->errorCantidad);
	}

	protected function mostrarErrores(){
	}
	
	protected function getTipoTrabajador(){
		return CONTRATISTA;
	}
	
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. 'obras/contratistasasignar.html' );	
	}

	protected function parseTrabajadorObra(TrabajadorObra $oTrabajadorObra, XTemplate $xtpl){
		$xtpl->assign('cd_contratista', $oTrabajadorObra->getCd_trabajadorObra());
		$xtpl->assign ( 'ds_nombre', htmlentities ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
	}

	protected abstract function editarTrabajadorObra();
	
}