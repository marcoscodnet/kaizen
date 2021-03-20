<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un consumo estimado de productos.
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class AltaConsumoEstimadoInitAction extends EditarConsumoEstimadoInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta ConsumoEstimado";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	public function getTitulo(){
		return "Alta Consumo Cliente";
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_consumoEstimado";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}
	
		/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oConsumoEstimado = new ConsumoEstimado();
		//si hay un error, cargamos el remito con lo ingresado.
		
		if (isset ( $_GET ['er'] )){
		
			if (isset ( $_POST ['dt_fecha'] ))
				$oConsumoEstimado->setDt_fecha ( FuncionesComunes::fechaPHPaMysql ( $_POST ['dt_fecha'] ) );
		
			if (isset ( $_POST ['cliente'] ))
				$oConsumoEstimado->setCd_cliente(  $_POST ['cliente'] ) ;
			
			if (isset ( $_POST ['cd_obra'] ))
				$oConsumoEstimado->setCd_obra(  $_POST ['cd_obra']  );
			
			//agregamos al consumos los productos que están en sesión.
			$count = count($_SESSION['consumos']);
			for($i=0;$i<$count;$i++) {
		    	$oProducto =   unserialize( $_SESSION['consumos'][$i] );
				$oConsumoEstimado->agregarProductoConsumido($oProducto);	    	
			}			
		
		}
		return $oConsumoEstimado;
	}
		
	
}