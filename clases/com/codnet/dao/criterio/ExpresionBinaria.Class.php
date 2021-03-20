<?php
/**
 * Para representar una expresión binaria.
 * 
 * Ej: X AND Y
 * 
 * @author bernardo
 * @since 25-08-10
 *
 */
class ExpresionBinaria extends Expresion{

	private $operador;
	private $oExpressionIzquierda;
	private $oExpressionDerecha;
	
	public function ExpresionBinaria( $operador="AND", Expresion $izq, Expresion $der){
		$this->operador = $operador;
		$this->oExpressionIzquierda = $izq;
		$this->oExpressionDerecha = $der;
	}
	
	public function build(){
		return " ( " . $this->oExpressionIzquierda->build() . " $this->operador " . $this->oExpressionDerecha->build() . " ) ";  	
	}
	
}
	
?>