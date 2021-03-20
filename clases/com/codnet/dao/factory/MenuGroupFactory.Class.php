<?php
/**
 * 
 * @author bernardo
 * @since 23-06-2010
 * 
 * Factory para menu group.
 *
 */
class MenuGroupFactory implements ObjectFactory{

	/**
	 * construye un menugroup. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oMenuGroup = new MenuGroup();
		$oMenuGroup->setCd_menugroup( $next ['cd_menugroup'] );
		$oMenuGroup->setDs_nombre( $next ['nombre'] );
		$oMenuGroup->setWidth( $next ['width'] );
		
		if(array_key_exists('action',$next)){
			$oMenuGroup->setDs_action( $next ['action'] );
		}

		if(array_key_exists('cssclass',$next)){
			$oMenuGroup->setDs_cssclass( $next ['cssclass'] );
		}
		
		return $oMenuGroup;
	}
}
?>