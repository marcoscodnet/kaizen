<?php

/**
 * Acción listar Servicios.
 *
 * @author Marcos
 * @since 15-05-2012
 *
 */
class ListarServiciosAction extends ListarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)
     */
    protected function getListarTableModel(ItemCollection $items) {
        return new ServicioTableModel($items);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()
     */
    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaServicio', 'Registrar servicio', 'listar_unidades_vendidas');
        return $opciones;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()
     */
    protected function getFiltros() {
        $filtros[] = $this->buildFiltro("ds_modelo", $this->tableModel->getColumnName(3));
        $filtros[] = $this->buildFiltro("nu_motor", $this->tableModel->getColumnName(2));                $filtros[] = $this->buildFiltro("nu_chasis", $this->tableModel->getColumnName(4));
        $filtros[] = $this->buildFiltro("dt_carga", $this->tableModel->getColumnName(1));
        return $filtros;
    }

    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(APP_PATH . 'servicios/criterio_unidades.html');
        $this->parseSucursales($xtpl);
        $this->parseClientes($xtpl);
        $this->parseUsuarios($xtpl);
        $this->parseFechas($xtpl);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function parseFechas(XTemplate $xtpl) {
        $dt_desde = FormatUtils::getParam('dt_desde');
        $dt_hasta = FormatUtils::getParam('dt_hasta');
        $xtpl->assign('dt_desde', $dt_desde);
        $xtpl->assign('dt_hasta', $dt_hasta);
    }

    protected function parseSucursales(XTemplate $xtpl) {
        $sucursalManager = new SucursalManager();
        $sucursal_actual = FormatUtils::getParam('cd_sucursal');
        $sucursales = $sucursalManager->getSucursales();
        foreach ($sucursales as $key => $sucursal) {
            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());
            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $sucursal_actual));
            $xtpl->parse('main.option_sucursal');
        }
    }

    protected function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $filtro = FormatUtils::getParam('filtro');
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $cd_cliente = FormatUtils::getParam('cd_cliente');
        $cd_usuario = FormatUtils::getParam('cd_usuario');
        $cd_sucursal = FormatUtils::getParam('cd_sucursal');
        $dt_desde = FormatUtils::getParam('dt_desde');
        $dt_hasta = FormatUtils::getParam('dt_hasta');

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());


        $criterio = new CriterioBusqueda();

        if ($cd_usuario != "") {
            $criterio->addFiltro('S.cd_usuario', $cd_usuario, "=");
        }
        if ($cd_sucursal != "") {
            $criterio->addFiltro('S.cd_sucursal', $cd_sucursal, "=");
        }
        if ($cd_cliente != "") {
            $criterio->addFiltro('S.cd_cliente', $cd_cliente, "=");
        }
        if ($dt_desde != "") {
            $dt_desde = str_replace("/", "-", $dt_desde);
            $dt_desde = implode("/", array_reverse(explode("-", $dt_desde)));
            $criterio->addFiltro('S.dt_carga', "'$dt_desde 00:00:00'", ">=");
        }
        if ($dt_hasta != "") {
            $dt_hasta = str_replace("/", "-", $dt_hasta);
            $dt_hasta = implode("/", array_reverse(explode("-", $dt_hasta)));
            $criterio->addFiltro('S.dt_carga', "'$dt_hasta 23:59:59'", "<=");
        }

        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        $criterio->addOrden($campoOrden, $orden);
        $criterio->setPage($page);
        $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
    }

    protected function getFooter($entidades, CriterioBusqueda $criterio) {
        //Ver resumen de servicio
        if ($this->tienePermisoFuncion("Ver resumen de servicio")) {
            $servicios_manager = new ServicioManager();
            $cant_servicios = $servicios_manager->getCantidadServicios($criterio);
            $importe_servicios = $servicios_manager->getImporteTotalEnServicios($criterio);
            
            $xtpl = new XTemplate(APP_PATH . 'servicios/footer.html');
            $xtpl->assign('total_servicios', $cant_servicios);
            $xtpl->assign('importe_servicios', FuncionesComunes::Format_toDecimal($importe_servicios));
            
            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }

    protected function parseClientes(XTemplate $xtpl) {
        $cliente_actual = FormatUtils::getParam('cd_cliente');
        $clienteManager = new ClienteManager();
        $criterio = new CriterioBusqueda();
        $criterio->addOrden('ds_apynom');
        $clientes = $clienteManager->getClientes($criterio);
        foreach ($clientes as $key => $cliente) {
            $xtpl->assign('ds_cliente', $cliente->getDs_apynom());
            $xtpl->assign('cd_cliente', FormatUtils::selected($cliente->getCd_cliente(), $cliente_actual));
            $xtpl->parse('main.option_cliente');
        }
    }

    protected function parseUsuarios(XTemplate $xtpl) {
        $usuario_actual = FormatUtils::getParam('cd_usuario');
        $usuarioManager = new UsuarioManager();
        $criterio = new CriterioBusqueda();
        $usuarios = $usuarioManager->getUsuarios($criterio);
        foreach ($usuarios as $key => $usuario) {
            $xtpl->assign('ds_nomusuario', $usuario->getDs_apynom());
            $xtpl->assign('cd_usuario', FormatUtils::selected($usuario->getCd_usuario(), $usuario_actual));
            $xtpl->parse('main.option_vendedor');
        }
    }

  

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $formulario=true, $modificar = true, $eliminar = true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;
        if ($modificar) {
            $href = 'doAction?action=modificar_servicio_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/edit.gif', 'Modificar ' . $lbl_entidad);
        }

        if ($ver) {
            $href = 'doAction?action=ver_servicio&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/search.gif', 'detalles de ' . $lbl_entidad);
        }
      
        
        if ($formulario) {
            $href = 'doAction?action=pdf_orden_servicio&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'img/formulario.png', 'Imprimir Orden de servicio');
        }

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_servicio&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'img/del.gif', 'eliminar Servicio');
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)
     */
    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_servicio(), 'Servicio', 'Servicio');
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Listar Servicio";
    }

    protected function getCartelEliminar(Servicio $entidad) {
        $xtpl = new XTemplate(APP_PATH . '/servicios/eliminarservicio.html');
        $xtpl->assign('cd_servicio', $entidad->getCd_servicio());
        $xtpl->assign('dt_carga', stripslashes($entidad->getDt_carga()));

        $xtpl->parse('main');
        return FormatUtils::quitarEnters($xtpl->text('main'));
    }

    /**
     * se listan entidades.
     * @return boolean (true=exito).
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();
        $xtpl->assign('WEB_PATH', WEB_PATH);

        //recuperamos los parï¿½metros.
        $filtro = FormatUtils::getParam('filtro');

        $page = $this->getPagePaginacion();

        $cd_cliente = FormatUtils::getParam('cd_cliente');
        $cd_usuario = FormatUtils::getParam('cd_usuario');
        $cd_sucursal = FormatUtils::getParam('cd_sucursal');
        $dt_desde = FormatUtils::getParam('dt_desde');
        $dt_hasta = FormatUtils::getParam('dt_hasta');
        $orden = FormatUtils::getParam('orden', 'DESC');

        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());
        $xtpl->assign('campoOrden', $campoOrden);
        $xtpl->assign('accion_listar', $this->getUrlAccionListar());
        $xtpl->assign('orden', $orden);
        $xtpl->assign('campoFiltro', $campoFiltro);
        $xtpl->assign('filtro', $filtro);
        $xtpl->assign('cd_sucursal', $cd_sucursal);
        $xtpl->assign('cd_cliente', $cd_cliente);
        $xtpl->assign('cd_usuario', $cd_usuario);
        $xtpl->assign('dt_desde', $dt_desde);
        $xtpl->assign('dt_hasta', $dt_hasta);

        //tï¿½tulo del listado.
        $xtpl->assign('titulo', $this->getTituloListado());

        //armamos el query string (para la paginaciï¿½n y la ordenaciï¿½n).
        $query_especial = "&cd_sucursal=$cd_sucursal&cd_usuario=$cd_usuario&cd_cliente=$cd_cliente&dt_desde=$dt_desde&dt_hasta=$dt_hasta&";
        $query_string = $this->getQueryString($filtro, $campoFiltro) . "id=" . $_GET['id'] . $query_especial;

        //obtenemos los elementos a mostrar.
        $criterio = $this->getCriterioBusqueda();

        try {

            $entidades = $this->getEntidadManager()->getEntidades($criterio);
            $num_rows = $this->getEntidadManager()->getCantidadEntidades($criterio);
        } catch (GenericException $ex) {
            //capturamos la excepciï¿½n para terminar de parsear el contenido y luego la volvemos a lanzar para mostrar el error.
            $entidades = new ItemCollection();
            $num_rows = 0;
            $this->getLayoutInstance()->setException($ex);
        }


        $this->tableModel = $this->getListarTableModel($entidades);

        //construimos el paginador.
        $oPaginador = $this->getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $query_especial, $page);



        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);

        return $content;
    }

    protected function getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $query_especial, $page){
		$num_pages = ceil ( $num_rows / ROW_PER_PAGE );

		//$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro;
		$url = $this->getUrlPaginador( $orden, $campoFiltro, $filtro, $campoOrden, $query_especial );
		$cssclassotherpage = 'paginadorOtraPagina';
		$cssclassactualpage = 'paginadorPaginaActual';
		$ds_pag_anterior = 0; //$gral['pag_ant'];
		$ds_pag_siguiente = 2; //$gral['pag_sig'];
		return new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	}

	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden, $query_especial ){
		$url = 'doAction?action='. $this->getUrlAccionListar() . '&orden=' . $orden . '&campoFiltro=' . $campoFiltro . '&filtro=' . $filtro. '&campoOrden=' . $campoOrden. $query_especial;
		return $url;
	}

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()
     */
    protected function getEntidadManager() {
        return new ServicioManager();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()
     */
    protected function getCampoOrdenDefault() {
        return 'S.cd_servicio';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()
     */
    protected function getMsjError1() {
        return 'No se pudo eliminar el Movimiento. Verifique que no existan datos relacionados';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return 'Administraci&oacute;n de Servicios';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)
     */

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()
     */
    protected function getUrlAccionListar() {
        return 'listar_servicios';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()
     */
    protected function getUrlAccionExportarPdf() {
        return 'pdf_servicios';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()
     */
    protected function getUrlAccionExportarExcel() {
        return 'excel_servicios';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'listar_servicios_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()
     */
    protected function getMenuActivo() {
        return "Servicios";
    }

    protected function getRowClassImpar() {
        return "td_unidad";
    }

    protected function getRowClassPar() {
        return "td_unidad";
    }

}