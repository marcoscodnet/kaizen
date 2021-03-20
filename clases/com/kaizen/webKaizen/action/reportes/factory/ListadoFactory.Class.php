<?php

/**
 * Clase para construir listados.
 *
 * @author bernardo
 *
 */
abstract class ListadoFactory implements IListar{

	protected $tableModel;
	protected $isAjax=0; //para determinar si la salida va por ajax (es para formatear la salida con "htmlentities")
	
	/**
	 * table model para describir el listado.
	 * @return ListarTableModel
	 */
	protected abstract function getListarTableModel( ItemCollection $items );
		
	public abstract function getTitulo();	
	
	public abstract function getAccionReporte();
	public function getAccionPdf(){
		return null;
	}

	public function getAccionExcel(){
		return null;
	}
	
	public function getEncabezados(){
		return $this->tableModel->getEncabezados();
	}
	
	public function getValues($item){
		for ($i=0; $i < $this->tableModel->getColumnCount(); $i++){
			$values[]=  $this->tableModel->getValue($item, $i) ;
		}
	 	return $values;	
	}
	
	
	public function getRowPerPage(){
		return ROW_PER_PAGE;
	}
	
	public function getDivId(){
		return 'listado';
	}

	public function getXTemplate(){
		return new XTemplate(APP_PATH. CLASS_PATH . 'codnet/view/reporte_listado_template.html');
	}
	
	/**
	 * se parsea la salida del listado.
	 */
	public function getContenido(CriterioBusqueda $criterio, $campoOrden=null, $orden=null){
		
		$row_per_page = $criterio->getRowPerPage();
		$page = $criterio->getPage();
		
		$xtpl = $this->getXTemplate();

		//obtenemos los elementos a mostrar.
		$entidades = $this->getEntidades($criterio);
		$num_rows = $this->getCantidadEntidades($criterio);
		$this->tableModel = $this->getListarTableModel( $entidades );
		
		//construimos el paginador.
		$url = $this->getUrlPaginador($campoOrden, $orden, $page);
		$oPaginador = $this->getPaginador($num_rows, $page, $url, $this->getRowPerPage(), $campoOrden, $orden);
		
		//generamos el contenido.
		$content = $this->parseContenido($xtpl, $oPaginador, $entidades);

		return $content;
		
	}

	public function getUrlOrdenar($campoOrden, $orden, $page){
		$accion = $this->getAccionReporte();
		return "doAction?action=$accion&campoOrden=$campoOrden&orden=$orden&page=$page" ;
	}
	
	public function getUrlPaginador($campoOrden, $orden, $page){
		$accion = $this->getAccionReporte();
		$params = "campoOrden=$campoOrden&orden=$orden&page=$page";
		return "doAction?action=$accion&$params" ;
	}
	
