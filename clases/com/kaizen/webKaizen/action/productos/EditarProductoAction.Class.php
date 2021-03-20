<?php

/**
 * Acción para editar un producto.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarProductoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oProducto = new Producto();

		if (isset ( $_POST ['cd_producto'] ))
		$oProducto->setCd_producto (  $_POST ['cd_producto']  );
			
		if (isset ( $_POST ['cd_tipounidad'] ))
		$oProducto->setCd_tipounidad($_POST ['cd_tipounidad']  );

		if (isset ( $_POST ['cd_marca'] ))
		$oProducto->setCd_marca( $_POST ['cd_marca'] );
			
		if (isset ( $_POST ['cd_modelo'] ))
		$oProducto->setCd_modelo (  $_POST ['cd_modelo'] ) ;

		if (isset ( $_POST ['cd_color'] ))
		$oProducto->setCd_color($_POST ['cd_color'] ) ;

		if (isset ( $_POST ['nu_monto_sugerido'] ))
		$oProducto->setNu_monto_sugerido ( $_POST ['nu_monto_sugerido'] ) ;

		if (isset ( $_POST ['nu_stock_minimo'] ))
		$oProducto->setNu_stock_minimo( $_POST ['nu_stock_minimo'] ) ;
		if ($_POST ['bl_discontinuo']){			$oProducto->setBl_discontinuo(1);		}
		return $oProducto;
	}
}