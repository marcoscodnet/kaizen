<?php

/**
 *
 * @author Lucrecia
 * @since 31-01-2011
 *
 * Manager para marcas.
 *
 */
class MarcaManager extends ReferenciaManager {

    protected function getReferenciaQuery() {
        return new MarcaQuery();
    }

    public function agregarMarca(Marca $oMarca, Array $tiposunidades) {
        //persistir marca en la bbdd.
        MarcaQuery::insertMarca($oMarca);
        //persistir los tipos de unidadeses asociadas al perfil.
        MarcaTipoUnidadQuery::insertarTiposunidadesDeMarca($oMarca, $tiposunidades);
    }

    public function modificarMarca(Marca $oMarca, Array $tiposunidades) {
        //persistir los cambios de la marca en la bbdd.
        MarcaQuery::modificarMarca($oMarca);
        //persistir los cambios en las funciones asociadas al perfil.
        MarcaTipoUnidadQuery::modificarTiposunidadesDeMarca($oMarca, $tiposunidades);
    }

    public function eliminarMarca($cd_marca) {
        $oMarca = new Marca();
        $oMarca->setCd_marca($cd_marca);
        MarcaQuery::eliminarMarca($oMarca);
    }

    public function getMarcas(CriterioBusqueda $criterio) {
        $marcas = MarcaQuery::getmarcas($criterio);
        return $marcas;
    }

    public function getMarcaPorId($cd_marca) {
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('M.cd_marca', $cd_marca, '=');
        $oMarca = MarcaQuery::getMarca($criterio);
        return $oMarca;
    }

    public function getMarcaConTiposunidadesPorId($cd_marca) {
        $oMarca = new Marca ();
        $oMarca->setCd_marca($cd_marca);
        $oMarca = MarcaQuery::getMarcaPorId($oMarca);
        $tiposunidades = TipounidadQuery::getTiposunidadesDeMarca($oMarca);
        $oMarca->setTiposunidades($tiposunidades);
        return $oMarca;
    }

    public function getMarcaDeTipounidad($cd_tipounidad) {
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('MTU.cd_tipo_unidad', $cd_tipounidad, '=');
        $criterio->addOrden('ds_marca');
        $marcas = MarcaQuery::getMarcasPorTipounidad($criterio);
        return $marcas;
    }

    function getTiposunidades() {
        $criterio = new CriterioBusqueda();
        return TipounidadQuery::getTiposunidades($criterio);
    }

    public function getCantidadMarcas(CriterioBusqueda $criterio) {
        $cant = MarcaQuery::getCantMarcas($criterio);
        return $cant;
    }

    //INTERFACE IListar.

    function getEntidades(CriterioBusqueda $criterio) {
        return $this->getMarcas($criterio);
    }

    function getCantidadEntidades(CriterioBusqueda $criterio) {
        return $this->getCantidadMarcas($criterio);
    }

}