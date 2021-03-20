<?php

/**
 * @author bernardo
 * @since 31-03-2010
 * 
 * Utilizamos este objeto para representar
 * todas las entidad formadas por [ código + descripción ].
 */
class Referencia{
	
	private $cd_referencia;
	private $ds_referencia;
	
	//Método constructor
	function Referencia(){
		$this->cd_referencia=0;
		$this->ds_referencia='';
	}
	
	//Métodos Get 
	function getCd_referencia() {
		return $this->cd_referencia;
	}
	
	function getDs_referencia() {
		return $this->ds_referencia;
	}

	
	//Métodos Set

	function setCd_referencia($value) {
		$this->cd_referencia = $value;
	}
	
	function setDs_referencia($value) {
		$this->ds_referencia = $value;
	}

	//funciones
	public function __toString(){
		$texto = FormatUtils::ifEmpty( $this->cd_referencia , '' );
		if( !FormatUtils::isEmpty($this->cd_referencia ) )
			$texto .= ' - ' . $this->ds_referencia;
		else
			$texto .= $this->ds_referencia ;
		return $texto;	
    }
}