<?php
class VentaPiezaComparator implements IItemComparator{
	
	function equals( $oObjeto1, $oObjeto2){
		return ($oObjeto1->getPieza()->getCd_pieza() == $oObjeto1->getPieza()->getCd_pieza());
	
	}
	
}