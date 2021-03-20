<?php 

/**
 * Acción listar marcas.
 * 
 * @author Lucrecia
 * @since 14-01-2011
 * 
 */
class ListarMarcasAction extends ListarAction{

	protected function getListarTableModel( ItemCollection $items ){
		return new MarcaTableModel($items);
	}
		
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altamarca', 'Agregar Marca', 'alta_marca_init');
		return $opciones;
	}
	
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_marca', 'Marca');
		return $filtros;
	}
	

	protected function parseAcciones(XTemplate $xtpl, $item){
		
		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_marca(), 'marca', 'marca' );
	}
	
	public function getFuncion(){
		return "Listar marca";
	}
	
	protected function getEntidadManager(){		
		return new MarcaManager();
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_marca';
	}
	
	protected function getMsjError1(){
		return 'No se pudo eliminar la Marca. Verifique que no exista ningún equipo relacionado';	
	}
	
	protected function getTitulo(){
		return 'Administración de Marcas';
	}
	
	protected function getUrlAccionListar(){
		return 'listar_marcas';
	}

	protected function getUrlAccionExportarPdf(){
		return 'pdf_marcas';
	}
	
	protected function getUrlAccionExportarExcel(){
		return 'excel_marcas';
	}
	
	protected function getForwardError(){
		return 'listar_marcas_error';
	}

	protected function getMenuActivo(){
		return "Marcas";
	}
	
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/marcas/eliminarmarca.html' );
		$xtpl->assign ( 'cd_marca', $entidad->getCd_marca() );
		$xtpl->assign ( 'ds_marca', stripslashes( $entidad->getDs_marca() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
	
}