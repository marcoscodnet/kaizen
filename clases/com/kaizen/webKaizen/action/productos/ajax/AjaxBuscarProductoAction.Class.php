<?php

/**
 *
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class AjaxBuscarProductoAction extends SecureAjaxAction {

    protected $path_html;
    protected $class;
    protected $required;

    /**
     * se elimina de sesi�n el producto consumido seleccionado.
     */
    public function executeImpl() {

        $criterio = new CriterioBusqueda();
        if (isset($_GET ['cd_tipounidad']) && ($_GET ['cd_tipounidad'] != "")) {
            $tipounidad_id = $_GET ['cd_tipounidad'];
            $criterio->addFiltro('TU.cd_tipo_unidad', $tipounidad_id, "=");
        }
        if (isset($_GET ['cd_marca']) && ($_GET ['cd_marca'] != "")) {
            $marca_id = $_GET ['cd_marca'];
            $criterio->addFiltro('MA.cd_marca', $marca_id, "=");
        }
        if (isset($_GET ['cd_modelo']) && ($_GET ['cd_modelo'] != "")) {
            $modelo_id = $_GET ['cd_modelo'];
            $criterio->addFiltro('M.cd_modelo', $modelo_id, "=");
        }
        if (isset($_GET ['cd_color']) && ($_GET ['cd_color'] != "")) {
            $color_id = $_GET ['cd_color'];
            $criterio->addFiltro('C.cd_color', $color_id, "=");
        }
        $manager = new ProductoManager();

        try {
            $productos = $manager->getProductos($criterio);
        } catch (GenericException $ex) {
            $productos = new ItemCollection();
        }

        $xtpl = new XTemplate(APP_PATH . $this->path_html);
        foreach ($productos as $key => $entidad) {
            $this->parseEntidad($entidad, $xtpl);
        }
        $xtpl->assign($this->ds_labelTag, $this->ds_label);
        $xtpl->assign($this->ds_idTag, $this->ds_id);

        //seteamos la funci�n de "onchange" en caso de que se haya indicado una.
        if (!empty($this->onchange)) {
            $xtpl->assign('onchange', "javascript:" . $this->onchange . ";");
        }

        if (!empty($this->class)) {
            $xtpl->assign('class', "$this->class");
        }

        if ($this->required) {
            $xtpl->assign('required', "(*)");
        }
        $xtpl->assign('WEB_PATH', WEB_PATH);
        $xtpl->parse('main');
        $texto = $xtpl->text('main');

        return $texto;
    }

    protected function parseEntidad($entidad, $xtpl) {
        $xtpl->assign('cd_producto', htmlentities($entidad->getCd_producto()));
        $xtpl->assign('ds_producto', htmlentities($entidad->getDs_tipounidad() . " " . $entidad->getDs_marca() . " " . $entidad->getDs_modelo() . " " . $entidad->getDs_color()));
        
        $xtpl->assign('option', 'option');
        $xtpl->assign('tag', 'value');
        $xtpl->assign('style', '');
        $xtpl->parse('main.row');
    }

    public function getFuncion() {
        return "Listar Producto";
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

    public function getOnchange() {
        return $this->onchange;
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