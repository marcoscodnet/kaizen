<?php

class MovimientoManager implements IListar {

	public function agregarMovimiento(Movimiento $oMovimiento, array $unidades) {
			
		//persistir perfil en la bbdd.
		MovimientoQuery::insertMovimiento($oMovimiento);

		//persistir las funciones asociadas al perfil.
		UnidadMovimientoQuery::insertarUnidadesDeMovimiento ( $oMovimiento, $unidades );

		//Recorro las unidades y modifico la sucursal actual
		$cd_sucursaldestino = $oMovimiento->getCd_sucursaldestino();
		$oUnidadManager = new UnidadManager();
		if (is_array($unidades)){
			foreach($unidades as $unidad){
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($unidad->getCd_unidad());
				$oUnidad->setCd_sucursalactual($cd_sucursaldestino);
				$oUnidadManager->modificarSucursalDeUnidad ( $oUnidad );
			}
		}

	}

	public function modificarMovimiento(Movimiento $oMovimiento) {
		//persistir los cambios del cliente en la bbdd.
		MovimientoQuery::modificarMovimiento($oMovimiento);
	}

	public function getUnidadesDeMovimiento($cd_movimiento){
		$unidades = UnidadMovimientoQuery::getUnidadesDeMovimiento($cd_movimiento);
		return $unidades;
	}

	/**
	 * eliminar un movimiento.
	 * @param $cd_cliente identificador del cliente a eliminar
	 */
	public function eliminarMovimiento($cd_movimiento) {
		$oMovimiento = new Movimiento ();
		$oMovimiento->setCd_movimiento($cd_movimiento);
		MovimientoQuery::eliminarMovimiento($oMovimiento);
	}

	/**
	 * se listan movimientos.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getMovimientos(CriterioBusqueda $criterio=null) {
		$criterio = FormatUtils::ifEmpty($criterio, new CriterioBusqueda());
		$movimientos = MovimientoQuery::getMovimientos($criterio);
		return $movimientos;
	}

	/**
	 * obtiene un cliente espec�fico dado un identificador.
	 * @param $cd_cliente identificador del cliente a recuperar
	 * @return unknown_type
	 */
	public function getMovimientoPorId($cd_movimiento) {
		if (!empty($cd_movimiento)) {
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('M.cd_movimiento', $cd_movimiento, '=');
			$oMovimiento = MovimientoQuery::getMovimiento($criterio);
		} else {
			$oMovimiento = new Movimiento();
		}
		return $oMovimiento;
	}

	/**
	 * obtiene la cantidad de clientes dado un filtro.
	 * @param $filtro filtro de b�squeda.
	 * @return cantidad de clientes
	 */
	public function getCantidadMovimientos(CriterioBusqueda $criterio) {
		$cant = MovimientoQuery::getCantMovimientos($criterio);
		return $cant;
	}

	//INTERFACE IListar.

	function getEntidades(CriterioBusqueda $criterio) {
		return $this->getMovimientos($criterio);
	}

	function getCantidadEntidades(CriterioBusqueda $criterio) {
		return $this->getCantidadMovimientos($criterio);
	}

}
?>