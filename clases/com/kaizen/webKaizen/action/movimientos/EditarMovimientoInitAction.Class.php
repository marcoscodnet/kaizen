<?php

/**
 * Acci�n para inicializar el contexto para editar
 * un movimiento.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
abstract class EditarMovimientoInitAction extends EditarInitAction {

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate() {
		return new XTemplate(APP_PATH . '/movimientos/editarMovimiento.html');
	}

	protected function getEntidad() {
		$oUnidad = null;

	}

	protected function parseEntidad($entidad, XTemplate $xtpl) {
		$oMovimiento = FormatUtils::ifEmpty($entidad, new Movimiento());
		//se muestra el Movimiento.
		$xtpl->assign('dt_movimiento', date("d/m/Y"));

		$cd_sucursalorigen = $this->parseUnidades($xtpl);
		$this->parseSucursalesOrigen($cd_sucursalorigen, $xtpl);
		$this->parseSucursales($xtpl, $cd_sucursalorigen);
		$this->parseProductos($xtpl, $cd_sucursalorigen);
	}

	protected function parseUnidades(XTemplate $xtpl){
		$cd_sucursal = "";
		if(isset($_SESSION['unidadesamover']) && (count($_SESSION['unidadesamover'])>0)){
			$xtpl->assign('listado_unidades', "1");
			foreach($_SESSION['unidadesamover'] as $indice=>$movimiento){
				$cd_sucursal = $movimiento->getSucursalOrigen()->getCd_sucursal();
				$xtpl->assign('ds_sucursalorigen', $movimiento->getSucursalOrigen()->getDs_nombre());
				$xtpl->assign('nu_motor', $movimiento->getUnidad()->getNu_motor());
				$xtpl->assign('nu_cuadro', $movimiento->getUnidad()->getNu_cuadro());
				$xtpl->assign('ds_producto', $movimiento->getUnidad()->getDs_producto());
				$xtpl->assign('indice', $indice);
				$xtpl->parse('main.filas');
			}
		}else{
			$xtpl->assign('listado_unidades', "");
		}

		return $cd_sucursal;
	}

	protected function parseProductos(XTemplate $xtpl, $cd_sucursalorigen =0) {
		$productoManager = new ProductoManager();
		$criterio = new CriterioBusqueda();
		$criterio->addOrden('ds_tipo_unidad, ds_marca, ds_modelo, ds_color');
		if($cd_sucursalorigen != 0 ){
			$productos = $productoManager->getProductoEnSucursal($cd_sucursalorigen);
		}else{
			$productos = $productoManager->getProductos($criterio);
		}

		foreach ($productos as $key => $producto) {
			$xtpl->assign('ds_producto', $producto->getDs_producto());
			$xtpl->assign('cd_producto', $producto->getCd_producto());
			$xtpl->parse('main.option_producto');
		}
	}
	private function getSucursales(){
		$sucursalManager = new SucursalManager();
		$criterio = new CriterioBusqueda();
		$sucursales = $sucursalManager->getSucursales($criterio);
		return $sucursales;
	}

	protected function parseSucursalesOrigen($cd_selected="", XTemplate $xtpl) {
		$sucursales = $this->getSucursales();
		if($cd_selected != ""){
			$xtpl->assign('disabled_origen', "disabled");
			$input_hidden = "<input type='hidden' name='cd_sucursalorigen' id='cd_sucursalorigen' value='$cd_selected' />";
			$xtpl->assign('sucursal_hidden', "$input_hidden");
		}
		foreach ($sucursales as $key => $sucursal) {
			$xtpl->assign('ds_sucursalorigen', $sucursal->getDs_nombre());
			$xtpl->assign('cd_sucursalorigen', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));
			$xtpl->parse('main.option_sucursalorigen');
		}
	}

	protected function parseSucursales(XTemplate $xtpl, $cd_sucursalorigen="") {
		$sucursales = $this->getSucursales();

		foreach ($sucursales as $key => $sucursal) {
			if($sucursal->getCd_sucursal() != $cd_sucursalorigen){
				$xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());
				$xtpl->assign('cd_sucursal', $sucursal->getCd_sucursal());
				$xtpl->parse('main.option_sucursal');
			}
		}
	}

}