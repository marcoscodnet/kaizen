<?php
/**
 * Para representar la expresi�n del criterio de b�squeda.
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