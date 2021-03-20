<?php

/**
 * Acci�n para exportar a excel una colecci�n de unidades.
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 */
class ExcelUnidadesAVenderAction extends ExportExcelCollectionAction {

    protected function getIListar() {
        return new UnidadManager();
    }

    protected function getTableModel(ItemCollection $items) {
        return new UnidadTableModel($items);
    }

    protected function getCampoOrdenDefault() {
        return 'U.cd_unidad';
    }

    public function getFuncion() {
        return "Alta Venta";
    }

    protected function getTitulo() {
        return "Listado de Unidades A Vender";
    }

    protected function getNombreArchivo() {
        return "Unidades_a_vender";
    }

    protected function getCriterioBusqueda() {
        //recuperamos los par�metros.
        $filtro = FormatUtils::getParam('filtro');
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $cd_producto = FormatUtils::getParam('cd_producto');

        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());


        $criterio = new CriterioBusqueda();

        $criterio->addFiltro("U.cd_unidad", "select V.cd_unidad from venta V", "NOT IN", new FormatValorIN());

        if ($cd_producto != "") {
            $criterio->addFiltro('P.cd_producto', $cd_producto, "=");
        }

        //$this->addSelectedFiltro($criterio,'P.cd_producto', $cd_producto);
        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        $criterio->addOrden($campoOrden, $orden);
        return $criterio;
    }

    protected function addSelectedFiltro($criterio, $campoFiltro, $filtro) {

        if (substr($campoFiltro, 0, 3) == 'dt_')
            $criterio->addFiltro($campoFiltro, $filtro, '=', new FormatValorDate());
        else
            $criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLike());
    }

}