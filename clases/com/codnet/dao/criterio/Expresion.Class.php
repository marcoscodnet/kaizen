<?php
/**
 * Para representar la expresión del criterio de búsqueda.
 * 
 * Ej: X AND Y AND (Z OR ( Y AND W) )
 * 
 * @author bernardo
 * @since 25-08-10
 *
 */
abstract class Expresion{

	public abstract function build();
	
}
	
?>