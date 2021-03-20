<?php
	
	class Modelo {
		private $cd_modelo;
		private $ds_modelo;
		private $oMarca;
		
		//Método constructor 
		

		function Modelo() {
			$this->cd_modelo = 0;
			$this->ds_modelo = '';
			$this->oMarca = new Marca();
		}
		
		//Métodos Get 
		

		function getCd_modelo() {
			return $this->cd_modelo;
		}
		
		function getDs_modelo() {
			return $this->ds_modelo;
		}
		
		function getCd_marca() {
			return $this->oMarca->getCd_marca();
		}
		
		function getDs_marca() {
			return $this->oMarca->getDs_marca();
		}
		
		function getMarca() {
			return $this->oMarca;
		}
		
		//Métodos Set 
		

		function setCd_modelo($value) {
			$this->cd_modelo = $value;
		}
		
		function setDs_modelo($value) {
			$this->ds_modelo = $value;
		}
		
		function setCd_marca($value) {
			$this->oMarca->setCd_marca( $value );
		}
		
		function setPais($value) {
			$this->oMarca = $value ;
		}
	
	}

