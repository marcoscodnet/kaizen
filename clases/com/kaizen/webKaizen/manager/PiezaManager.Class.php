<?php

/**
 *
 * @author Ma. Jesús
 * @since 18-06-2011
 *
 * Manager para Piezas.
 *
 */
class PiezaManager implements IListar{

	/**
	 * se agrega una pieza nueva.
	 * @param $oPieza a agregar.
	 */
	public function agregarPieza(Pieza $oPieza){
		//persistir pieza en la bbdd.
		PiezaQuery::insertPieza( $oPieza );
			
	}

	/**
	 * se modifica una pieza.
	 * @param Pieza $oPieza a modificar.
	 */
	public function modificarPieza(Pieza $oPieza){
		//persistir los cambios de la pieza en la bbdd.
		PiezaQuery::modificarPieza($oPieza);
			
	}


	/**
	 * eliminar un pieza.
	 * @param $cd_pieza identificador de la pieza a eliminar
	 */
	public function eliminarPieza($cd_pieza){

		$oPieza = new Pieza ();
		$oPieza->setCd_pieza ( $cd_pieza );

		//TODO validaciones.

		//persistir los cambios en la bbdd.
		PiezaQuery::eliminarPieza($oPieza );

	}

	/**
	 * se listan piezas.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getPiezas(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$piezas = PiezaQuery::getPiezas($criterio);
		return $piezas;
	}

	/**
	 * obtiene una pieza específico dado un identificador.
	 * @param $cd_pieza identificador de la pieza a recuperar
	 * @return unknown_type
	 */
	public function getPiezaPorId($cd_pieza){
		if( !empty( $cd_pieza )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('P.cd_pieza', $cd_pieza, '=');
			$oPieza =  PiezaQuery::getPieza ( $criterio );
		}else{
			$oPieza = new Pieza();
		}
		return $oPieza;
	}

	/**
	 * obtiene la cantidad de piezas dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de piezas
	 */
	public function getCantidadPiezas( CriterioBusqueda $criterio){
		$cant = PiezaQuery::getCantPiezas( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getPiezas( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadPiezas( $criterio );
	}		public function getPiezasPorSucursal(CriterioBusqueda $criterio){		//$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());		$piezas = PiezaQuery::getPiezasPorSucursal( $criterio );			return $piezas;	}		public function getCantidadPiezasPorSucursal( CriterioBusqueda $criterio){		$cant =  PiezaQuery::getCantPiezasPorSucursal( $criterio );		return $cant;	}	
}