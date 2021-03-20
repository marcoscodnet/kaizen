<?php 

/**
 * Acci�n para inicializar el contexto para editar
 * un consumo estimado de productos.
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
abstract class EditarConsumoEstimadoInitAction extends EditarInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. 'consumosEstimados/editarconsumoestimado.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new ConsumoEstimado();
	}
		
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oConsumoEstimado = FormatUtils::ifEmpty($entidad, new ConsumoEstimado());
		//se muestra el consumo.
		$this->parseConsumoEstimado( $oConsumoEstimado, $xtpl);

		//recupera y parsea clientes.
		$this->parseClientes($oConsumoEstimado->getCd_cliente() , $xtpl);
		
		//inicializamos los consumos
		unset ( $_SESSION ['consumos'] );
		$this->parseConsumos( $oConsumoEstimado->getProductosConsumidos() , $xtpl );
	}	
	
	
	protected function parseConsumoEstimado(ConsumoEstimado $oConsumoEstimado, XTemplate $xtpl){
		$xtpl->assign ( 'cd_consumo', $oConsumoEstimado->getCd_consumo());
		$xtpl->assign ( 'cd_obra',  FormatUtils::ifEmpty($oConsumoEstimado->getCd_obra (), '')  );

		if(FormatUtils::isEmpty( $oConsumoEstimado->getDt_fecha() ) )
			//seteamos la fecha actual.
			$xtpl->assign('dt_fecha', FuncionesComunes::fechaMysqlaPHP( date("Ymd") ) );
		else
			$xtpl->assign ( 'dt_fecha',   FuncionesComunes::fechaMysqlaPHP( $oConsumoEstimado->getDt_fecha() )  );
				
	}
	
	protected function parseConsumos(ItemCollection $productosConsumidos, XTemplate $xtpl){
		//mostramos los consumos y los vamos dejando en sesi�n para ser editados con ajax.
		$i=0;
		foreach($productosConsumidos as $key => $oProductoConsumido) {
			$xtpl->assign ( 'ds_tipoProducto',  $oProductoConsumido->getTipoProducto()->getDs_codigoSAP() . ' - ' . $oProductoConsumido->getDs_tipoProducto()) ;
			$xtpl->assign ( 'ds_cantidad',  $oProductoConsumido->getDs_cantidad () ) ;		
			$xtpl->assign ( 'indice',  $i  );
			$xtpl->parse ( 'main.option_consumo' );
			$_SESSION['consumos'][] = serialize( $oProductoConsumido);
			$i++;
		}
	}	
	
	protected function parseClientes($cd_selected='', XTemplate $xtpl){
		//recupera y parsea clientes.
		$clientesManager = new ClienteManager();
		$clientes = $clientesManager->getClientes();
		foreach($clientes as $key => $cliente) {
			$xtpl->assign ( 'ds_cliente', $cliente->getDs_nombre() . ' (' .$cliente->getDs_cuit() .')' );
			$xtpl->assign ( 'cd_cliente', FormatUtils::selected($cliente->getCd_cliente(), $cd_selected)  );				
			$xtpl->parse ( 'main.option_cliente' );
		}
	
			
	}
	
	
}