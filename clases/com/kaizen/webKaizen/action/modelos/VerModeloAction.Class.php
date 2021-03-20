<?php 

/**
 * Acción para visualizar una modelo.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class VerModeloAction extends SecureOutputAction{

	/**
	 * consulta una modelo.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'modelos/vermodelo.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_modelo = $_GET ['id'];
			
			$manager = new ModeloManager();
			
			try{
				$oModelo = $manager->getModeloPorId ( $cd_modelo );
			}catch(GenericException $ex){
				$oModelo = new Modelo();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la modelo.
			$xtpl->assign ( 'cd_modelo', $oModelo->getCd_modelo());
			$xtpl->assign ( 'ds_modelo', stripslashes ( $oModelo->getDs_modelo()) );
			$xtpl->assign ( 'cd_marca', stripslashes ( $oModelo->getCd_marca () ) );
			$xtpl->assign ( 'ds_marca', stripslashes ( $oModelo->getDs_marca() ) );
						
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de modelo' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver modelo";
	}
	
	public function getTitulo(){
		return "Detalle de Modelo";
	}
	
	
}