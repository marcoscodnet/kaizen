<?php
/**
 * 
 * @author bernardo
 * @since 04-03-2010
 * 
 * Construye un objeto.
 *
 */

interface ObjectFactory {
	
	/**
	 * construye un objeto dada la fila corriente de la consulta.
	 * @param $next lectura corriente de una consulta.
	 * @return objeto mapeado.
	 */
	public function build($next);
}
?>