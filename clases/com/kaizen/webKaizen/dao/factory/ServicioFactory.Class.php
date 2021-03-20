<?php
/**
 *
 * @author Marcos
 * @since 16-05-2012
 *
 * Factory para servicios.
 *
 */
class ServicioFactory implements ObjectFactory{

	/**
	 * construye una servicio.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oServicio = new Servicio();
		$oServicio->setCd_servicio( $next ['cd_servicio'] );
		$oServicio->setNu_monto( $next ['monto'] );
		$oServicio->setDs_obsgral( $next ['ds_obsgral'] );
		$oServicio->setDt_carga( implode("/", array_reverse(explode("-", $next ['dt_carga'] ))));
		$oServicio->setDs_kmshoras( $next ['ds_kmshoras'] );

	

		$oServicio->setDs_descpedidocte( $next ['ds_descpedidocte'] );
	
		$dt_fechahora = explode( " ", $next ['dt_ingresovehiculo'] );
		$dt_fecha = implode("/", array_reverse(explode("-", $dt_fechahora[0])));
		$dt_hora = $dt_fechahora[1];
		$dt_ingresovehiculo = $dt_fecha.' '.$dt_hora;
		$oServicio->setDt_ingresovehiculo($dt_ingresovehiculo);
	
		
		$oServicio->setDs_diagyreprealizada( $next ['ds_diagyreprealizada'] );
		$oServicio->setDs_repuestosusados( $next ['ds_repuestosusados'] );
		$oServicio->setDs_mecanicos( $next ['ds_mecanicos'] );
		$oServicio->setDs_instmedusados( $next ['ds_instmedusados'] );
		$oServicio->setDs_tiempomanoobra( $next ['ds_tiempomanoobra'] );
		$oServicio->setDt_compromisoentrega( implode("/", array_reverse(explode("-", $next ['dt_compromisoentrega'] ))));
		$oServicio->setNu_monto( $next ['nu_monto'] );
		$oServicio->setBl_pagado( $next ['bl_pagado'] );
		
		//sucursal
		if(array_key_exists('ds_nombre',$next)){
			$sucursalFactory = new SucursalFactory();
			$oServicio->setSucursal($sucursalFactory->build($next));
		}
		//usuario
		if(array_key_exists('ds_nomusuario',$next)){
			$usuarioFactory = new UsuarioFactory();
			$oServicio->setUsuario($usuarioFactory->build($next));
		}

		//cliente
		if(array_key_exists('nu_doc',$next)){
			$clienteFactory = new ClienteFactory();
			$oServicio->setCliente($clienteFactory->build($next));
		}

		//vehiculoservicio
		if(array_key_exists('nu_motor',$next)){
			$vehiculoservicioFactory = new VehiculoservicioFactory();
			$oServicio->setVehiculoservicio($vehiculoservicioFactory->build($next));
		}

		//vehiculoservicio
		if(array_key_exists('ds_tipo_servicio',$next)){
			$tiposervicioFactory = new TiposervicioFactory();
			$oServicio->setTiposervicio($tiposervicioFactory->build($next));
		}

		return $oServicio;
	}
}
?>