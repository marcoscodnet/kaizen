<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un tipo de unidad.
 *  
 * @author Marcos * @since 15-05-2012
 * 
 */
class ModificarTiposervicioInitAction extends EditarTiposervicioInitAction{
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Tipo de servicio";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Tipo de servicio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_tiposervicio";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oTiposervicio = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_tiposervicio = $_GET ['id'];			
			
			$manager = new TiposervicioManager();
			$oTiposervicio = $manager->getTiposervicioPorId( $cd_tiposervicio );
		}
		
		return $oTiposervicio;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
}