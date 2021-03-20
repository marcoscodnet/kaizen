<?php
/**
 * Formatea un valor a usar en el criterio de búsqueda
 * 
 * @author bernardo
 * @since 06-05-10
 *
 */
class FormatValorDate extends FormatValor{
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/dao/criterio/FormatValor#format($value)
	 */
	public function format($value){
		return FuncionesComunes::fechaPHPaMysql ( $value );
	}
}
?>