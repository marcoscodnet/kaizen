<?php 

/**
 * Acción para exportar a xls una colección ItemCollection.
 * 
 * @author bernardo
 * @since 03-06-2010
 * 
 */
abstract class ExportExcelCollectionAction extends SecureAction{

	protected $tableModel;

	/**
	 * título del listado..
	 * @return 
	 */
	protected abstract function getTitulo();
	
	/**
	 * nombre del archivo excel a generar.
	 * @return 
	 */
	protected abstract function getNombreArchivo();
	
	/**
	 * campo de ordenación por default.
	 * @return 
	 */
	protected abstract function getCampoOrdenDefault();
	
	/**
	 * encargado de listar las entidades.
	 * @return IListar
	 */
	protected abstract function getIListar();
	 
	/**
	 * descriptor para la colección de entidades.
	 * @return TableModel
	 */
	protected abstract function getTableModel( ItemCollection $items );

	/**
	 * layout para la exportación a excel..
	 * @return unknown_type
	 */
	protected function getLayoutExcel(){
		return new LayoutExcel();
	}
	
	/**
	 * template donde parsear la salida.
	 * @return unknown_type
	 */
	protected function getXTemplate(){
		return new XTemplate(APP_PATH. CLASS_PATH . 'codnet/excel/excel_template.html');
	}
	
	/**
	 * criterio de búsqueda para filtrar el listado.
	 * @return unknown_type
	 */
	protected function getCriterioBusqueda(){
		//recuperamos los parámetros.				
		$filtro = FormatUtils::getParam('filtro');
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );
		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );
		
		//obtenemos las entidades a mostrar.
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLike());
		$criterio->addOrden($campoOrden, $orden);
		
		return $criterio;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#executeImpl()
	 */
	public function executeImpl(){
		
		//armamos el layout.
		$layout = $this->getLayoutExcel();
		$layout->setNombreArchivo($this->getNombreArchivo());
		$layout->setContenido( $this->getContenido() );
		$layout->setTitulo( $this->getTitulo() );
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-type:application/vnd.ms-excel;charset:ISO-8859-1;");
		header("Content-Disposition: attachment; filename=". $this->getNombreArchivo() .".xls");
		header("Content-Transfer-Encoding: binary");		
		
		echo $layout->show();
		//para que no haga el forward.
		$forward = null;
				
		return $forward;
	}

	
	/**
	 * se listan entidades.
	 * @return boolean (true=exito).
	 */
	protected function getContenido(){
		
		$xtpl = $this->getXTemplate();

		$orden = FormatUtils::getParam('orden','DESC');
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		//obtenemos las entidades a exportar.
		$criterio = $this->getCriterioBusqueda();
		$entidades = $this->getIListar()->getEntidades ( $criterio );
		$this->tableModel = $this->getTableModel( $entidades );
		
		//generamos el contenido.
		$content = $this->parseContenido($xtpl, $entidades, $criterio);

		return $content;
		
	}
	
	/*
	 * se parsea la salida utilizando xtemplate.
	 */
	private function parseContenido(XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio){
		

		//header del listado.
		$this->parseHeader( $xtpl, $entidades, $criterio );
		
		//encabezados (ths) de la tabla.
		$this->parseTHs( $xtpl );
		
		//se parsean los elementos a mostrar
		$this->parseRows( $xtpl , $entidades);

		//footer del listado.
		$this->parseFooter( $xtpl, $entidades, $criterio );
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );		
	}
	
	
	/**
	 * se parsea un header para el listado.
	 * @param $xtpl
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function parseHeader( XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio ){
		$xtpl->assign( 'header', $this->getHeader($entidades, $criterio));
		$xtpl->parse('main.header');
	
	}

	/**
	 * obtiene el header.
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function getHeader( ItemCollection $entidades, CriterioBusqueda $criterio ){
		return '';
	}
	
	/**
	 * se parsea un footer para el listado.
	 * @param $xtpl
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function parseFooter( XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio){
		$xtpl->assign( 'footer', $this->getFooter($entidades, $criterio));
		$xtpl->parse('main.footer');		
	}

	/**
	 * obtiene el footer.
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function getFooter( ItemCollection $entidades, CriterioBusqueda $criterio ){
		return '';
	}
	
	
	/**
	 * se parsean los encabezados de las columnas del listado.
	 * @param XTemplate $xtpl
	 * @return unknown_type
	 */
	protected function parseTHs(XTemplate $xtpl){
	
		$ths = $this->tableModel->getEncabezados();
		$count = count($ths);
		for($index=0;$index<$count;$index++) {
			$encabezado = $ths[$index]['encabezado'];
			//$width = $this->tableModel->getColumnWidth($index)*10;
			$this->parseTH( $xtpl,  $encabezado);
		}
		
	}
	
	/**
	 * se parsea un header del listado.
	 * @param XTemplate $xtpl template a parsear.
	 * @param unknown_type $encabezado descripción del encabezado.
	 * @return none.
	 */
	protected function parseTH(XTemplate $xtpl, $encabezado){
	
		$xtpl->assign('encabezado', $encabezado );
		//$xtpl->assign('column_width', $width);
		$xtpl->parse('main.TH' );
		
	}
	
	/**
	 * se retorna una lista con los encabezados de las columnas.
	 * cada elemento de la lista deberá ser un array de la forma:
	 *    - th['encabezado']='titulo'
	 * se puede usar el método buildTh(nombre, orden, descripcion) para formar dicho arreglo.   
	 * @return unknown_type
	 */
	protected function getEncabezados(){
		return $this->tableModel->getEncabezados();
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
	 * parsea el valor de un item. (el valor de una columna en una fila).
	 * @param $xtpl template a parsear.
	 * @param $value valor a parsear.
	 * @return none.
	 */
	protected function parseItemValue(XTemplate $xtpl, $value){
		$xtpl->assign ( 'value', $value );				
		$xtpl->parse('main.row.column' );
	}
	
	
	/**
	 * se retorna una lista con los valores de las columnas de la fila corriente.
	 * @return unknown_type
	 */
	protected function getValues($item){
		for ($i=0; $i < $this->tableModel->getColumnCount(); $i++){
			$values[]=  $this->tableModel->getValue($item, $i) ;
		}
	 	return $values;	
	}
	
	
}