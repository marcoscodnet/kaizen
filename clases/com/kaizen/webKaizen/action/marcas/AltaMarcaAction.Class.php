<?php 

/**
 * Acción para dar de alta una marca.
 * 
 * @author Lucrecia
 * @since 14-01-2011
 * 
 */
class AltaMarcaAction extends EditarMarcaAction{

	protected function editar($oEntidad){
		$manager = new MarcaManager();
		$manager->agregarMarca( $oEntidad[0], $oEntidad[1] );
	}
	
	protected function getForwardSuccess(){
		return 'alta_marca_success';
	}
	
	protected function getForwardError(){
		return 'alta_marca_error';
	}
	
	public function getFuncion(){
		return "Alta Marca";
	}
}