<?php
/**
 * 
 * @author bernardo
 * @since 23-06-2010
 * 
 * Factory para menu option.
 *
 */
class MenuOptionFactory implements ObjectFactory{

	/**
	 * construye un menuoption. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		
		if(isset($next ['cd_funcion']) ){
			$factory = new FuncionFactory();
			$oMenuOption = new MenuSecureOption($factory->build( $next ));
		}else{
			$oMenuOption = new MenuOption();
		}
		
		$oMenuOption->setCd_menuoption( $next ['cd_menuoption'] );
		$oMenuOption->setDs_nombre( $next ['nombre'] );
		$oMenuOption->setDs_href( $next ['href'] );
		
		if(array_key_exists('cssclass',$next)){
			$oMenuOption->setDs_cssclass( $next ['cssclass'] );
		}
		
		
		if(array_key_exists('descripcion_panel',$next)){
			$oMenuOption->setDs_descripcionpanel( $next ['descripcion_panel'] );
		}
		
		return $oMenuOption;
	}
}
?>