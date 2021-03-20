<?php 

/**
 * Acción para visualizar un color.
 *  
 * @author Marcos * @since 15-05-2012
 * 
 */
class VerTiposervicioAction extends SecureOutputAction{

	/**
	 * consulta una color.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'tiposservicios/vertiposervicio.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_tiposervicio = $_GET ['id'];
			
			$manager = new TiposervicioManager();
			
			try{
				$oTiposervicio = $manager->getTiposervicioPorId ( $cd_tiposervicio );
			}catch(GenericException $ex){
				$oTiposervicio = new Tiposervicio();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la color.
			$xtpl->assign ( 'cd_tiposervicio', $oTiposervicio->getCd_tiposervicio());
			$xtpl->assign ( 'ds_tiposervicio', stripslashes ( $oTiposervicio->getDs_tiposervicio()) );
						
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de color' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver color";
	}
	
	public function getTitulo(){
		return "Detalle de Color";
	}
	
	
}