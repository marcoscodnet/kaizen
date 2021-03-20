<?php 

/**
 * Acción que lista entidades para poder seleccionar
 * una de ellas.
 * Cada subclase definirá la entidad concreta. 
 * 
 * @author bernardo
 * @since 07-04-2010
 * 
 */
abstract class SeleccionarAction extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#executeImpl()
	 */
	public function executeImpl(){
		
		//armamos el layout.
		$layout = new LayoutPopupElecnor();
		$layout->setContenido( $this->getContenido() );
		$layout->setTitulo( $this->getTitulo() );
				
		echo $layout->show();
		
		//para que no haga el forward.
		$forward = null;
				
		return $forward;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate(APP_PATH. CLASS_PATH . 'codnet/view/seleccionar_template.html');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#parseRows($xtpl, $items)
	 */
	protected function parseRows(XTemplate $xtpl, ItemCollection $items){
		
		foreach ($items as $key=> $item){

			$xtpl->assign('onclick', $this->getOnclick( $item ));
			$xtpl->assign('title', $this->getOnclickTitle( $item ));

			//parse el item -- main.row.column
			$this->parseItem( $xtpl, $item );			
			
			$xtpl->parse('main.row' );
		}
		
	}
	
	/**
	 * Retorna la descripción del ítem a seleccionar.
	 */
	protected function getOnclickTitle($item){
		return 'Haz click para seleccionar a '   . $this->getDs_item( $item );
	}

	/**
	 * Retorna la descripción del item.
	 */
	protected abstract function getDs_item($item);
	
	/**
	 * Retorna la función a ejecutar al seleccionar el item.
	 */
	protected abstract function getOnclick($item);

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return '';	
	}
	
	/**
	 * retorna true si se debe ejecutar la función "seleccionar en opener" al
	 * seleccionar un item.
	 * @return unknown_type
	 */
	protected function getSeleccionarEnOpener(){
		$seleccionarEnOpener = 0;
		if( isset( $_GET['seleccionar_en_opener']))
			$seleccionarEnOpener = $_GET['seleccionar_en_opener'];
		return $seleccionarEnOpener;	
	}
	
	/**
	 * retorna la función a evaluar en el opener al seleccionar un ítme.
	 * @return unknown_type
	 */
	protected function getOnComplete(){
		$onComplete = '';
		if( isset( $_GET['onComplete']))
			$onComplete = $_GET['onComplete'];
		return $onComplete;	
	}
	
	/**
	 * 
	 * @param unknown_type $filtro
	 * @param unknown_type $campoFiltro
	 */
	public function getQueryString($filtro, $campoFiltro){
		$seleccionar = "seleccionar_en_opener=" . $this->getSeleccionarEnOpener() ."&" ;
		$oncomplete ="onComplete=" . $this->getOnComplete()."&";
		return parent::getQueryString( $filtro, $campoFiltro ) . $seleccionar . $oncomplete;
	}
	
	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden ){
		$seleccionar = "&seleccionar_en_opener=" . $this->getSeleccionarEnOpener() ;
		$oncomplete = "&onComplete=" . $this->getOnComplete();
		return  parent::getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden ). $seleccionar . $oncomplete;
	}
	
}