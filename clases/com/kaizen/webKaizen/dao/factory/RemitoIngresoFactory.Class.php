<?php
/**
 * 
 * @author Lucrecia
 * @since 29-01-2011
 * 
 * Factory para remito de ingreso.
 *
 */
class RemitoIngresoFactory extends RemitoFactory{

	/**
	 * construye un remito. 
	 * @param $next
	 * @return remito
	 */
	public function build($next){
		$oRemito = parent::build($next);
		$oRemito->setCd_proveedor( $next ['cd_proveedor'] );
		$oRemito->setNu_numero( $next ['nu_numero'] );
		$oRemito->setCd_tipo( $next ['cd_tiporemitoingreso'] );
		
		//para el caso de join con proveedor.
		if(array_key_exists('ds_razonSocial',$next)){
			$proveedorFactory = new ProveedorFactory();
			$oRemito->setProveedor( $proveedorFactory->build($next) );
		}		
		
		//para el caso de join con tipo de remito.
		if(array_key_exists('ds_tiporemitoingreso',$next)){
			$factory = new TipoRemitoIngresoFactory();
			$oRemito->setTipo( $factory->build($next) );
		}		
		
		return $oRemito;
	}
	
	protected function getRemitoInstance(){
		return new RemitoIngreso();	
	}
}
?>