<?php

/**
 *
 * @author Ma. Jes�s
 * @since 20-07-2011
 *
 * Manager para Stock Piezas.
 *
 */
class StockPiezaManager implements IListar{

	/**
	 * se agrega una pieza nueva.
	 * @param $oStockPieza a agregar.
	 */
	public function agregarStockPieza(StockPieza $oStockPieza){
		//persistir stock pieza en la bbdd.
		StockPiezaQuery::insertStockPieza( $oStockPieza );
		
		$this->actualizarStockPieza($oStockPieza);	
			
	}

	/**
	 * se modifica un stock pieza.
	 * @param StockPieza $oStockPieza a modificar.
	 */
	public function modificarStockPieza(StockPieza $oStockPieza){
		
		StockPiezaQuery::modificarStockPieza($oStockPieza);
		$this->actualizarStockPieza($oStockPieza);	
	}


	/**
	 * eliminar un stock pieza.
	 * @param $cd_stockpieza identificador del stock pieza a eliminar
	 */
	public function eliminarStockPieza($cd_stockpieza){
		
		//persistir los cambios en la bbdd.
		StockPiezaQuery::eliminarStockPieza($oStockPieza );
		
		$this->actualizarStockPieza($oStockPieza);	

	}

	/**
	 * se listan stock piezas.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getStockPiezas(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$stockpiezas = StockPiezaQuery::getStockPiezas($criterio);
		return $stockpiezas;
	}

	/**
	 * obtiene un stock pieza espec�fico dado un identificador.
	 * @param $cd_stockpieza identificador del stock pieza a recuperar
	 * @return unknown_type
	 */
	public function getStockPiezaPorId($cd_stockpieza){
		if( !empty( $cd_stockpieza )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('SP.cd_stockpieza', $cd_stockpieza, '=');
			$oStockPieza =  StockPiezaQuery::getStockPieza ( $criterio );
		}else{
			$oStockPieza = new StockPieza();
		}
		return $oStockPieza;
	}

	/**
	 * obtiene la cantidad de stock piezas dado un filtro.
	 * @param $filtro filtro de b�squeda.
	 * @return cantidad de stock piezas
	 */
	public function getCantidadStockPiezas( CriterioBusqueda $criterio){
		$cant = StockPiezaQuery::getCantStockPiezas( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getStockPiezas( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadStockPiezas( $criterio );
	}
}