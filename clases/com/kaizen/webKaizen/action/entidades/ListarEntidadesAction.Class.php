<?php 

/**
 * Acción listar entidades.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class ListarEntidadesAction  extends ListarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new EntidadTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getOpciones()
	 */
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altaentidad', 'Agregar Entidad', 'alta_entidad_init');
		return $opciones;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getFiltros()
	 */
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_entidad', $this->tableModel->getColumnName(1));
		return $filtros;
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#parseAcciones($xtpl, $item)
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_entidad(), 'entidad', 'entidad' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Listar Entidad";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getEntidadManager()
	 */
	protected function getEntidadManager(){
		return new EntidadManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return 'ds_entidad';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getMsjError1()
	 */
	protected function getMsjError1(){
		return 'No se pudo eliminar el Entidad. Verifique que no existan datos relacionados';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return 'Administración de Entidades';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getCartelEliminar($entidad)
	 */
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/entidades/eliminarentidad.html' );
		$xtpl->assign ( 'ds_entidad', stripslashes( $entidad->getDs_entidad() ) );
		$xtpl->assign ( 'cd_entidad', stripslashes( $entidad->getCd_entidad() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getUrlAccionListar()
	 */
	protected function getUrlAccionListar(){
		return 'listar_entidades';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getUrlAccionExportarPdf()
	 */
	protected function getUrlAccionExportarPdf(){
		return 'pdf_entidades';
	}
	
	protected function getUrlAccionExportarExcel(){
		return 'excel_entidades';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/bulfon/bulfon/action/ListarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'listar_entidades_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
	 */
	protected function getMenuActivo(){
		return "Entidades";
	}



}