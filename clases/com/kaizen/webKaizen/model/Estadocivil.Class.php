<?php
	
	class Estadocivil {
		private $cd_estadocivil;
		private $ds_estadocivil;
		
		//M�todo constructor 
		

		function Estadocivil() {
			
			$this->cd_estadocivil = 0;
			$this->ds_estadocivil = '';
		}
		
		//M�todos Get 
		

		function getCd_estadocivil() {
			return $this->cd_estadocivil;
		}
		
		function getDs_estadocivil() {
			return $this->ds_estadocivil;
		}
		
		//M�todos Set 
		

		function setCd_estadocivil($value) {
			$this->cd_estadocivil = $value;
		}
		
		function setDs_estadocivil($value) {
			$this->ds_estadocivil = $value;
		}
	
	}

