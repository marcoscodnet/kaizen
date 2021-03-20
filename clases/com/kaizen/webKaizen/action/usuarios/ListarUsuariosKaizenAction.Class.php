<?php

/**
 * Acci�n listar usuarios.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ListarUsuariosKaizenAction extends ListarUsuariosAction {
	
    protected function getListarTableModel(ItemCollection $items) {
        return new UsuarioKaizenTableModel($items);
    }

    protected function getEntidadManager() {
        return new UsuarioKaizenManager();
    }

    protected function getUrlAccionListar() {
        return 'listar_usuariosKaizen';
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        $this->parseAccionesDefault($xtpl, $item, $item->getCd_usuario(), 'usuarioKaizen', 'usuarioKaizen');
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altausuarioKaizen', 'Agregar Usuario', 'alta_usuarioKaizen_init');
        return $opciones;
    }

    protected function getUrlAccionExportarPdf() {
        return 'pdf_usuariosKaizen';
    }

    protected function getUrlAccionExportarExcel() {
        return 'excel_usuariosKaizen';
    }        	protected function getCriterioBusqueda(){		//recuperamos los par�metros.		$filtro = FormatUtils::getParam('filtro');		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );				$page = $this->getPagePaginacion();		$orden = FormatUtils::getParam('orden','DESC');		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );		//$bl_activo_selected = $_GET['bl_activo'];				if(isset($_GET['bl_activo'])){			$bl_activo_selected = $_GET['bl_activo'];		}		else{			$bl_activo_selected =1;		}		$criterio = new CriterioBusqueda();		if($bl_activo_selected!=null && $bl_activo_selected!=""){			$this->addSelectedFiltro($criterio,'bl_activo', $bl_activo_selected);		}		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);		$criterio->addOrden($campoOrden, $orden);		$criterio->setPage($page);		$criterio->setRowPerPage(ROW_PER_PAGE);		return $criterio;	}    	protected function getFiltrosEspeciales(){		$xtpl =  new XTemplate(APP_PATH .  'usuarios/criterio_usuarios.html');		//$bl_activo_selected = FormatUtils::getParam('bl_activo', null);		if(isset($_GET['bl_activo'])){			$bl_activo_selected = $_GET['bl_activo'];		}		else{			$bl_activo_selected =1;		}												$selectedActivos=($bl_activo_selected=='1')?'selected="selected"':'';		$selectedInactivos=($bl_activo_selected=='0')?'selected="selected"':'';								$xtpl->assign('key', 1);		$xtpl->assign('selected', $selectedActivos);		$xtpl->assign('value', 'Activos');		$xtpl->parse('main.option_usuarios');		$xtpl->assign('key', 0);		$xtpl->assign('selected', $selectedInactivos);		$xtpl->assign('value', 'Inactivos');		$xtpl->parse('main.option_usuarios');						$xtpl->parse('main');		return $xtpl->text('main');	}

}