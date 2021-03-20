<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un remito de ingreso de productos.
 * 
 * @author Lucrecia
 * @since 29-01-2011
 * 
 */
class AltaRemitoIngresoInitAction extends EditarRemitoIngresoInitAction{


		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta RemitoIngreso";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	public function getTitulo(){
		return "Alta Remito de Ingreso";
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_remitoIngreso";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}
	
	
	protected function getEntidad(){
		$oRemito = new RemitoIngreso();

		//si hay un error, cargamos el remito con lo ingresado.
		
		if (isset ( $_GET ['er'] )){
		
			if (isset ( $_POST ['dt_fecha'] ))
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
		
		}
		
		

			
		return $oRemito;
	}	
	
}