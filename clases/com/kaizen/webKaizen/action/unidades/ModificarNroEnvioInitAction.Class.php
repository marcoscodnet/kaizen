<?php

/**
 * Acción para inicializar el contexto para modificar
 * una venta.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ModificarNroEnvioInitAction extends EditarUnidadInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Nro Envio";
	}

	protected function getXTemplate() {
		return new XTemplate(APP_PATH . '/unidades/editarnroenvio.html');
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Nro Envio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_nroenvio";
	}

	protected function getEntidad(){
		$oUnidad = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_unidad = $_GET ['id'];

			$manager = new UnidadManager();
			$oUnidad = $manager->getUnidadPorId( $cd_unidad );
		}

		return $oUnidad;
	}


	protected function parseUnidad(Unidad $oUnidad, XTemplate $xtpl) {
		//se muestra el unidad.
		$xtpl->assign('cd_unidad', $oUnidad->getCd_unidad());
		$xtpl->assign('nu_motor', stripslashes($oUnidad->getNu_motor()));
		$xtpl->assign('readonly_numotor', "readonly");
		$xtpl->assign('nu_cuadro', stripslashes($oUnidad->getNu_cuadro()));
		$xtpl->assign('readonly_nucuadro', "readonly");

		$xtpl->assign('dt_ingreso', stripslashes($oUnidad->getDt_ingreso()));
		$xtpl->assign('readonly_dt_ingreso', "readonly");
		$xtpl->assign('nu_patente', stripslashes($oUnidad->getNu_patente()));
		//$xtpl->assign('readonly_nupatente', "readonly");
		$xtpl->assign('nu_remitoingreso', stripslashes($oUnidad->getNu_remitoingreso()));
		$xtpl->assign('readonly_nuremito', "readonly");
		$xtpl->assign('nu_aniomodelo', stripslashes($oUnidad->getNu_aniomodelo()));
		//$xtpl->assign('readonly_numodelo', "readonly");
		$xtpl->assign('cd_sucursal_actual', stripslashes($oUnidad->getCd_sucursalactual()));
		$xtpl->assign('disabled_sucursal', "disabled");
		$xtpl->assign('ds_observacion', stripslashes($oUnidad->getDs_observacion()));
		$xtpl->assign('nu_envio', stripslashes($oUnidad->getNu_envio()));

		$xtpl->assign('disabled', "disabled");
		$input = "<input type='hidden' name='cd_producto' id='cd_producto' value='" . $oUnidad->getCd_producto() . "'/>";
		$xtpl->assign('producto_hidden', $input);

	}

	protected function parseSucursales($cd_selected='', XTemplate $xtpl) {
		$sucursalManager = new SucursalManager();
		$criterio = new CriterioBusqueda();
		$sucursal = $sucursalManager->getSucursalPorId($cd_selected);

		$xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());
		$xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));
		$xtpl->parse('main.option_sucursal');

	}
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}