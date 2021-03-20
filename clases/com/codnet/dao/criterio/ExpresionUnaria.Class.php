<?php
/**
 * Para representar una expresión unaria.
 * 
 * Ej: NOT Y
 * 
 * @author bernardo
 * @since 25-08-10
 *
 */
class ExpresionUnaria extends Expresion{

	private $operador;
	private $operadorAdelante;
	private $oExpression;
	
	public function ExpresionUnaria( $operador="NOT", Expresion $exp, $operadorAdelante=true){
		$this->operador = $operador;
		$this->operadorAdelante = $operadorAdelante;
		$this->oExpression = $exp;
	}
	
	public function build(){
		if( $this->operadorAdelante )
			return  " ( $this->operador " . $this->oExpression->build() . " ) ";
		else  
			return  " ( " . $this->oExpression->build() . "  $this->operador ) ";	
	}
	
}
	
?>