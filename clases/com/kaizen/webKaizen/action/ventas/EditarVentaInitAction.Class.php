<?php

/**
 * Acci�n para inicializar el contexto para editar
 * un movimiento.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
abstract class EditarVentaInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(APP_PATH . '/ventas/editarVenta.html');
    }

    protected function getEntidad() {
        unset($_SESSION['pagos']);
        $_SESSION['pagos'] = serialize(new ItemCollection());
        $oUnidad = null;
        if (isset($_GET ['id'])) {
            //recuperamos dado su identifidor.
            $cd_unidad = $_GET ['id'];

            $manager = new UnidadManager();
            $oUnidad = $manager->getUnidadPorId($cd_unidad);
        }

        return $oUnidad;
    }

    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oUnidad = FormatUtils::ifEmpty($entidad, new Unidad());
        //se muestra el Movimiento.

        $xtpl->assign('url_altacliente', WEB_PATH . 'clientes/doAction?action=alta_cliente_min_init');
        $xtpl->assign('url_editarcliente', WEB_PATH . 'clientes/doAction?action=modificar_cliente_min_init&id=');
        if ($this->tienePermisoFuncion(MODIFICAR_PAGO_ACCION)) {
            $xtpl->assign('tiene_permiso', 1);
        } else {
            $xtpl->assign('tiene_permiso', 0);
        }
        $xtpl->assign('funcion_ajax', "Alta Venta");
        $this->parseNu_total($xtpl, $oUnidad->getNu_monto_sugerido());
        $this->parseDtVenta($xtpl, date('d/m/Y'));
        $this->parseSucursales($xtpl);
        $this->parseUsuarios($xtpl);
        $this->parseFormaspago($xtpl);
        $this->parseTipodocs($xtpl);
        $this->parseCliente($xtpl);
        $this->parseUnidad($xtpl, $oUnidad);
    }

    protected function parseCliente($xtpl) {
        $xtpl->parse("main.detalle_vacio");
    }

    protected function parseUnidad($xtpl, $entidad) {
        $unidadManager = new UnidadManager();
        if (!$unidadManager->estaAutorizada($entidad->getCd_unidad()) && $this->tienePermisoFuncion(AUTORIZAR_UNIDAD_ACCION)) {
            $xtpl->assign('consulta_autorizar', 1);
        } else {
            $xtpl->assign('consulta_autorizar', 0);
        }
        $xtpl->assign('ds_producto', $entidad->getDs_producto());
        $xtpl->assign('cd_unidad', $entidad->getCd_unidad());
        $xtpl->assign('nu_motor', $entidad->getNu_motor());
        $xtpl->assign('nu_cuadro', $entidad->getNu_cuadro());
        $xtpl->assign('ds_sucursal', $entidad->getDs_sucursal());
        $xtpl->assign('nu_montosugerido', $entidad->getNu_monto_sugerido());
    }

    protected function parseDtVenta($xtpl, $dt_fecha) {
        $xtpl->assign('dt_fecha', $dt_fecha);
    }

    protected function parseNu_total($xtpl, $nu_totalventa) {
        $xtpl->assign('nu_totalventa', $nu_totalventa);
    }

    protected function parseFormaspago($xtpl, $formapago_actual ="") {
        $formapagoManager = new FormapagoManager();
        $criterio = new CriterioBusqueda();
        $formasdepago = $formapagoManager->getFormasdepago($criterio);
        foreach ($formasdepago as $formapago) {
            $xtpl->assign('cd_formapago', FormatUtils::selected($formapago->getCd_formapago(), $formapago_actual));
            $xtpl->assign('ds_formapago', $formapago->getDs_formapago());
            $xtpl->parse('main.option_formapago');
        }
    }

    protected function parseSucursales(XTemplate $xtpl, $sucursal_actual ="") {		
        $sucursalManager = new SucursalManager();
        $sucursales = $sucursalManager->getSucursales();        if ($sucursal_actual =="") {        	$usuarioKManager = new UsuarioKaizenManager();        	$oUsuario = $usuarioKManager->getUsuarioPorId($_SESSION['cd_usuarioSession']);        	$cd_selected = $oUsuario->getCd_sucursal();        	        }        else{        	$cd_selected = $sucursal_actual;        }        
       
        foreach ($sucursales as $key => $sucursal) {
            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());
            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));
            $xtpl->parse('main.option_sucursal');
        }
    }

    protected function parseUsuarios(XTemplate $xtpl, $usuario_actual ="") {
        $usuarioManager = new UsuarioManager();
        $criterio = new CriterioBusqueda();		$criterio->addFiltro('bl_activo', 1, '=');
        $usuarios = $usuarioManager->getUsuarios($criterio);
        if ($usuario_actual == "") {
            $usuario_actual = $_SESSION['cd_usuarioSession'];
        }
        foreach ($usuarios as $key => $usuario) {
            $xtpl->assign('ds_usuario', $usuario->getDs_nomusuario());
            $xtpl->assign('cd_usuario', FormatUtils::selected($usuario->getCd_usuario(), $usuario_actual));
            $xtpl->parse('main.option_usuario');
        }
    }

    protected function parseTipodocs(XTemplate $xtpl, $tipodoc_actual ="") {
        $tipodocManager = new TipodocManager();
        $criterio = new CriterioBusqueda();
        $tipodocs = $tipodocManager->getTiposdocs($criterio);
        foreach ($tipodocs as $key => $tipodoc) {
            $xtpl->assign('ds_tipodoc', $tipodoc->getDs_tipodoc());
            $xtpl->assign('cd_tipodoc', FormatUtils::selected($tipodoc->getCd_tipodoc(), $tipodoc_actual));
            $xtpl->parse('main.option_tipodoc');
        }
    }

}