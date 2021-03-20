<?php

class MovimientoFactory implements ObjectFactory {

	/**
	 * construye un movimiento.
	 * @param $next
	 * @return movimiento
	 */
	public function build($next) {
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_movimiento($next ['cd_movimiento']);
		$oMovimiento->setDt_movimiento(implode("/", array_reverse(explode("-", $next ['dt_movimiento']))));
		// $oMovimiento->setNu_motor($next ['nu_motor']);
		//$oMovimiento->setNu_cuadro($next ['nu_cuadro']);
		$oMovimiento->setDs_sucursalorigen($next ['ds_sucursalorigen']);
		$oMovimiento->setDs_sucursaldestino($next ['ds_sucursaldestino']);
		$oMovimiento->setDs_localidadsucursaldestino($next ['ds_localidadsucursaldestino']);
		$oMovimiento->setDs_domiciliosucursaldestino($next ['ds_domiciliosucursaldestino']);
		$oMovimiento->setDs_localidadsucursalorigen($next ['ds_localidadsucursalorigen']);
		$oMovimiento->setDs_domiciliosucursalorigen($next ['ds_domiciliosucursalorigen']);
		$oMovimiento->setDs_telefonosucursalorigen($next ['ds_telefonosucursalorigen']);
		$oMovimiento->setCd_sucursalorigen($next ['cd_sucursal_origen']);
		$oMovimiento->setCd_sucursaldestino($next ['cd_sucursal_destino']);
		$oMovimiento->setDs_observacion($next ['ds_observacionmovimiento']);

		if (array_key_exists('ds_nomusuario', $next)) {
		 $usuarioFactory = new UsuarioFactory();
		 $oMovimiento->setUsuario($usuarioFactory->build($next));
		}

		return $oMovimiento;
	}

}
?>