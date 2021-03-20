<?php 

/**
 * Acción para editar un remito de ingreso de productos.
 *
 * La edición de los productos se realiza a modo remito:
 * Fecha-Proveedor-Productos
 * 
 * @author Lucrecia
 * @since 29-01-2011
 * 
 */
abstract class EditarRemitoIngresoAction extends EditarAction{

	public function getIdEntidad(){
		return  $_POST ['cd_remito'];
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oRemito = new RemitoIngreso();

		$oRemito->setDt_fecha ( FuncionesComunes::fechaPHPaMysql ( $_POST ['dt_fecha'] ) );
		
		if (isset ( $_POST ['cd_remito'] ))
			$oRemito->setCd_remito (  $_POST ['cd_remito'] ) ;
		
		if (isset ( $_POST ['proveedor'] ))
			$oRemito->setCd_proveedor (  $_POST ['proveedor'] ) ;
		
		if (isset ( $_POST ['tipo'] ))
			$oRemito->setCd_tipo ( $_POST ['tipo']  );
		
		if (isset ( $_POST ['ds_observaciones'] ))
			$oRemito->setDs_observaciones (  $_POST ['ds_observaciones']  );
		
		if (isset ( $_POST ['nu_numero'] ))
			$oRemito->setNu_numero(  $_POST ['nu_numero']  );
		
		if (isset ( $_POST ['nu_reserva'] ))
			$oRemito->setNu_reserva(  $_POST ['nu_reserva']  );
		
		//agregamos al remito los productos que están en sesión.
		$count = count($_SESSION['productos_nuevos']);
		for($i=0;$i<$count;$i++) {
	    	$oProducto =   unserialize( $_SESSION['productos_nuevos'][$i] );
			$oRemito->agregarProducto($oProducto);	    	
		}
			
		return $oRemito;
	}
}