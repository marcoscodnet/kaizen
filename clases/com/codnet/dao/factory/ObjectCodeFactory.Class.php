<?php
/**
 * 
 * @author bernardo
 * @since 20-04-2010
 * 
 * Construye un objeto.
 *
 */

interface ObjectCodeFactory extends ObjectFactory{
	
	/**
	 * retorna el identificar de un objeto.
	 * @param unknown_type $next
	 * @return identificador
	 */
	function getCode($anObject);
}
?>