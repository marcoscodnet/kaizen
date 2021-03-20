<?php

/**
 * Acci�n para inicializar el contexto para editar
 * un servicio.
 *
 * @author Marcos
 * @since 17-05-2012
 *
 */
abstract class EditarServicioInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(APP_PATH . '/servicios/editarServicio.html');
    }

    protected function getEntidad() {
       
        $oVenta = null;
        if (isset($_GET ['id'])) {
            //recuperamos dado su identifidor.
            $cd_venta = $_GET ['id'];

            $manager = new VentaManager();
            $oVenta = $manager->getVentaPorId($cd_venta);
        }

        return $oVenta;
    }

    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oVenta = FormatUtils::ifEmpty($entidad, new Venta());
        //se muestra el Movimiento.

        $xtpl->assign('url_altacliente', WEB_PATH . 'clientes/doAction?action=alta_cliente_min_init');
        $xtpl->assign('url_editarcliente', WEB_PATH . 'clientes/doAction?action=modificar_cliente_min_init&id=');
       
        $xtpl->assign('funcion_ajax', "Alta Servicio");
        //$this->parseNu_total($xtpl, $oUnidad->getNu_monto_sugerido());
       
        $this->parseTiposServicios($xtpl);
        /*$this->parseUsuarios($xtpl);*/
     	$this->parseSucursales($xtpl);
        $this->parseTipodocs($xtpl, $oVenta->getCliente()->getCd_tipodoc());
        $this->parseCliente($xtpl, $oVenta->getCliente());
        $this->parseVenta($xtpl, $oVenta);
    }

    protected function parseCliente($xtpl, Cliente $oCliente) {
        $xtpl_cliente = new XTemplate(APP_PATH."ventas/ajax/ajax_datoscliente.html");
    }

    protected function parseVenta($xtpl, $entidad) {
       
       $xtpl->assign('dt_venta', str_replace (substr ( $entidad->getDt_fecha(), - 9 ),'',$entidad->getDt_fecha()));
        $xtpl->assign('ds_producto', $entidad->getUnidad()->getDs_producto());
        $xtpl->assign('cd_unidad', $entidad->getUnidad()->getCd_unidad());
        $xtpl->assign('nu_motor', $entidad->getUnidad()->getNu_motor());
        $xtpl->assign('nu_chasis', $entidad->getUnidad()->getNu_cuadro());
		$xtpl->assign('nu_anio', $entidad->getUnidad()->getNu_aniomodelo());
      	
    }

   

  

    protected function parseTiposServicios(XTemplate $xtpl, $cd_tipo_servicio ="") {
        $tiposervicioManager = new TiposervicioManager();
        $tiposservicios = $tiposervicioManager->getTiposservicios();
        $usuarioKManager = new UsuarioKaizenManager();
       
       
        foreach ($tiposservicios as $key => $tiposervicio) {
            $xtpl->assign('ds_tiposervicio', $tiposervicio->getDs_tiposervicio());
            $xtpl->assign('cd_tiposervicio', FormatUtils::selected($tiposervicio->getCd_tiposervicio(), $cd_tipo_servicio));
            $xtpl->parse('main.option_tiposervicio');
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