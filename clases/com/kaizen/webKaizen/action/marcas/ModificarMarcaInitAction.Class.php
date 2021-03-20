<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un marca.
 *  
 * @author Lucrecia
 * @since 10-01-2011
 * 
 */
class ModificarMarcaInitAction extends EditarMarcaInitAction{

	protected function getEntidad(){
		$oMarca = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$cd_marca = $_GET ['id'];			
			
			$manager = new MarcaManager();
			$oMarca = $manager->getMarcaConTiposunidadesPorId($cd_marca);
		}
		
		return $oMarca ;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Marca";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Marca";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_marca";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}