<?php 

/**
 * Acción para visualizar un color.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class VerTipounidadAction extends SecureOutputAction{

	/**
	 * consulta una color.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'tiposunidades/vertipounidad.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_tipounidad = $_GET ['id'];
			
			$manager = new TipounidadManager();
			
			try{
				$oTipounidad = $manager->getTipounidadPorId ( $cd_tipounidad );
			}catch(GenericException $ex){
				$oTipounidad = new Tipounidad();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la color.
			$xtpl->assign ( 'cd_tipounidad', $oTipounidad->getCd_tipounidad());
			$xtpl->assign ( 'ds_tipounidad', stripslashes ( $oTipounidad->getDs_tipounidad()) );
						
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