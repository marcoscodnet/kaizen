<?php
	
	class Color {
		private $cd_color;
		private $ds_color;
		
		//M�todo constructor 
		

		function Color() {
			
			$this->cd_color = 0;
			$this->ds_color = '';
		}
		
		//M�todos Get 
		

		function getCd_color() {
			return $this->cd_color;
		}
		
		function getDs_color() {
			return $this->ds_color;
		}
		
		//M�todos Set 
		

		function setCd_color($value) {
			$this->cd_color = $value;
		}
		
		function setDs_color($value) {
			$this->ds_color = $value;
		}
	
	}

