<?php

/**
 * Acción para visualizar un cliente.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class VerProductoAction extends SecureOutputAction{

	/**
	 * consulta un cliente.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'productos/verproducto.html' );

		if (isset ( $_GET ['id'] )) {
			$cd_producto = $_GET ['id'];

			$manager = new ProductoManager();

			try{
				$oProducto = $manager->getProductoPorId ( $cd_producto );
			}catch(GenericException $ex){
				$oProducto = new Producto();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra el producto.
			
			$xtpl->assign ( 'cd_producto', $oProducto->getCd_producto());
			$xtpl->assign ( 'ds_tipounidad', stripslashes ( $oProducto->getDs_tipounidad () ) );
			$xtpl->assign ( 'ds_marca', $oProducto->getDs_marca());
			$xtpl->assign ( 'ds_modelo', $oProducto->getDs_modelo());
			$xtpl->assign ( 'ds_color', $oProducto->getDs_color());
			$xtpl->assign ( 'nu_monto_sugerido', stripslashes ( $oProducto->getNu_monto_sugerido () ) );
			$xtpl->assign ( 'nu_stock_minimo', stripslashes ( $oProducto->getNu_stock_minimo() ) );

		}

		$xtpl->assign ( 'titulo', 'Detalle de producto' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	public function getFuncion(){
		return "Ver Producto";
	}

	public function getTitulo(){
		return "Detalle de Producto";
	}


}