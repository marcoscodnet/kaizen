<?php

/**
 * AcciÃ­on para consultar si existe determinado cliente en la BD.
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class AjaxExisteUnidadAction extends SecureAjaxAction {

    protected $path_html;
    protected $class;
    protected $required;
    protected $funcion = "";
    protected $campo = "";

    /**
     * se elimina de sesión el producto consumido seleccionado.
     */
    public function executeImpl() {

        $texto = "";
        if (isset($_GET ['nu_motor'])) {
            $nu_motor = $_GET ['nu_motor'];
        }

        if (isset($_GET ['nu_cuadro'])) {
            $nu_cuadro = $_GET ['nu_cuadro'];
        }
        $unidadManager = new UnidadManager();
        if ((isset($_GET ['campo']) && $_GET ['campo'] == "nu_motor")) {
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro('U.nu_motor', "'".$nu_motor."'", "=");
            $oUnidad = $unidadManager->getUnidad($criterio);
            $texto = $oUnidad->getCd_unidad();
        } elseif ((isset($_GET ['campo']) && $_GET ['campo'] == "nu_cuadro")) {
            $criterio_cuadro = new CriterioBusqueda();
            $criterio_cuadro->addFiltro('U.nu_cuadro', "'".$nu_cuadro."'", "=");
            $oUnidad = $unidadManager->getUnidad($criterio_cuadro);
            $texto = $oUnidad->getCd_unidad();
        }
        return $texto;
    }

    public function getFuncion() {
        if ($this->funcion == "") {
            return "Listar unidad";
        } else {
            return $this->funcion;
        }
    }

    public function setFuncion($value) {
        return $this->funcion = $value;
    }

    public function getCampo() {
        return $this->campo;
    }

    public function setCampo($value) {
        return $this->campo = $value;
    }

    public function getPath_html() {
        return $this->path_html;
    }

    public function getClass() {
        return $this->class;
    }

    public function getRequired() {
        return $this->required;
    }

    /*
     * setea el value para onchange del combo.
     */

    public function setPath_html($value) {
        $this->path_html = $value;
    }

    public function setOnchange($value) {
        $this->onchange = $value;
    }

    public function setClass($value) {
        $this->class = $value;
    }

    public function setRequired($value) {
        $this->required = $value;
    }

}