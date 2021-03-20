<?php	
	class MarcaTipoUnidad {
		private $cd_marca;
		private $cd_Tipounidad;
		
		//Método constructor 
		

		function Perfilfuncion() {			
			$this->cd_marca = 0;
			$this->cd_Tipounidad = '';
		}
		
		//Métodos Get 
		

		function getCd_marca() {
			return $this->cd_marca;
		}
		
		function getCd_tipounidad() {
			return $this->cd_tipounidad;
		}
		
		//Métodos Set 
		

		function setCd_marca($value) {
			$this->cd_marca = $value;
		}
		
		function setCd_tipounidad($value) {
			$this->cd_tipounidad = $value;
		}
	
	}
?>
