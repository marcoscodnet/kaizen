<?php

/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Manager para clientes.
 *
 */
class VentaManager implements IListar {

	/**
	 * se agrega una venta nueva.
	 * @param $oVenta a agregar.
	 */
	public function agregarVenta(Venta $oVenta) {
		//persistir cliente en la bbdd.
		$unidadManager = new UnidadManager();
		$oUnidad = $unidadManager->getUnidadPorId($oVenta->getCd_unidad());
		$oVenta->setNu_montosugerido($oUnidad->getNu_monto_sugerido());
		VentaQuery::insertVenta($oVenta);
	}

	public function insertPagosDeVenta(Venta $oVenta, ItemCollection $creditos) {
		VentaQuery::insertPagosDeVenta($oVenta, $creditos);
	}

	public function insertarPagoDeVenta(Itempago $itempago) {
		ItempagoQuery::insertItempago($itempago);
	}

	public function modificarPagoDeVenta(Itempago $itempago) {
		ItempagoQuery::modificarItempago($itempago);
	}

	public function getImporteTotalEnVentas(CriterioBusqueda $criterio) {
		$criterio1 = clone $criterio;
		$criterio1->addFiltro("UN.cd_unidad", "SELECT A.cd_unidad FROM autorizacion A", "IN", new FormatValorIN());
		$suma = VentaQuery::getImporteTotalEnVentas($criterio1);
		return $suma;
	}

	public function getImporteAcreditadoEnVentasContado(CriterioBusqueda $criterio) {
		$criterio->addFiltro("UN.cd_unidad", "SELECT A.cd_unidad FROM autorizacion A", "IN", new FormatValorIN());
		$criterio->addFiltro("V.cd_venta", "SELECT TMPIP.cd_venta FROM itempago TMPIP", "NOT IN", new FormatValorIN());
		$suma = VentaQuery::getImporteAcreditadoEnVentasContado($criterio);
		echo $suma;
		return $suma;
	}

	public function getImporteAcreditadoEnVentas(CriterioBusqueda $criterio) {
		$criterio1 = clone $criterio;
		$criterio1->addFiltro("UN.cd_unidad", "SELECT A.cd_unidad FROM autorizacion A", "IN", new FormatValorIN());
		$criterio1->addFiltro("V.cd_venta", "SELECT TMPIP.cd_venta FROM itempago TMPIP", "IN", new FormatValorIN());
		$suma = VentaQuery::getImporteAcreditadoEnVentas($criterio1);
		return $suma;
	}

	public function getCantVentasAutorizadas($criterio) {
		$tmp_criterio = clone $criterio;
		$tmp_criterio->addFiltro("UN.cd_unidad", "SELECT A.cd_unidad FROM autorizacion A", "IN", new FormatValorIN());
		$cant_ventas_autorizadas = $this->getCantidadVentas($tmp_criterio);
		return $cant_ventas_autorizadas;
	}

	public function getCantVentasNoAutorizadas($criterio) {
		$tmp_criterio = clone $criterio;
		$tmp_criterio->addFiltro("UN.cd_unidad", "SELECT A.cd_unidad FROM autorizacion A", "NOT IN", new FormatValorIN());
		$cant_ventas_no_autorizadas = $this->getCantidadVentas($tmp_criterio);
		return $cant_ventas_no_autorizadas;
	}

	/*public function getImporteAcreditadoEnVentas(CriterioBusqueda $criterio) {
		$criterio1 = clone $criterio;
		$acreditado_credito = $this->getImporteAcreditadoEnVentas($criterio1);
		return $acreditado_credito;
		}*/

	public function modificarVenta(Venta $oVenta) {
		//persistir los cambios del cliente en la bbdd.
		VentaQuery::modificarVenta($oVenta);
	}

	public function eliminarVenta(Venta $oVenta) {
		$itempagoManager = new ItempagoManager();
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro("cd_venta", $oVenta->getCd_venta(), "=");
		$itempagoManager->eliminarItemspagos($criterio);
		//persistir los cambios del cliente en la bbdd.
		VentaQuery::eliminarVenta($oVenta);
	}

	/**
	 * se listan ventas.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getVentas(CriterioBusqueda $criterio=null) {
		$criterio = FormatUtils::ifEmpty($criterio, new CriterioBusqueda());
		$ventas = VentaQuery::getVentas($criterio);

		return $ventas;
	}

	/**
	 * obtiene una venta especifico dado un identificador.
	 * @param $cd_venta identificador de la venta a recuperar
	 * @return unknown_type
	 */
	public function getVentaPorId($cd_venta) {
		if (!empty($cd_venta)) {
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('V.cd_venta', $cd_venta, '=');
			$oVenta = VentaQuery::getVenta($criterio);
		} else {
			$oVenta = new Venta();
		}
		return $oVenta;
	}

	/**
	 * obtiene la cantidad de ventas dado un filtro.
	 * @param $filtro filtro de busqueda.
	 * @return cantidad de ventas
	 */
	public function getCantidadVentas(CriterioBusqueda $criterio) {
		$cant = VentaQuery::getCantVentas($criterio);
		return $cant;
	}

	//INTERFACE IListar.

	function getEntidades(CriterioBusqueda $criterio) {
		return $this->getVentas($criterio);
	}

	function getCantidadEntidades(CriterioBusqueda $criterio) {
		return $this->getCantidadVentas($criterio);
	}

}