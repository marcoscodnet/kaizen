<?php

/**
 * Acción para editar una venta.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarVentaAction extends EditarAction {

	protected function getEntidad() {
		$oVenta = new Venta();

		if (isset($_POST ['cd_unidad'])){
			$oVenta->setCd_unidad($_POST['cd_unidad']);
		}

		if (isset($_POST ['cd_venta'])){
			$oVenta->setCd_venta($_POST['cd_venta']);
		}

		if (isset($_POST ['cd_usuario'])){
			$oVenta->setCd_usuario($_POST['cd_usuario']);
		}

		if (isset($_POST ['cd_cliente'])){
			$oVenta->setCd_cliente($_POST['cd_cliente']);
		}

		if (isset($_POST ['nu_totalventa'])){
			$oVenta->setNu_totalventa($_POST['nu_totalventa']);
		}
		
		if (isset($_POST ['nu_montosugerido'])){
			$oVenta->setNu_montosugerido($_POST['nu_montosugerido']);
		}

		if (isset($_POST ['cd_sucursal'])){
			$oVenta->setCd_sucursal($_POST['cd_sucursal']);
		}

		if (isset($_POST ['cd_usuario'])){
			$oVenta->setCd_usuario($_POST['cd_usuario']);
		}

		/*if (isset($_POST ['dt_fecha'])){
			$dt_fecha = str_replace("/","-", $_POST['dt_fecha']);
			$dt_fecha = implode("-", array_reverse(explode("-", $dt_fecha)));
			$oVenta->setDt_fecha($dt_fecha.' '.date('H:i:s'));
		}*/		$oVenta->setDt_fecha(date('Y-m-d H:i:s'));

		if(isset($_POST ['cd_formapago'])){
			$oVenta->setCd_formapago(addslashes($_POST ['cd_formapago']));
		}
		return $oVenta;
	}

}