<?php
/**
 * Acción para agregar en sesión un producto utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 29-01-2011
 *
 */
class AgregarProductoRemitoIngresoAction extends EditarProductoRemitoIngresoAction{

	
	/**
	 * se agrega un producto nuevo en sesión.
	 */
	public function editarProducto(){

		//formamos el nuevo producto.
		$oProducto = $this->getProducto();

		$cd_tipoProducto = $oProducto->getCd_tipoProducto();
		$nu_cantidad = $oProducto->getNu_cantidad();
		
		if( !empty( $cd_tipoProducto ) && !empty( $nu_cantidad )){
			//agregamos el producto en la sesión.
			$_SESSION['productos_nuevos'][] = serialize( $oProducto );
		}else{
			$this->setErrorProducto("ddd");
		}
		
	}
	

	public function getProducto(){
		$oProducto = new Producto();

		if (isset ( $_GET ['ds_producto'] ) )
			$oProducto->setDs_producto ( addslashes ( $_GET ['ds_producto'] ) );

		if (isset ( $_GET ['ds_numero'] ) )
			$oProducto->setDs_numero ( addslashes ( $_GET ['ds_numero'] ) );
		
		if (isset ( $_GET ['nu_cantidad'] ) )
			$oProducto->setNu_cantidad ( addslashes ( $_GET ['nu_cantidad'] ) );
			
		if (isset ( $_GET ['cd_tipoProducto'] )){
			$cd_tipoProducto =   addslashes ( $_GET ['cd_tipoProducto'] ) ;
			
			if(!FormatUtils::isEmpty($cd_tipoProducto)){
				$manager = new TipoProductoManager();
				$oTipoProducto = $manager->getTipoProductoPorId($cd_tipoProducto);
				$oProducto->setTipoProducto($oTipoProducto);				
			}
			
		}
		return $oProducto;
	}

	protected function mostrarErrores(XTemplate $xtpl){
		$oProducto = $this->getProducto();
		$xtpl->assign ( 'ds_producto_nuevo', $oProducto->getDs_producto() );
	    $xtpl->assign ( 'ds_numero_nuevo', $oProducto->getDs_numero() );
		$xtpl->assign ( 'nu_cantidad_nuevo', stripslashes ( $oProducto->getNu_cantidad () ) );
		
	    $cd_tipoProducto = $oProducto->getCd_tipoProducto();
		if( !empty( $cd_tipoProducto ) ){
		    $xtpl->assign ( 'ds_tipoProducto_nuevo', stripslashes (  $oProducto->getDs_tipoProducto() . ' - ( ' .  $oProducto->getTipoProducto()->getDs_unidadMedida() .' )' ) );
			$xtpl->assign ( 'ds_codigoSAP_nuevo', stripslashes ( $oProducto->getTipoProducto()->getDs_codigoSAP() ) );
			$xtpl->assign ( 'cd_tipoProducto_nuevo',  $oProducto->getCd_tipoProducto()  );
		}
	
	}
}