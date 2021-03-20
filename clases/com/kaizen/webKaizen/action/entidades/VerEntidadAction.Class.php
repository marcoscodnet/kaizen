<?php 

/**
 * Acción para visualizar un entidad.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class VerEntidadAction extends SecureOutputAction{

	/**
	 * consulta una entidad.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'entidades/verentidad.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_entidad = $_GET ['id'];
			
			$manager = new EntidadManager();
			
			try{
				$oEntidad = $manager->getEntidadPorId ( $cd_entidad );
			}catch(GenericException $ex){
				$oEntidad = new Entidad();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la entidad.
			$xtpl->assign ( 'cd_entidad', $oEntidad->getCd_entidad());
			$xtpl->assign ( 'ds_entidad', stripslashes ( $oEntidad->getDs_entidad()) );
						
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de entidad' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver entidad";
	}
	
	public function getTitulo(){
		return "Detalle de Entidad";
	}
	
	
}