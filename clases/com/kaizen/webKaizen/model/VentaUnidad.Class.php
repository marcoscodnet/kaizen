<?php
class VentaUnidad {
	private $cd_venta;
	private $cd_unidad;

	//M�todo constructor


	function VentaUnidad() {
		$this->cd_venta = 0;
		$this->cd_unidad = '';
	}

	//M�todos Get


	function getCd_venta() {
		return $this->cd_venta;
	}

	function getCd_unidad() {
		return $this->cd_unidad;
	}

	//M�todos Set


	function setCd_venta($value) {
		$this->cd_venta = $value;
	}

	function setCd_unidad($value) {
		$this->cd_unidad = $value;
	}

}
?>
