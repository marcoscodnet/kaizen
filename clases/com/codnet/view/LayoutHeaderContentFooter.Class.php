<?php

/**
 * Representa un layout de la forma:
 *	{<meta-tags>, <scripts>, <estilos>} 
 *  <header>
 *  <content>
 *  <footer>
 * 
 * 
 * @author bernardo
 * @since 06-04-2010
 */
abstract class LayoutHeaderContentFooter extends Layout{

	
	public function show(){
		$xtpl = $this->getXTemplate ();
		
		$xtpl->assign('titulo', $this->getTitulo());
		$xtpl->assign('header', $this->getHeader());
		$xtpl->assign('content', $this->getContenido());
		$xtpl->assign('footer', $this->getFooter());
		$this->parseMetaTags($xtpl);
		$this->parseEstilos($xtpl);
		$this->parseScripts($xtpl);
		
		$this->parseException($xtpl);
		
		$xtpl->parse('main');

		return $xtpl->text('main');
	}

	protected function getXTemplate(){
		return new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/header_content_footer_template.html');
	}
	
	/**
	 * retorna el contenido a mostrar en el header.
	 * @return unknown_type
	 */
	protected abstract function getHeader();
	
	/**
	 * retorna el contenido a mostrar en el footer.
	 * @return unknown_type
	 */
	protected abstract function getFooter();

	/**
	 * parsea meta-tags del contenido.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseMetaTags($xtpl);
	
	/**
	 * parsea los estilos css del contenido.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseEstilos($xtpl);
	
	/**
	 * parsea los scripts incluidos en el contenido.
	 * @param unknown_type $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseScripts($xtpl);
	
	
	protected function parseException(XTemplate $xtpl){
		$exception = $this->getException();
		if( !empty($exception) ){
			$xtpl->assign('error_message', $exception->getMessage() );
			$xtpl->parse('main.error_message');
		}		
		
	}
}
