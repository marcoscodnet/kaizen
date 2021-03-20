<?php

/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Manager para clientes.
 *
 */
class UnidadManager implements IListar {

    /**
     * se agrega una unidad nueva.
     * @param $oUnidad a agregar.
     */
    public function agregarUnidad(Unidad $oUnidad) {
        //persistir cliente en la bbdd.
        UnidadQuery::insertUnidad($oUnidad);
    }

    /**
     * se modifica una unidad.
     * @param Unidad $oUnidad a modificar.
     */
    public function modificarUnidad(Unidad $oUnidad) {
        //persistir los cambios del cliente en la bbdd.
        UnidadQuery::modificarUnidad($oUnidad);
    }

    public function modificarSucursalDeUnidad(Unidad $oUnidad) {
        //persistir los cambios del cliente en la bbdd.
        UnidadQuery::modificarSucursalDeUnidad($oUnidad);
    }

    /**
     * eliminar un cliente.
     * @param $cd_cliente identificador del cliente a eliminar
     */
    public function eliminarUnidad($cd_unidad) {
        $oUnidad = new Unidad ();
        $oUnidad->setCd_unidad($cd_unidad);
        if (!UnidadQuery::estaVendida($oUnidad)) {
            UnidadQuery::eliminarUnidad($oUnidad);
        }
    }

    public function autorizarUnidad($cd_unidad) {
        $oUnidad = new Unidad ();
        $oUnidad->setCd_unidad($cd_unidad);

        if (!UnidadQuery::estaAutorizada($oUnidad)) {
            UnidadQuery::autorizarUnidad($oUnidad);
        }
    }

    public function estaAutorizada($cd_unidad) {
        $oUnidad = new Unidad ();
        $oUnidad->setCd_unidad($cd_unidad);
        $rta = UnidadQuery::estaAutorizada($oUnidad);
        return $rta;
    }

    public function desautorizarUnidad($cd_unidad) {
        $oUnidad = new Unidad ();
        $oUnidad->setCd_unidad($cd_unidad);
        //Valido que no est� vendida ya.
        if (!UnidadQuery::estaVendida($oUnidad)) {
            if (UnidadQuery::estaAutorizada($oUnidad)) {
                UnidadQuery::desautorizarUnidad($oUnidad);
            }
        }
    }

    /**
     * se listan uniades.
     * @param $criterio
     * @return unknown_type
     */
    public function getUnidades(CriterioBusqueda $criterio=null) {
        $criterio = FormatUtils::ifEmpty($criterio, new CriterioBusqueda());
        $unidades = UnidadQuery::getUnidades($criterio);
        return $unidades;
    }

    /**
     * obtiene un cliente espec�fico dado un identificador.
     * @param $cd_cliente identificador del cliente a recuperar
     * @return unknown_type
     */
    public function getUnidadPorId($cd_unidad) {
        if (!empty($cd_unidad)) {
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro('U.cd_unidad', $cd_unidad, '=');
            $oUnidad = UnidadQuery::getUnidad($criterio);
        } else {
            $oUnidad = new Unidad();
        }
        return $oUnidad;
    }

    public function getUnidad(CriterioBusqueda $criterio) {
        $oUnidad = UnidadQuery::getUnidad($criterio);
        return $oUnidad;
    }

    /**
     * obtiene la cantidad de clientes dado un filtro.
     * @param $filtro filtro de b�squeda.
     * @return cantidad de clientes
     */
    public function getCantidadUnidades(CriterioBusqueda $criterio) {
        $cant = UnidadQuery::getCantUnidades($criterio);
        return $cant;
    }

    //INTERFACE IListar.

    function getEntidades(CriterioBusqueda $criterio) {
        return $this->getUnidades($criterio);
    }

    function getCantidadEntidades(CriterioBusqueda $criterio) {
        return $this->getCantidadUnidades($criterio);
    }

}