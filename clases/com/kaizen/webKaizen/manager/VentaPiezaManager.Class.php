<?php

/**
 *
 * @author Mar�a Jes�s
 * @since 11-11-2011
 *
 * Manager para venta de pieza.
 *
 */
class VentaPiezaManager implements IListar {

	/**
	 * se agrega una venta nueva.
	 * @param $oVenta a agregar.
	 */
	public function agregarVentaPieza(VentaPieza $oVentaPieza, array $piezas) {


		$this->actualizarStock($oVentaPieza, $piezas);


		//persistir perfil en la bbdd.
		VentaPiezaQuery::insertVentaPieza($oVentaPieza);

		//persistir las funciones asociadas al perfil.
		PiezaVentaPiezaQuery::insertarPiezasDeVentaPieza ( $oVentaPieza, $piezas );

	}

	/**
	 * se actualiza el stock.
	 * @param $oRemito remito de donde se eliminan los productos.
	 * @return unknown_type
	 */
	protected function actualizarStock(VentaPieza $oVentaPieza, array $piezas ){

		//actualizamos el stock de cada pieza.
		//se le suma o resta al producto la cantidad retirada dependiendo
		//del stockpieza.
		foreach ($piezas as $key => $pieza){

				$managerStockPieza = new StockPiezaManager();
			 	$criterio = new CriterioBusqueda();
				$criterio->addFiltro('SP.cd_pieza', $pieza->getCd_pieza(), "=");
				$criterio->addFiltro('SP.cd_sucursal', $pieza->getSucursalOrigen()->getCd_sucursal(), "=");
				$stockpiezas = $managerStockPieza->getStockPiezas($criterio);
				$nu_cantidad = $pieza->getPieza()->getNu_cantidadpedida();
				foreach ($stockpiezas as $oStockPieza) {

					if ($oStockPieza->getNu_cantidad()>=$nu_cantidad) {
						$oStockPieza->setNu_cantidad($oStockPieza->getNu_cantidad()-$nu_cantidad);
						$nu_cantidad=0;
					}
					else{
						$nu_cantidad -=$oStockPieza->getNu_cantidad();
						$oStockPieza->setNu_cantidad(0);

					}
					if ($oStockPieza->getNu_cantidad()==0) {
						$managerStockPieza->eliminarStockPieza($oStockPieza->getCd_stockpieza());
					}
					else{
						$oStockPieza->setDt_ingreso(str_replace("/", "-",$oStockPieza->getDt_ingreso())) ;
                        $oStockPieza->setDt_ingreso (implode("-", array_reverse(explode("-", $oStockPieza->getDt_ingreso()))));
						$managerStockPieza->modificarStockPieza($oStockPieza);
					}
				}
				/*$managerPieza = new PiezaManager();
				$oPieza=$managerPieza->getPiezaPorId($pieza->getCd_pieza());
				$oPieza->setNu_stock_actual($oPieza->getNu_stock_actual()-$pieza->getPieza()->getNu_cantidadpedida());
				$managerPieza->modificarPieza($oPieza);*/

		}



	}

/**
	 *
	 * @param
	 * @return unknown_type
	 */
	public function consultarStock(VentaPieza $oVentaPieza ){



		$managerStockPieza = new StockPiezaManager();
	 	$criterio = new CriterioBusqueda();
		$criterio->addFiltro('SP.cd_pieza', $oVentaPieza->getCd_pieza(), "=");
		$criterio->addFiltro('SP.cd_sucursal', $oVentaPieza->getSucursalOrigen()->getCd_sucursal(), "=");
		$cantActual = $managerStockPieza->getSumStockPiezas($criterio);
		$_SESSION['stockActual']=$cantActual;
		if ($cantActual<$oVentaPieza->getPieza()->getNu_cantidadpedida()) {
			return false;
		}
		else return true;



	}


	public function modificarVentaPieza(VentaPieza $oVentaPieza) {
		//persistir los cambios del cliente en la bbdd.
		VentaPiezaQuery::modificarVentaPieza($oVentaPieza);
	}

	public function getPiezasDeVentaPieza($cd_ventapieza){
		$piezas = PiezaVentaPiezaQuery::getPiezasDeVentaPieza($cd_ventapieza);
		return $piezas;
	}

	public function getVentaPiezaUnidades($cd_ventapieza){
		$ventapiezasunidades = PiezaVentaPiezaQuery::getVentaPiezaUnidades($cd_ventapieza);
		return $ventapiezasunidades;
	}

	/**
	 * eliminar un movimiento.
	 * @param $cd_cliente identificador del cliente a eliminar
	 */
	public function eliminarVentaPieza($cd_ventapieza) {
		$oVentaPieza = new VentaPieza ();
		$oVentaPieza->setCd_ventapieza($cd_ventapieza);
		$ventapiezasunidades = $this->getVentaPiezaUnidades($cd_ventapieza);
		$oStockPiezaManager = new StockPiezaManager();
		foreach ($ventapiezasunidades as $oVentaPiezaUnidad) {
			if ($oVentaPiezaUnidad->getNu_cantidadpedida()) {
				$oStockPieza = new StockPieza();
				$oStockPieza->setCd_pieza($oVentaPiezaUnidad->getPieza()->getCd_pieza());
				$oStockPieza->setNu_cantidad( $oVentaPiezaUnidad->getNu_cantidadpedida() );
				$oStockPieza->setCd_sucursal ($oVentaPiezaUnidad->getSucursal()->getCd_sucursal()) ;
				$oStockPieza->setDt_ingreso(date("d-m-Y")) ;
				$oStockPieza->setDs_remito("venta anulada") ;
				$oStockPiezaManager->agregarStockPieza($oStockPieza);
			}



		}
		VentaPiezaQuery::eliminarVentaPieza($oVentaPieza);
		PiezaVentaPiezaQuery::eliminarPiezasDeVentaPieza ($oVentaPieza);

	}

	/**
	 * se listan movimientos.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getVentasPiezas(CriterioBusqueda $criterio=null) {
		$criterio = FormatUtils::ifEmpty($criterio, new CriterioBusqueda());

		$ventaspiezas = VentaPiezaQuery::getVentasPiezas($criterio);

		return $ventaspiezas;
	}

	/**
	 * obtiene un cliente espec�fico dado un identificador.
	 * @param $cd_cliente identificador del cliente a recuperar
	 * @return unknown_type
	 */
	public function getVentaPiezaPorId($cd_ventapieza) {
		if (!empty($cd_ventapieza)) {
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('VP.cd_ventapieza', $cd_ventapieza, '=');
			$oVentaPieza = VentaPiezaQuery::getVentaPieza($criterio);
		} else {
			$oVentaPieza = new VentaPieza();
		}
		return $oVentaPieza;
	}

	/**
	 * obtiene la cantidad de clientes dado un filtro.
	 * @param $filtro filtro de b�squeda.
	 * @return cantidad de clientes
	 */
	public function getCantidadVentasPiezas(CriterioBusqueda $criterio) {
		$cant = VentaPiezaQuery::getCantVentasPiezas($criterio);
		return $cant;
	}

	//INTERFACE IListar.

	function getEntidades(CriterioBusqueda $criterio) {
		return $this->getVentasPiezas($criterio);
	}

	function getCantidadEntidades(CriterioBusqueda $criterio) {
		return $this->getCantidadVentasPiezas($criterio);
	}

}
