<?php 

/**
 * Acci�n para modificar un tipo de unidad.
 * 
 * @author Marcos
 * 
 */
class ModificarTiposervicioAction extends EditarTiposervicioAction{
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new TiposervicioManager();
		$manager->modificarTiposervicio($oEntidad);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_tiposervicio_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_tiposervicio_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Tipo de servicio";
	}

}