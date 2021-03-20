<?php

/**
 * Representa el layout para el login de kaizen
 * 
 * @author Lucrecia
 * @since 09-04-2010
 */
class LayoutLoginKaizen extends LayoutKaizen{


	protected function getFooter(){
		$xtpl = new XTemplate (APP_PATH.  'common/footer.html');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	protected function parseMenuSuperiorDerecho($xtpl){}
	protected function parseMenuLateral($xtpl){}
	protected function parseMenuSolapas($xtpl){}

	protected function getXTemplate(){
		return new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/collabtive_login_template.html');
	}
	
}
