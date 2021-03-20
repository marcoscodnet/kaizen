<?php 

/**
 * Acción para cerrar una obra.
 * 
 * @author Lucrecia
 * @since 23-04-2010
 * 
 */
class CerrarObraAction extends EditarAction{
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$cd_obra = $_GET ['id'];
		return $cd_obra;
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new ObraManager();
		$manager->cerrarObra($oEntidad);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'cerrar_obra_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'cerrar_obra_error';
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Cerrar Obra";
	}
	
}