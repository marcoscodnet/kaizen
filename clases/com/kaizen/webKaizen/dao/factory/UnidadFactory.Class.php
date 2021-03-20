<?php
/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Factory para cliente.
 *
 */
class UnidadFactory implements ObjectFactory{

	/**
	 * construye una unidad.
	 * @param $next
	 * @return unidad
	 */
	public function build($next){
		$oUnidad = new Unidad();
		if(isset($next['cd_unidad'])){
			$oUnidad->setCd_unidad($next ['cd_unidad']);
		}else{
			$oUnidad->setCd_unidad($next ['id']);
		}
		$oUnidad->setCd_producto($next ['cd_producto']);
		$oUnidad->setNu_motor($next ['nu_motor']);
		$oUnidad->setDt_ingreso(implode("/", array_reverse(explode("-",$next ['dt_ingreso']))));
		$oUnidad->setNu_cuadro($next ['nu_cuadro']);
		$oUnidad->setNu_patente($next ['nu_patente']);
		$oUnidad->setNu_remitoingreso($next ['nu_remito_ingreso']);
		$oUnidad->setNu_aniomodelo($next ['nu_aniomodelo']);
		$oUnidad->setDs_observacion($next ['ds_observacion']);
		$oUnidad->setNu_envio($next ['nu_envio']);

		//para el caso de join productp.
		if(array_key_exists('cd_venta',$next)){
			$oUnidad->setCd_venta($next ['cd_venta']);
		}
		if(array_key_exists('cd_autorizacion',$next)){
			$autorizacionFactory = new AutorizacionFactory();
			$oUnidad->setAutorizacion($autorizacionFactory->build($next));
		}

		if(array_key_exists('cd_producto',$next)){
			$productoFactory = new ProductoFactory();
			$oUnidad->setProducto( $productoFactory->build($next) );
		}

		if(array_key_exists('cd_sucursal_actual',$next)){
			$sucursalFactory = new SucursalFactory();
			$oUnidad->setSucursalactual($sucursalFactory->build($next) );
		}

		return $oUnidad;
	}
}
?>