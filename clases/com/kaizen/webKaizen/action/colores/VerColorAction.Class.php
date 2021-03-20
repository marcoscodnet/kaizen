<?php 

/**
 * Acción para visualizar un color.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class VerColorAction extends SecureOutputAction{

	/**
	 * consulta una color.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'colores/vercolor.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_color = $_GET ['id'];
			
			$manager = new ColorManager();
			
			try{
				$oColor = $manager->getColorPorId ( $cd_color );
			}catch(GenericException $ex){
				$oColor = new Color();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la color.
			$xtpl->assign ( 'cd_color', $oColor->getCd_color());
			$xtpl->assign ( 'ds_color', stripslashes ( $oColor->getDs_color()) );
						
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