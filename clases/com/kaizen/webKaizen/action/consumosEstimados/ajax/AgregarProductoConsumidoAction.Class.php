<?php
/**
 * Acción para agregar en sesión un producto consumido utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class AgregarProductoConsumidoAction extends EditarProductoConsumidoAction{

	
	/**
	 * se agrega un consumo en sesión.
	 */
	public function editarProductoConsumido(){

		//formamos el nuevo producto consumido.
		$oProductoConsumido = $this->getProductoConsumido();

		$cd_tipoProducto = $oProductoConsumido->getCd_tipoProducto();
		$nu_cantidad = $oProductoConsumido->getNu_cantidad();
		
		if( !empty( $cd_tipoProducto ) && !empty( $nu_cantidad )){
			//agregamos el producto consumido en la sesión.
			$_SESSION['consumos'][] = serialize( $oProductoConsumido );
		}else{
			//TODO
		}
		
	}
	

	public function getProductoConsumido(){
		$oProductoConsumido = new ProductoConsumido();

		if (isset ( $_GET ['nu_cantidad'] ) )
			$oProductoConsumido->setNu_cantidad ( $_GET ['nu_cantidad'] );
			
		if (isset ( $_GET ['cd_tipoProducto'] )){
			$cd_tipoProducto =   $_GET ['cd_tipoProducto']  ;
			
			if(!FormatUtils::isEmpty($cd_tipoProducto)){
				$manager = new TipoProductoManager();
				$oTipoProducto = $manager->getTipoProductoPorId($cd_tipoProducto);
				$oProductoConsumido->setTipoProducto($oTipoProducto);				
			}
			
		}
		return $oProductoConsumido;
	}

	protected function mostrarErrores(XTemplate $xtpl){
		$oProductoConsumido = $this->getProductoConsumido();
		$xtpl->assign ( 'nu_cantidad_nuevo', $oProductoConsumido->getNu_cantidad () );
		
	    $cd_tipoProducto = $oProducto->getCd_tipoProducto();
		if( !empty( $cd_tipoProducto ) ){
		    $xtpl->assign ( 'ds_tipoProducto_nuevo', $oProductoConsumido->getDs_tipoProducto() . ' - ( ' .  $oProductoConsumido->getTipoProducto()->getDs_unidadMedida() .' )'  );
			$xtpl->assign ( 'cd_tipoProducto_nuevo',  $oProductoConsumido->getCd_tipoProducto()  );
		}
	
	}
}