	protected function getPaginador($num_rows, $page, $url, $row_per_page, $campoOrden, $orden){
		$num_pages = ceil ( $num_rows / $row_per_page );
		$cssclassotherpage = 'paginadorOtraPagina';
		$cssclassactualpage = 'paginadorPaginaActual';
		$ds_pag_anterior = 0; //$gral['pag_ant'];
		$ds_pag_siguiente = 2; //$gral['pag_sig'];
		return new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows, $row_per_page );
	}

	/*
	 * se parsea la salida utilizando xtemplate.
	 */
	private function parseContenido(XTemplate $xtpl, Paginador $oPaginador, $entidades){

		//indentificador del div donde se muestra el listado
		//(por si se utiliza ajax).
		$xtpl->assign ( 'divId', $this->getDivId() );
		
		$xtpl->assign ( 'titulo',  $this->getValue(  $this->getTitulo() ) ) ;
		
		//paginación.
		$xtpl->assign ( 'resultado', $oPaginador->imprimirResultados () );
		$xtpl->parse ( 'main.resultado' );
		
		$xtpl->assign ( 'PAG', $oPaginador->imprimirPaginado () );
		$xtpl->parse ( 'main.PAG' );
		
		//botones sobre el listado.
		$pdf = $this->getAccionPdf();
		if(!empty($pdf)){
			$xtpl->assign ( 'accion_pdf', $this->getAccionPdf() );
			$xtpl->parse( 'main.exportar.pdf');
		}

		$excel = $this->getAccionExcel();
		if(!empty($excel)){
			$xtpl->assign ( 'accion_excel', $this->getAccionExcel() );
			$xtpl->parse( 'main.exportar.excel');
		}
		$xtpl->parse( 'main.exportar');
		
		//encabezados (ths) de la tabla.
		$columnCount = $this->parseTHs( $xtpl, $oPaginador->getActualPage() );
		$xtpl->assign ( 'columnCount', $columnCount );
		
		//se parsean los elementos a mostrar
		$this->parseRows( $xtpl , $entidades);
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );		
	}
	
	/**
	 * se parsean los encabezados de las columnas del listado.
	 * @param XTemplate $xtpl
	 * @return cantidad de ths.
	 */
	protected function parseTHs(XTemplate $xtpl, $page){
	
		$ths = $this->getEncabezados();
		$count = count($ths);
		for($index=0;$index<$count;$index++) {
			$encabezado = $ths[$index]['encabezado'];
			$campoOrden = $ths[$index]['campoOrden'];
			$descripcionOrden = $ths[$index]['descripcionOrden'];
			$this->parseTH( $xtpl, $encabezado, $campoOrden, $descripcionOrden, $page);
		}
		return $count;
	}
	
	
	/**
	 * se parsea un header del listado.
	 * @param XTemplate $xtpl template a parsear.
	 * @param unknown_type $encabezado descripción del encabezado.
	 * @param unknown_type $campoOrden campo por el cual ordenar el listado al cliquear en el encabezado.
	 * @param unknown_type $descripcionOrden descripción de la ordenación.
	 * @return none.
	 */
	protected function parseTH(XTemplate $xtpl, $encabezado, $campoOrden,  $descripcionOrden, $page){
	
		$xtpl->assign('encabezado', $this->getValue( $encabezado ) );
		
		//$xtpl->assign('urlDESC', $this->getUrlOrdenar($campoOrden, 'DESC', $page));
		if( FormatUtils::getParam ('orden') == 'ASC')

			
			$orden='DESC';
		else
			$orden='ASC';
			
		$xtpl->assign('orden', $orden );	
		$xtpl->assign('urlASC', $this->getUrlOrdenar($campoOrden, $orden, $page));
		$xtpl->assign('campo_orden', $campoOrden );
		$xtpl->assign('ordenar_por', $this->getValue( $descripcionOrden ) );
		$xtpl->parse('main.TH' );
		
	}
	
	
	/**
	 * parsea el valor de un item. (el valor de una columna en una fila).
	 * @param $xtpl template a parsear.
	 * @param $value valor a parsear.
	 * @return none.
	 */
	protected function parseItemValue(XTemplate $xtpl, $value){
		$xtpl->assign ( 'value',   $this->getValue( $value ));	
		$xtpl->parse('main.row.column' );
	}

	/**
	 * se parsean las filtas.
	 * @param XTemplate $xtpl
	 * @param ItemCollection $items
	 * @return unknown_type
	 */
	protected function parseRows(XTemplate $xtpl, ItemCollection $items){
		
		foreach ($items as $key=> $item){
			//parse el item -- main.row.column
			$this->parseItem( $xtpl, $item );			
			
			$xtpl->parse('main.row' );
		}
	}

	/**
	 * se parsea la entidad en el xtemplate.
	 * @param $xtpl Xtemplate asociado al listado.
	 * @param $entidad entidad a parsear.
	 * @return none
	 * 
	 */
	protected function parseItem($xtpl, $entidad){
		$values = $this->getValues($entidad);
		$count = count($values);
		for($index=0;$index<$count;$index++) {
			$this->parseItemValue( $xtpl, $values[$index]);
		}
		
	}

		/**
	 * construye un encabezado.
	 * @param unknown_type $titulo
	 * @param unknown_type $orden
	 * @param unknown_type $descripcion
	 * @return unknown_type
	 */
	protected function buildTh($titulo, $orden, $descripcion){
		$th['encabezado']= $titulo;
	 	$th['campoOrden']= $orden;
	 	$th['descripcionOrden']= $descripcion;
		return $th;
	}
	
	public function setIsAjax( $value ){
		$this->isAjax = $value;
	}

	/**
	 * si se está usando ajax para visualizar el contenido, los valores los retornamos
	 * aplicándoles la función htmlentities.
	 * @param unknown_type $value
	 */
	public function getValue($value){
		if($this->isAjax)
			return  htmlentities( $value ) ;
		else
			return $value;			
	}
}
