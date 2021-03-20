<?php
/**
 * Para representar un filtro de búsqueda.
 * 
 * @author bernardo
 * @since 25-08-10
 *
 */
class Filtro extends Expresion{

	private $campo;
	private $valor;
	private $operador;
	private $formato;
		
	public function Filtro($campo, $valor, $operador, $format=null){
		if(empty($format))
			$format = new FormatValor();
		$this->campo = $campo;
		$this->operador=$operador;
		$this->valor = $valor;
		$this->formato = $format;
	}
	
	public function build(){
		$filtro = '' ;
		$valor = $this->formato->format( $this->valor );
		$filtro .= " ( $this->campo $this->operador $valor ) ";
		return $filtro;		
	}
	
	public function getValor(){
		return $this->valor;
	}	
	
}
	
?>