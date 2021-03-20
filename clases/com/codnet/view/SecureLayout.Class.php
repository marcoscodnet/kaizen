<?php

/**
 * Se define una interfaz para aquellos layouts
 * utilizados en las acciones seguros (SecureAction).
 *  
 * @author bernardo
 * @since 07-04-2010
 */
interface SecureLayout{

	/**
	 * se setea el menú.
	 * @return unknown_type
	 */
	function setMenu($value);
	
	/**
	 * se setea el contenido.
	 * @return unknown_type
	 */
	function setContenido($value);
	
	/**
	 * se setea el título.
	 * @return unknown_type
	 */
	function setTitulo($value);

	/**
	 * contenido del layout.
	 * @return unknown_type
	 */
	function showLayout();	
}
