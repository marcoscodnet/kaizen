<?php

/**
 * Representa un layout de la forma:
 * 
 *  <content>
 * 
 * @author bernardo
 * @since 06-04-2010
 */
abstract class LayoutPopup extends Layout{

	public function show(){
		$xtpl = $this->getXTemplate ();
		return $xtpl->text('main');
	}

	private function getXTemplate(){
		$xtpl = new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/popup_template.html');
		
		$xtpl->assign('titulo', $this->getTitulo());
		$xtpl->assign('content', $this->getContenido());

		$this->parseMetaTags($xtpl);
		$this->parseEstilos($xtpl);
		$this->parseScripts($xtpl);
		
		$xtpl->parse('main');
		
		return $xtpl;
	}
	
	
	protected function parseMetaTags($xtpl){}
	
	protected function parseEstilos($xtpl){}
	
	protected function parseScripts($xtpl){}
	
}
