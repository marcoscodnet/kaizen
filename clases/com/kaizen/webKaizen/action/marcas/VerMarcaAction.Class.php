<?php

/**
 * Acción para visualizar un club.
 *
 * @author Lucrecia
 * @since 10-01-2011
 *
 */
class VerMarcaAction extends SecureOutputAction{

	/**
	 * consulta un marca.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'marcas/vermarca.html' );

		if (isset ( $_GET ['id'] )) {
			$cd_marca = $_GET ['id'];
				
			$manager = new MarcaManager();
				
			try{
				$oMarca = $manager->getMarcaConTiposunidadesPorId($cd_marca );
			}catch(GenericException $ex){
				$oMarca = new Marca();
				//TODO ver si se muestra un mensaje de error.
			}

			//se muestra el marca.
			$xtpl->assign ( 'cd_marca', $oMarca->getCd_marca());
			$xtpl->assign ( 'ds_marca', stripslashes ( $oMarca->getDs_marca () ) );

			//se muestran las funciones asociadas.
			$tiposunidades = $oMarca->getTiposunidades();
			$index=0;
			foreach($tiposunidades as $key => $tipounidad) {
				$index++;
				if($index==4){
					$index=0;
					$xtpl->parse ( 'main.row' );
				}
				$xtpl->assign ( 'ds_tipounidad', stripslashes ( $tipounidad->getDs_tipounidad() ) );
				$xtpl->parse ( 'main.row.tiposunidades' );
			}
			if($index<=4){
				$xtpl->parse ( 'main.row' );
			}
				
				
		}

		$xtpl->assign ( 'titulo', 'Detalle de marca' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	public function getFuncion(){
		return "Ver Marca";
	}

	protected function getTitulo(){
		return "Ver Marca";
	}


}