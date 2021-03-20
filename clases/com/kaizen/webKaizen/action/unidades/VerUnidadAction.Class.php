<?php

/**
 * Acción para visualizar un unidad.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class VerUnidadAction extends SecureOutputAction{

	/**
	 * consulta un unidad.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'unidades/verunidad.html' );

		if (isset ( $_GET ['id'] )) {
			$cd_unidad = $_GET ['id'];

			$manager = new UnidadManager();

			try{
				$oUnidad = $manager->getUnidadPorId ( $cd_unidad );
			}catch(GenericException $ex){
				$oUnidad = new Unidad();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra el unidad.
			$xtpl->assign ( 'cd_unidad', $oUnidad->getCd_unidad());
			$xtpl->assign ( 'ds_tipo_unidad', $oUnidad->getProducto()->getDs_tipounidad());
			$xtpl->assign ( 'ds_marca', $oUnidad->getProducto()->getDs_marca());
			$xtpl->assign ( 'ds_modelo', $oUnidad->getProducto()->getDs_modelo());
			$xtpl->assign ( 'ds_color', $oUnidad->getProducto()->getDs_color());
			$xtpl->assign ( 'nu_motor', stripslashes ( $oUnidad->getNu_motor () ) );
			$xtpl->assign ( 'nu_cuadro', stripslashes ( $oUnidad->getNu_cuadro () ) );
			$xtpl->assign ( 'dt_ingreso', stripslashes ( $oUnidad->getDt_ingreso () ) );
			$xtpl->assign ( 'nu_patente', stripslashes ( $oUnidad->getNu_patente () ) );
			$xtpl->assign ( 'nu_remitoingreso', stripslashes ( $oUnidad->getNu_remitoingreso()));
			$xtpl->assign ( 'nu_aniomodelo', stripslashes ( $oUnidad->getNu_aniomodelo()) );
			$xtpl->assign ( 'ds_sucursal', $oUnidad->getSucursalactual()->getDs_nombre());
			$xtpl->assign ( 'ds_observacion', stripslashes ( $oUnidad->getDs_observacion() ) );
			$xtpl->assign ( 'nu_envio', stripslashes ( $oUnidad->getNu_envio() ) );
			$this->parseAutorizacion($xtpl, $oUnidad);

		}

		$xtpl->assign ( 'titulo', 'Detalle de unidad' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	public function parseAutorizacion($xtpl, $oUnidad){
		
		if(($oUnidad->getCd_autorizacion()!= 0)&&($oUnidad->getCd_autorizacion()!= NULL)){
			$xtpl->assign ( 'dt_autorizacion', stripslashes ( $oUnidad->getDt_autorizacion() ) );
			$xtpl->assign ( 'ds_nomusuario', stripslashes ( $oUnidad->getAutorizacion()->getDs_usuario() ) );
			$xtpl->parse ( 'main.detalle_autorizacion' );
		}
	}

	public function getFuncion(){
		return "Ver unidad";
	}

	public function getTitulo(){
		return "Detalle de Unidad";
	}


}