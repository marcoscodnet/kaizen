<?php

/**
 *
 * @author Ma. Jesús
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
						//persistir los cambios del stock pieza en la bbdd.
		StockPiezaQuery::modificarStockPieza($oStockPieza);		
		$this->actualizarStockPieza($oStockPieza);	
	}
		/**	 * actualizar el stock actual de un pieza.	 * @param $oStockPieza	 */	public function actualizarStockPieza($oStockPieza){				//Actualiza el stock de la pieza.				$nu_cantidad=0;		$cd_pieza = $oStockPieza->getCd_pieza();			 	$criterio = new CriterioBusqueda();		$criterio->addFiltro('SP.cd_pieza', $cd_pieza, "=");				$nu_cantidad = $this->getSumStockPiezas($criterio);						$oPiezaManager = new PiezaManager();		$oPieza = $oPiezaManager->getPiezaPorId ( $cd_pieza );		//if( !empty( $nu_cantidad ))			$oPieza->setNu_stock_actual($nu_cantidad);		if( $oStockPieza->getQt_costo()!= null )			$oPieza->setQt_costo($oStockPieza->getQt_costo());		if( $oStockPieza->getQt_minimo() != null)			$oPieza->setQt_minimo($oStockPieza->getQt_minimo());		$oPiezaManager->modificarPieza ( $oPieza );			}	

	/**
	 * eliminar un stock pieza.
	 * @param $cd_stockpieza identificador del stock pieza a eliminar
	 */
	public function eliminarStockPieza($cd_stockpieza){		$oStockPieza = $this->getStockPiezaPorId ( $cd_stockpieza );
		
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
	}	/**	 * obtiene la suma del stock para .	 * @param $criterio	 * @return unknown_type	 */	public function getSumStockPiezas(CriterioBusqueda $criterio=null){		//$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());		$cant = StockPiezaQuery::getSumStockPiezas($criterio);				return $cant;	}

	/**
	 * obtiene un stock pieza específico dado un identificador.
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
	 * @param $filtro filtro de búsqueda.
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