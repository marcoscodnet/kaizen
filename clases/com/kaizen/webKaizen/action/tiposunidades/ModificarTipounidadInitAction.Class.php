<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un tipo de unidad.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ModificarTipounidadInitAction extends EditarTipounidadInitAction{
	

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Tipo de unidad";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Tipo de unidad";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_tipounidad";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oTipounidad = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_tipounidad = $_GET ['id'];			
			
			$manager = new TipounidadManager();
			$oTipounidad = $manager->getTipounidadPorId( $cd_tipounidad );
		}
		
		return $oTipounidad;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
}