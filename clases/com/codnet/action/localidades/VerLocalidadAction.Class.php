<?php 

/**
 * Acción para visualizar una localidad.
 *  
 * @author bernardo
 * @since 18-03-2010
 * 
 */
class VerLocalidadAction extends SecureOutputAction{

	/**
	 * consulta una localidad.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'localidades/verlocalidad.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_localidad = $_GET ['id'];
			
			$manager = new LocalidadManager();
			
			try{
				$oLocalidad = $manager->getLocalidadPorId ( $cd_localidad );
			}catch(GenericException $ex){
				$oLocalidad = new Localidad();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la localidad.
			$xtpl->assign ( 'cd_localidad', $oLocalidad->getCd_localidad());
			$xtpl->assign ( 'ds_localidad', stripslashes ( $oLocalidad->getDs_localidad()) );
			$xtpl->assign ( 'cd_provincia', stripslashes ( $oLocalidad->getCd_provincia () ) );
			$xtpl->assign ( 'ds_provincia', stripslashes ( $oLocalidad->getDs_provincia() ) );
			$xtpl->assign ( 'ds_pais', stripslashes ( $oLocalidad->getDs_pais() ) );
						
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de localidad' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver localidad";
	}
	
	public function getTitulo(){
		return "Detalle de Localidad";
	}
	
	
}