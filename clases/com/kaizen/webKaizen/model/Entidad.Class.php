<?php
	
	class Entidad {
		private $cd_entidad;
		private $ds_entidad;
		
		//Método constructor 
		

		function Entidad() {
			
			$this->cd_entidad = 0;
			$this->ds_entidad = '';
		}
		
		//Métodos Get 
		

		function getCd_entidad() {
			return $this->cd_entidad;
		}
		
		function getDs_entidad() {
			return $this->ds_entidad;
		}
		
		//Métodos Set 
		

		function setCd_entidad($value) {
			$this->cd_entidad = $value;
		}
		
		function setDs_entidad($value) {
			$this->ds_entidad = $value;
		}
	
	}

