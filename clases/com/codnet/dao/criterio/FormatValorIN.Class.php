<?php
/**
 * Formatea un valor a usar en el criterio de búsqueda
 * 
 * @author bernardo
 * @since 31-08-10
 *
 */
class FormatValorIN extends FormatValor{
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/dao/criterio/FormatValor#format($value)
	 */
	public function format($value){
		return "(" . $value . ")";
	}
}
?>