<?php 

/**
 * Acción listar usuarios.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ListarUsuariosAction extends ListarAction{
	protected function getListarTableModel( ItemCollection $items ){
		return new UsuarioTableModel($items);
	}
	
	protected function getOpciones(){
		$opciones[]= $this->buildOpcion('altausuario', 'Agregar Usuario', 'alta_usuario_init');
		return $opciones;
	}

	protected function getFiltros(){
		$filtros[]= $this->buildFiltro('ds_nomusuario', 'Nombre de Usuario');
		return $filtros;
	}


	protected function parseAcciones(XTemplate $xtpl, $item){

		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_usuario(), 'usuario', 'usuario' );
	}
	
	public function getFuncion(){
		return "Listar usuario";
	}

	protected function getEntidadManager(){
		return new UsuarioManager();
	}

	protected function getCampoOrdenDefault(){
		return 'ds_nomusuario';
	}

	protected function getMsjError1(){
		return 'No se pudo eliminar el Usuario. Verifique que no exista ningún equipo relacionado';
	}

	protected function getTitulo(){
		return 'Administración de Usuarios';
	}

	protected function getUrlAccionListar(){
		return 'listar_usuarios';
	}

	protected function getUrlAccionExportarPdf(){
		return 'pdf_usuarios';
	}
	
	protected function getUrlAccionExportarExcel(){
		return 'excel_usuarios';
	}
	
	protected function getForwardError(){
		return 'listar_usuarios_error';
	}

	protected function getMenuActivo(){
		return "Usuarios";
	}

	protected function getCartelEliminar($entidad){
		$xtpl = new XTemplate ( APP_PATH .'/usuarios/eliminarusuario.html' );
		$xtpl->assign ( 'cd_usuario', $entidad->getCd_usuario() );
		$xtpl->assign ( 'ds_nombre', stripslashes (  $entidad->getDs_apynom() ) );
		$xtpl->assign ( 'ds_perfil', stripslashes( $entidad->getDs_perfil() ) );
		$xtpl->assign ( 'ds_nomusuario', stripslashes( $entidad->getDs_nomusuario() ) );
		$xtpl->parse('main');
		return FormatUtils::quitarEnters( $xtpl->text('main') );
	}

	protected function getTituloListado(){
		return $this->getTitulo();
	}
}