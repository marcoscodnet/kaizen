<?php

class ItempagoManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new ItempagoQuery();
	}

	public function agregarItempago(Itempago $oItempago){
		//persistir color en la bbdd.
		ItempagoQuery::insertItempago( $oItempago );
	}

	public function modificarItempago(Itempago $oItempago){
		//persistir los cambios de la color en la bbdd.
		ItempagoQuery::modificarItempago($oItempago);
	}

	public function eliminarItempago($oItempago){
		ItempagoQuery::eliminarItempago($oItempago);
	}
	
	public function eliminarItemspagos($criterio){
		ItempagoQuery::eliminarItemspagos($criterio);
	}

	public function getItemspago(CriterioBusqueda $criterio){
		$itemspagos = ItempagoQuery::getItemspago($criterio);
		return $itemspagos;
	}

}