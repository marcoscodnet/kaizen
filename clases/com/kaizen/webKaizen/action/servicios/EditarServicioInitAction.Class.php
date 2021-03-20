<?php

/**
 * Acción para inicializar el contexto para editar
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
               $xtpl->assign('dt_ingresovehiculo', date('d/m/Y H:i:s'));        //$xtpl->assign('dt_compromisoentrega', date('d/m/Y'));
        $this->parseTiposServicios($xtpl);
        /*$this->parseUsuarios($xtpl);*/
     	$this->parseSucursales($xtpl);
        $this->parseTipodocs($xtpl, $oVenta->getCliente()->getCd_tipodoc());                
        $this->parseCliente($xtpl, $oVenta->getCliente());
        $this->parseVenta($xtpl, $oVenta);
    }
	protected function parseSucursales(XTemplate $xtpl, $sucursal_actual ="") {        $sucursalManager = new SucursalManager();        $sucursales = $sucursalManager->getSucursales();        $usuarioKManager = new UsuarioKaizenManager();        $oUsuario = $usuarioKManager->getUsuarioPorId($_SESSION['cd_usuarioSession']);        $cd_selected = $oUsuario->getCd_sucursal();        foreach ($sucursales as $key => $sucursal) {            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));            $xtpl->parse('main.option_sucursal');        }    }    
    protected function parseCliente($xtpl, Cliente $oCliente) {
        $xtpl_cliente = new XTemplate(APP_PATH."ventas/ajax/ajax_datoscliente.html");		$xtpl_cliente->assign( 'ds_apynom', $oCliente->getDs_apynom());		$xtpl_cliente->assign( 'ds_direccion', $oCliente->getDs_dircalle()." ".$oCliente->getDs_dirnro()." ".$oCliente->getDs_dirdepto()." ".$oCliente->getDs_dirpiso()  );		$xtpl_cliente->assign( 'ds_telefono', $oCliente->getDs_teparticular());				 $xtpl->assign('nu_doc', $oCliente->getNu_doc());				$xtpl->assign('cd_cliente', $oCliente->getCd_cliente());		$xtpl_cliente->parse ( 'main' );		$texto = $xtpl_cliente->text('main');		$xtpl->assign('datosCliente', $texto);		$xtpl->parse("main.detalle_cliente");
    }

    protected function parseVenta($xtpl, $entidad) {
       
       $xtpl->assign('dt_venta', str_replace (substr ( $entidad->getDt_fecha(), - 9 ),'',$entidad->getDt_fecha()));
        $xtpl->assign('ds_producto', $entidad->getUnidad()->getDs_producto());                $xtpl->assign('ds_modelo', $entidad->getUnidad()->getDs_modelo());
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