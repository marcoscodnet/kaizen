<?php 

/**
 * Acción para editar un consumo estimado de productos.
 *
 * La edición de los consumos se realiza a modo remito:
 * Fecha-Proveedor-Productos consumidos
 * 
 * @author Lucrecia
 * @since 21-01-2011
 * 
 */
abstract class EditarConsumoEstimadoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oConsumoEstimado = new ConsumoEstimado();

		$oConsumoEstimado->setDt_fecha ( FuncionesComunes::fechaPHPaMysql ( $_POST ['dt_fecha'] ) );
		
		if (isset ( $_POST ['cd_consumo'] ))
			$oConsumoEstimado->setCd_consumo (  $_POST ['cd_consumo'] ) ;
		
		if (isset ( $_POST ['cliente'] ))
			$oConsumoEstimado->setCd_cliente (  $_POST ['cliente'] ) ;
		
		if (isset ( $_POST ['cd_obra'] ))
			$oConsumoEstimado->setCd_obra (  $_POST ['cd_obra'] ) ;
		
		//agregamos al consumo los productos consumidos que estÃ¡n en sesión.
		$count = count($_SESSION['consumos']);
		for($i=0;$i<$count;$i++) {
	    	$oProductoConsumido =   unserialize( $_SESSION['consumos'][$i] );
			$oConsumoEstimado->agregarProductoConsumido($oProductoConsumido);	    	
		}
			
		return $oConsumoEstimado;
	}
}