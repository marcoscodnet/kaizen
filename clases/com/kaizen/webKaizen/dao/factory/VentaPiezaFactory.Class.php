<?php
/**
 *
 * @author Marï¿½a Jesï¿½s
 * @since 16-11-2011
 *
 * Factory para ventas de piezas.
 *
 */
class VentaPiezaFactory implements ObjectFactory{

	/**
	 * construye una venta pieza.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		
		$oVentaPieza = new VentaPieza();
		$oVentaPieza->setCd_ventapieza( $next ['cd_ventapieza'] );
		$oVentaPieza->setDt_ventapieza( implode("/", array_reverse(explode("-", $next ['dt_ventapieza'] ))));
		$oVentaPieza->setDs_descripcion( $next ['ds_descripcion'] );
		$oVentaPieza->setNu_destino( $next ['nu_destino'] );
		$oVentaPieza->setNu_pedidoreparacion( $next ['nu_pedidoreparacion'] );
		$oVentaPieza->setDs_apynomCliente( $next ['ds_apynomcliente'] );
		$oVentaPieza->setNu_docCliente( $next ['nu_docCliente'] );
		$oVentaPieza->setDs_telCliente( $next ['ds_telcliente'] );
		$oVentaPieza->setDs_motoCliente( $next ['ds_motocliente'] );
		$oVentaPieza->setDs_piezas( $next ['group_piezas'] );
		$oVentaPieza->setNu_precioCobrado( FuncionesComunes::redondear($next ['nu_monto']) );
		$nu_destino = $oVentaPieza->getNu_destino();
		switch ($nu_destino) {
			case 1:
				$ds_destino = "Salón";
				break;
			case 2:
				$ds_destino = "Sucursal";
				break;
			case 3:
				$ds_destino = "Taller";
				break;
		}
		$oVentaPieza->setDs_destino($ds_destino);
		//sucursal
		if(array_key_exists('ds_nombre',$next)){
			$sucursalFactory = new SucursalFactory();
			$oVentaPieza->setSucursal($sucursalFactory->build($next));
		}
		
	//usuario
		if(array_key_exists('ds_nomusuario',$next)){
			$usuarioFactory = new UsuarioFactory();
			$oVentaPieza->setUsuario($usuarioFactory->build($next));
		}

		return $oVentaPieza;
	}
}
?>