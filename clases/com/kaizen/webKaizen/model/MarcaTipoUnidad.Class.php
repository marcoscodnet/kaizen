<?php	
	class MarcaTipoUnidad {
		private $cd_marca;
		private $cd_Tipounidad;
		
		//M�todo constructor 
		

		function Perfilfuncion() {			
			$this->cd_marca = 0;
			$this->cd_Tipounidad = '';
		}
		
		//M�todos Get 
		

		function getCd_marca() {
			return $this->cd_marca;
		}
		
		function getCd_tipounidad() {
			return $this->cd_tipounidad;
		}
		
		//M�todos Set 
		

		function setCd_marca($value) {
			$this->cd_marca = $value;
		}
		
		function setCd_tipounidad($value) {
			$this->cd_tipounidad = $value;
		}
	
	}
?>
