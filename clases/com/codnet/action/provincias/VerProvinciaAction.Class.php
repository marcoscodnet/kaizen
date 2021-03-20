<?php 

/**
 * Acción para visualizar una provincia.
 *  
 * @author bernardo
 * @since 18-03-2010
 * 
 */
class VerProvinciaAction extends SecureOutputAction{

	/**
	 * consulta una provincia.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'provincias/verprovincia.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_provincia = $_GET ['id'];
			
			$manager = new ProvinciaManager();
			
			try{
				$oProvincia = $manager->getProvinciaPorId ( $cd_provincia );
			}catch(GenericException $ex){
				$oProvincia = new Provincia();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la provincia.
			$xtpl->assign ( 'cd_provincia', $oProvincia->getCd_provincia());
			$xtpl->assign ( 'ds_provincia', stripslashes ( $oProvincia->getDs_provincia()) );
			$xtpl->assign ( 'cd_pais', stripslashes ( $oProvincia->getCd_pais () ) );
			$xtpl->assign ( 'ds_pais', stripslashes ( $oProvincia->getDs_pais() ) );
						
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de provincia' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver provincia";
	}
	
	public function getTitulo(){
		return "Detalle de Provincia";
	}
	
	
}