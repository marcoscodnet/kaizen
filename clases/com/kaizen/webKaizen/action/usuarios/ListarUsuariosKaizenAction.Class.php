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
    }

}