<?php

/**
 * Acci�n para dar de alta una movimiento.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AltaPiezaAVentaPiezaAction extends EditarPiezaAVentaPiezaAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		
		if (isset($_POST ['nu_cantidadpedida']))
			$cantidadpedida = $_POST ['nu_cantidadpedida'];
			
		if (isset($_POST ['qt_montoacobrar']))
			$montoacobrar = $_POST ['qt_montoacobrar'];
		
		
		if(isset($_SESSION['piezasavender'])){
			$tmp_piezas = $_SESSION['piezasavender'];
		}else{
			$tmp_piezas = array();
		}
		
		if((! $this->yaExiste($tmp_piezas, $oEntidad))&&($oEntidad->getPieza()->getCd_pieza()!=-1)){
			array_push($tmp_piezas, $oEntidad);
		}		$_SESSION['sinstock']='';		if ($oEntidad->getPieza()->getCd_pieza()==-1) {// si la entidad est� vac�a es porque no habia stock suficiente			$_SESSION['sinstock']="No hay suficiente stock en la <b> Pieza  ".$oEntidad->getPieza()->getDs_codigo()." </b>  el stock actual es <b>".$_SESSION['stockActual']."</b>";		}		 
		$_SESSION['piezasavender'] = $tmp_piezas;
	}

	protected function yaExiste($listado, $oEntidad){
		foreach($listado as $pieza){
			if(($pieza->getCd_pieza() == $oEntidad->getCd_pieza())&&($pieza->getSucursalOrigen()->getCd_sucursal() == $oEntidad->getSucursalOrigen()->getCd_sucursal())){
				return true;
			}
		}
		return false;
	}

	protected function getForwardSuccess(){
		return 'alta_piezaavender_success';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_piezaavender_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Venta Pieza";
	}

}