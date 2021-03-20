<?php



/**

 * Acci�n para inicializar el contexto para editar

 * un unidad.

 *

 * @author Lucrecia

 * @since 15-04-2010

 *

 */

abstract class EditarUnidadInitAction extends EditarInitAction {



    /**

     * (non-PHPdoc)

     * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()

     */

    protected function getXTemplate() {

        return new XTemplate(APP_PATH . '/unidades/editarunidad.html');

    }



    /**

     * (non-PHPdoc)

     * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()

     */

    protected function getEntidad() {

        return new Unidad();

    }



    /**

     * (non-PHPdoc)

     * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)

     */

    protected function parseEntidad($entidad, XTemplate $xtpl) {

        $oUnidad = FormatUtils::ifEmpty($entidad, new Unidad());

        //se muestra el unidad.

        $this->parseUnidad($oUnidad, $xtpl);

        $this->parseProductos($oUnidad->getCd_producto(), $xtpl);

        $this->parseSucursales($oUnidad->getCd_sucursalactual(), $xtpl);

    }



    protected function parseUnidad(Unidad $oUnidad, XTemplate $xtpl) {

        //se muestra el unidad.

        $xtpl->assign('cd_unidad', $oUnidad->getCd_unidad());

        $xtpl->assign('nu_motor', stripslashes($oUnidad->getNu_motor()));

        $xtpl->assign('nu_cuadro', stripslashes($oUnidad->getNu_cuadro()));

        $xtpl->assign('dt_ingreso', stripslashes($oUnidad->getDt_ingreso()));

        $xtpl->assign('nu_patente', stripslashes($oUnidad->getNu_patente()));

        $xtpl->assign('nu_remitoingreso', stripslashes($oUnidad->getNu_remitoingreso()));

        $xtpl->assign('nu_aniomodelo', stripslashes($oUnidad->getNu_aniomodelo()));

        $xtpl->assign('ds_observacion', stripslashes($oUnidad->getDs_observacion()));

        $xtpl->assign('nu_envio', stripslashes($oUnidad->getNu_envio()));



        //URL para el buscar de productos

        if ($this->getFuncion() != "Modificar Unidad") {

            $xtpl->assign('url', WEB_PATH . 'productos/doAction?action=buscar_productos');

            $xtpl->parse('main.imagen');

        } else {

            $xtpl->assign('disabled', "disabled");

            $input = "<input type='hidden' name='cd_producto' id='cd_producto' value='" . $oUnidad->getCd_producto() . "'/>";

            $xtpl->assign('producto_hidden', $input);

        }

    }



    protected function parseProducto(Unidad $oUnidad, XTemplate $xtpl) {

        $productoManager = new ProductoManager();

        $producto = $productoManager->getProductoPorId($oUnidad->getCd_producto());

        $xtpl->assign('ds_producto', $producto->getDs_tipounidad() . " " . $producto->getDs_marca() . " " . $producto->getDs_modelo() . " " . $producto->getDs_color());

        $xtpl->assign('cd_producto', $producto->getCd_producto());

    }



    protected function parseSucursales($cd_selected='', XTemplate $xtpl) {

        $sucursalManager = new SucursalManager();

        $criterio = new CriterioBusqueda();

        $sucursales = $sucursalManager->getSucursales($criterio);

        foreach ($sucursales as $key => $sucursal) {

            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());

            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));

            $xtpl->parse('main.option_sucursal');

        }

    }



    protected function parseProductos($cd_selected='', XTemplate $xtpl) {

        $productoManager = new ProductoManager();

        $criterio = new CriterioBusqueda();

        //$criterio->addFiltro('bl_discontinuo', 0, "=");

        $criterio->addOrden('ds_tipo_unidad, ds_marca, ds_modelo, ds_color');

        $productos = $productoManager->getProductos($criterio);

        foreach ($productos as $key => $producto) {

            $xtpl->assign('ds_producto', $producto->getDs_producto());

            $xtpl->assign('cd_producto', FormatUtils::selected($producto->getCd_producto(), $cd_selected));

            $xtpl->parse('main.option_producto');

        }

    }



}
