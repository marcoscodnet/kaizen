<?php
/**
 *
 * @author Lucrecia
 * @since 14-03-2010
 *
 * Factory para ventas.
 *
 */
class VentaFactory implements ObjectFactory{

	/**
	 * construye una venta.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oVenta = new Venta();
		$oVenta->setCd_venta( $next ['cd_venta'] );
		$oVenta->setNu_totalventa( $next ['nu_total'] );
		$oVenta->setNu_importeencreditos( $next ['importeencreditos'] );
		$oVenta->setDs_observacion( $next ['ds_observacion'] );
		$oVenta->setDt_fecha( FuncionesComunes::fechaHoraMysqlaPHP($next ['dt_venta']) );
		//$oVenta->setDt_fecha( implode("/", array_reverse(explode("-", $next ['dt_venta'] ))));
		$oVenta->setNu_montosugerido( $next ['nu_montosugerido'] );
		//print_r($next);
		//sucursal
		if(array_key_exists('ds_nombre',$next)){
			$sucursalFactory = new SucursalFactory();
			$oVenta->setSucursal($sucursalFactory->build($next));
		}
		//usuario
		if(array_key_exists('ds_nomusuario',$next)){
			$usuarioFactory = new UsuarioFactory();
			$oVenta->setUsuario($usuarioFactory->build($next));
		}

		//cliente
		if(array_key_exists('nu_doc',$next)){
			$clienteFactory = new ClienteFactory();
			$oVenta->setCliente($clienteFactory->build($next));
		}

		//unidad
		if(array_key_exists('nu_motor',$next)){
			$unidadFactory = new UnidadFactory();
			$oVenta->setUnidad($unidadFactory->build($next));
		}

		//unidad
		if(array_key_exists('ds_formapago',$next)){
			$formapagoFactory = new FormapagoFactory();
			$oVenta->setFormapago($formapagoFactory->build($next));
		}

		return $oVenta;
	}
}
?>