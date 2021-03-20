<?php

/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Manager para clientes.
 *
 */
class SucursalManager implements IListar{

	/**
	 * se agrega una sucursal nueva.
	 * @param $oCliente a agregar.
	 */
	public function agregarSucursal(Sucursal $oSucursal){

		//persistir sucursal en la bbdd.
		SucursalQuery::insertSucursal( $oSucursal );
			
	}

	/**
	 * se modifica una sucursal.
	 * @param Sucursal $oSucursal a modificar.
	 */
	public function modificarSucursal(Sucursal $oSucursal){

		//persistir los cambios del cliente en la bbdd.
		SucursalQuery::modificarSucursal($oSucursal);
			
	}


	/**
	 * eliminar una sucursal.
	 * @param $cd_sucursal identificador de la sucursal a eliminar
	 */
	public function eliminarSucursal($cd_sucursal){

		$oSucursal = new Sucursal ();
		$oSucursal->setCd_sucursal ( $cd_sucursal );

		//TODO validaciones.

		//persistir los cambios en la bbdd.
		SucursalQuery::eliminarSucursal($oSucursal );

	}

	/**
	 * se listan sucursales.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getSucursales(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$sucursales = SucursalQuery::getSucursales($criterio);
		return $sucursales;
	}
	/**	 * se listan sucursales por stockpieza.	 * @param $criterio	 * @return unknown_type	 */	public function getSucursalesPorStockPieza(CriterioBusqueda $criterio){				$sucursales = SucursalQuery::getSucursalesPorStockPieza($criterio);		return $sucursales;	}


	/**
	 * obtiene una sucursal específica dada un identificador.
	 * @param $cd_sucursal identificador de la sucursal a recuperar
	 * @return unknown_type
	 */
	public function getSucursalPorId($cd_sucursal){
		if( !empty( $cd_sucursal )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('S.cd_sucursal', $cd_sucursal, '=');
			$oSucursal =  SucursalQuery::getSucursal( $criterio );
		}else{
			$oSucursal = new Sucursal();
		}
		return $oSucursal;
	}

	/**
	 * obtiene la cantidad de sucursales dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de sucursales
	 */
	public function getCantidadSucursales( CriterioBusqueda $criterio){
		$cant =  SucursalQuery::getCantSucursales( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getSucursales( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadSucursales( $criterio );
	}
}