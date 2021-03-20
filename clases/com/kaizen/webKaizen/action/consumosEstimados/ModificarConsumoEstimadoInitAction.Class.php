<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un consumo estimado de productos.
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class ModificarConsumoEstimadoInitAction extends EditarConsumoEstimadoInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/consumosEstimados/EditarConsumoEstimadoInitAction#getEntidad()
	 */
	protected function getEntidad(){
		//recuperar el consumo junto con sus productos consumidos.
		$cd_consumo = $_GET ['id'];
		$manager = new ConsumoEstimadoManager();
		$oConsumoEstimado = $manager->getConsumoEstimadoPorId ( $cd_consumo );
		return $oConsumoEstimado;
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar ConsumoEstimado";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	public function getTitulo(){
		return "Modificar Consumo Cliente";
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_consumoEstimado";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
	
}