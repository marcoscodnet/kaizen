<?php

/**
 * Acción para modificar un unidad.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ModificarVentaAction extends EditarVentaAction{
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new VentaManager();
		$manager->modificarVenta($oEntidad);

		$creditos = unserialize($_SESSION['pagos']);
		$creditos_anteriores = unserialize($_SESSION['pagosAnteriores']);

		foreach($creditos as $itempago){
			if(($itempago->getCd_itempago() != 0)&&($itempago->getCd_itempago() != "")){
				$manager-> modificarPagoDeVenta($itempago);
			}else{
				$itempago->setCd_venta($oEntidad->getCd_venta());
				$manager-> insertarPagoDeVenta($itempago);
			}

			//Saco de los originales, los itemspagos que quedaron iguales
			$key = $this->buscarItempagoDeTemporal($creditos_anteriores, $itempago);
			$this->borrarItempagoDeTemporal($creditos_anteriores, $key);


		}
		if($creditos_anteriores->size()>0){
			//Elimino aquellos que ya estaban en la BD y no están más
			$this->eliminarItempagoDeLaBD($creditos_anteriores);
		}


		if($this->tienePermisoFuncion(AUTORIZAR_UNIDAD_ACCION)){
			if($_POST['bl_autorizar']=="1"){
				$cd_unidad = $oEntidad->getCd_unidad();
				$unidadManager = new UnidadManager();
				if(!$unidadManager->estaAutorizada($cd_unidad)){
					$unidadManager->autorizarUnidad($cd_unidad);
				}

			}
		}
		unset($_SESSION['pagos']);
		unset($_SESSION['pagosAnteriores']);
	}

	protected function buscarItempagoDeTemporal($tmp_creditos, $itempago){
		foreach($tmp_creditos as $key=>$tmp_itempago){
			if($tmp_itempago->getCd_itempago() == $itempago->getCd_itempago()){
				return $key;
			}
		}
		return -1;
	}

	protected function eliminarItempagoDeLaBD($tmp_creditos){
		$itempagoManager = new ItempagoManager();
		foreach($tmp_creditos as $itempago){
			$itempagoManager->eliminarItempago($itempago);
		}
	}

	protected function borrarItempagoDeTemporal(ItemCollection $tmp_creditos, $key){
		if($key != -1){
			$tmp_creditos->removeItemByKey($key);
			$result = $tmp_creditos->getObjectByIndex($key);
		}
	}


	protected function getForwardSuccess(){
		return 'modificar_venta_success';
	}

	protected function getForwardError(){
		return 'modificar_venta_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Venta";
	}

}