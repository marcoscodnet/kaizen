<?php 

/**
 * Acción para listar obras con el fin de seleccionar una de ellos.
 *
 * La página que llame a este acción (opener), deberá tener los inputs utilizados
 * en la función 'seleccionarObra(...)' incluída en funciones.js
 * 
 * @author Lucrecia
 * @since 14-04-2010
 * 
 */
class SeleccionarObraAction extends SeleccionarAction{

	
	private $validarCerrada;

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new ObraTableModel($items);
	}
	
	
	/**
	 * si se setea a "true" se valida que la obra no esté cerrada.
	 * @param unknown_type $value
	 * @return unknown_type
	 */
	public function setValidarCerrada($value){
		$this->validarCerrada = $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar obra";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){
		return new ObraManager();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'dt_fecha';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Seleccionar Obra';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'seleccionar_obra';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'seleccionar_obra_error';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('O.cd_obra', 'C&oacute;digo');
		$filtros[]= $this->buildFiltro('T.ds_tipoobra', 'Tipo de Obra');
		$filtros[]= $this->buildFiltro('S.ds_subtipoobra', 'Subtipo de Obra');
		$filtros[]= $this->buildFiltro('O.dt_fecha', 'Fecha de Inicio');
		return $filtros;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/SeleccionarAction#getOnclickTitle($item)
	 */
	protected function getOnclickTitle($item){
		$texto = '';
		
		if (isset ( $_GET ['validarCerrada'] ))
			$this->validarCerrada = $_GET ['validarCerrada'];
		
		if(!($this->validarCerrada && $item->getBl_cerrada()) ){
			$texto = parent::getOnclickTitle( $item );			
		}else{
			$texto = 'La Obra '. $item->getCd_obra() . ' est&aacute; cerrada, no puede seleccionarla.';
		}
		return $texto;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/SeleccionarAction#getOnclick($item)
	 */
	protected function getOnclick($item){
		$texto = '';			
		if(!($this->validarCerrada && $item->getBl_cerrada()) ){
			$cd_obra = $item->getCd_obra();
			$ds_obra = $this->getDs_item( $item );
			$onComplete = $this->getOnComplete();			
			$texto = "seleccionarObra('$cd_obra','$ds_obra', '$onComplete');";
		}
		
		return $texto;
		
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/SeleccionarAction#getDs_item($item)
	 */
	protected function getDs_item($item){
		$ds_tipoObra = $item->getDs_tipoObra();
		$nu_tipoObra = $item->getNu_tipoObra();
		$ds_subtipoObra = $item->getDs_subtipoObra();
		$nu_subtipoObra = $item->getNu_subtipoObra();

		$ds_obra = stripslashes(  $item->getDs_tipoObraFormateada() . ' / ' . $item->getDs_subtipoObraFormateada() );
		return $ds_obra;
	}

	
}