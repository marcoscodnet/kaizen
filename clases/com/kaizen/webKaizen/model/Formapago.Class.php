<?php
	
	class Formapago {
		private $cd_formapago;
		private $ds_formapago;
		
		//M�todo constructor 
		

		function Formapago() {
			
			$this->cd_formapago = 0;
			$this->ds_formapago = '';
		}
		
		//M�todos Get 
		function getCd_formapago() {
			return $this->cd_formapago;
		}
		
		function getDs_formapago() {
			return $this->ds_formapago;
		}
		
		//M�todos Set 
		

		function setCd_formapago($value) {
			$this->cd_formapago = $value;
		}
		
		function setDs_formapago($value) {
			$this->ds_formapago = $value;
		}
	
	}

