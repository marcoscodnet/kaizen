<?php 

/**
 * Acción para visualizar un remito de ingreso.
 *  
 * @author Lucrecia
 * @since 30-01-2011
 * 
 */
class VerRemitoIngresoAction extends SecureOutputAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getContenido()
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'remitosIngreso/verremitoingreso.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_remito = $_GET ['id'];
			
			$manager = new RemitoIngresoManager();
			
			try{
				$oRemito = $manager->getRemitoIngresoPorId ( $cd_remito );
			}catch(GenericException $ex){
				$oRemito = new RemitoIngreso();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el remito de ingreso.
			$xtpl->assign ( 'cd_remito', $oRemito->getCd_remito());
			$xtpl->assign ( 'ds_proveedor', $oRemito->getDs_proveedor () );
			$xtpl->assign ( 'dt_fecha', FuncionesComunes::fechaMysqlaPHP ( $oRemito->getDt_fecha() ) );
			$xtpl->assign ( 'ds_observaciones', $oRemito->getDs_observaciones() );
			$xtpl->assign ( 'ds_tipo', $oRemito->getDs_tipo() );
			$xtpl->assign ( 'nu_numero', $oRemito->getNu_numero() );
						
			//mostramos los productos del remito.
			foreach($oRemito->getProductos() as $key => $oProducto) {
	
				$xtpl->assign ( 'cd_producto', $oProducto->getCd_producto() );
		    	$xtpl->assign ( 'ds_producto', $oProducto->getDs_producto() );
		    	$xtpl->assign ( 'ds_numero', $oProducto->getDs_numero() );
				$xtpl->assign ( 'ds_tipoProducto', stripslashes ( $oProducto->getTipoProducto()->getDs_codigoSAP() . ' - ' . $oProducto->getDs_tipoProducto()) );
				$xtpl->assign ( 'ds_cantidad', stripslashes ( $oProducto->getDs_cantidad () ) );	
				
				$xtpl->parse ( 'main.option_producto' );	    	
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
		return "Ver RemitoIngreso";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	public function getTitulo(){
		return "Detalle Remito de Ingreso";
	}
	
	
}