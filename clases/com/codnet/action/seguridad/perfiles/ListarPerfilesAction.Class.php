<?php 

/**
 * Acción listar perfiles.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ListarPerfilesAction extends ListarAction{

	protected function getListarTableModel( ItemCollection $items ){
		return new PerfilTableModel($items);
	}
		
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altaperfil', 'Agregar Perfil', 'alta_perfil_init');
		return $opciones;
	}
	
	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_perfil', 'Perfil');		
		return $filtros;
	}
	

	protected function parseAcciones(XTemplate $xtpl, $item){
		
		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_perfil(), 'perfil', 'perfil' );
	}
	
	public function getFuncion(){
		return "Listar perfil";
	}
	
	protected function getEntidadManager(){		
		return new PerfilManager();
	}
	
	protected function getCampoOrdenDefault(){
		return 'ds_perfil';
	}
	
	protected function getMsjError1(){
		return 'No se pudo eliminar el Perfil. Verifique que no exista ningún equipo relacionado';	
	}
	
	protected function getTitulo(){
		return 'Administración de Perfiles';
	}
	
	protected function getUrlAccionListar(){
		return 'listar_perfiles';
	}

	protected function getUrlAccionExportarPdf(){
		return 'pdf_perfiles';
	}
	
	protected function getUrlAccionExportarExcel(){
		return 'excel_perfiles';
	}
	
	protected function getForwardError(){
		return 'listar_perfiles_error';
	}

	protected function getMenuActivo(){
		return "Perfiles";
	}
	
	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/perfiles/eliminarperfil.html' );
		$xtpl->assign ( 'cd_perfil', $entidad->getCd_perfil() );
		$xtpl->assign ( 'ds_perfil', stripslashes( $entidad->getDs_perfil() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}
	
}