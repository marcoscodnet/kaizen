<?php 

/**
 * Acci�n para visualizar un consumo estimado de productos.
 *  
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
class VerConsumoEstimadoAction extends SecureOutputAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getContenido()
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'consumosEstimados/verconsumoestimado.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_consumo = $_GET ['id'];
			
			$manager = new ConsumoEstimadoManager();
			
			try{
				$oConsumoEstimado = $manager->getConsumoEstimadoPorId ( $cd_consumo );
			}catch(GenericException $ex){
				$oConsumoEstimado = new ConsumoEstimado();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el consumo estimado.
			$xtpl->assign ( 'cd_consumo', $oConsumoEstimado->getCd_consumo());
			$xtpl->assign ( 'ds_cliente', $oConsumoEstimado->getDs_cliente () );
			$xtpl->assign ( 'dt_fecha', FuncionesComunes::fechaMysqlaPHP ( $oConsumoEstimado->getDt_fecha() ) );
			$xtpl->assign ( 'cd_obra', stripslashes ( $oConsumoEstimado->getCd_obra() ) );
			$xtpl->assign ( 'ds_obra', stripslashes ( $oConsumoEstimado->getDs_obra() ) );
			
			//mostramos los productos consumidos.
			foreach($oConsumoEstimado->getProductosConsumidos() as $key => $oProductoConsumido) {
	
				$xtpl->assign ( 'ds_tipoProducto', stripslashes ( $oProductoConsumido->getTipoProducto()->getDs_codigoSAP() . ' - ' . $oProductoConsumido->getDs_tipoProducto()) );
				$xtpl->assign ( 'ds_cantidad', stripslashes ( $oProductoConsumido->getDs_cantidad () ) );		
				
				$xtpl->parse ( 'main.option_consumo' );	    	
			}
				
		}
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Ver ConsumoEstimado";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	public function getTitulo(){
		return "Detalle Consumo Cliente";
	}
	
}