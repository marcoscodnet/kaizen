<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un almacén.
 *  
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
class ModificarAlmacenInitAction extends EditarAlmacenInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Almacen";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Almac&eacute;n";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_almacen";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oAlmacen = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_almacen = $_GET ['id'];			
			
			$manager = new AlmacenManager();
			$oAlmacen = $manager->getAlmacenPorId( $cd_almacen );
		}else 
			$oAlmacen = new Almacen();
		
		return $oAlmacen;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
	
}