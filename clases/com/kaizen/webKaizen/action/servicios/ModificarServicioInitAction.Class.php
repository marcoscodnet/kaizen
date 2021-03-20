<?php

/**
 * Acción para inicializar el contexto para modificar
 * un servicio.
 *
 * @author Marcos
 * @since 15-05-2012
 *
 */
class ModificarServicioInitAction extends EditarServicioInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Servicio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Servicio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_servicio";
	}

	protected function parseEntidad($entidad, XTemplate $xtpl) {
		$oServicio = FormatUtils::ifEmpty($entidad["servicio"], new Servicio());		
		
		$xtpl->assign('url_altacliente', WEB_PATH . 'clientes/doAction?action=alta_cliente_min_init');
		$xtpl->assign('url_editarcliente', WEB_PATH . 'clientes/doAction?action=modificar_cliente_min_init&id=');
		 $this->parseServicio($xtpl, $oServicio);        $this->parseTiposServicios($xtpl, $oServicio->getCd_tiposervicio());        /*$this->parseUsuarios($xtpl);*/              $this->parseTipodocs($xtpl, $oServicio->getCliente()->getCd_tipodoc());                $this->parseSucursales($xtpl);        $this->parseCliente($xtpl, $oServicio->getCliente());        $this->parseVehiculoservicio($xtpl, $oServicio->getVehiculoservicio());

	}

	
 protected function parseTiposServicios(XTemplate $xtpl, $cd_tipo_servicio ="") {        $tiposervicioManager = new TiposervicioManager();        $tiposservicios = $tiposervicioManager->getTiposservicios();        $usuarioKManager = new UsuarioKaizenManager();                      foreach ($tiposservicios as $key => $tiposervicio) {            $xtpl->assign('ds_tiposervicio', $tiposervicio->getDs_tiposervicio());            $xtpl->assign('cd_tiposervicio', FormatUtils::selected($tiposervicio->getCd_tiposervicio(), $cd_tipo_servicio));            $xtpl->parse('main.option_tiposervicio');        }    }
	


	protected function parseServicio($xtpl, Servicio $entidad){
		$xtpl->assign('cd_cliente', $entidad->getCd_cliente());
		$xtpl->assign('funcion_ajax', "Modificar Servicio");
		$xtpl->assign('cd_servicio', $entidad->getCd_servicio());				
		$xtpl->assign('cd_usuario', $entidad->getCd_usuario());
		$xtpl->assign('nu_doc', $entidad->getCliente()->getNu_doc());
		$xtpl->assign('nu_monto', addslashes($entidad->getNu_monto()));				$xtpl->assign('ds_kmshoras', addslashes($entidad->getDs_kmshoras()));
				$xtpl->assign('dt_ingresovehiculo', $entidad->getDt_ingresovehiculo());				$xtpl->assign('dt_compromisoentrega', addslashes($entidad->getDt_compromisoentrega()));				$xtpl->assign('ds_descpedidocte', addslashes($entidad->getDs_descpedidocte()));				$xtpl->assign('ds_obsgral', addslashes($entidad->getDs_obsgral()));				$xtpl->assign('ds_diagyreprealizada', addslashes($entidad->getDs_diagyreprealizada()));				$xtpl->assign('ds_repuestosusados', addslashes($entidad->getDs_repuestosusados()));				$xtpl->assign('ds_mecanicos', addslashes($entidad->getDs_mecanicos()));			$xtpl->assign('ds_instmedusados', addslashes($entidad->getDs_instmedusados()));				$xtpl->assign('ds_tiempomanoobra', addslashes($entidad->getDs_tiempomanoobra()));						$checekd ='';		if ($entidad->getBl_pagado() == 1) {			$checekd = 'checked=checked';		}				$xtpl->assign('checked', $checekd);

	}
 	protected function parseVehiculoservicio($xtpl, $entidad) {      $xtpl->assign('cd_vehiculoservicio', $entidad->getCd_vehiculoservicio());             $xtpl->assign('dt_venta', $entidad->getDt_venta());        //$xtpl->assign('ds_producto', $entidad->getUnidad()->getDs_producto());                $xtpl->assign('ds_modelo', $entidad->getDs_modelo());               $xtpl->assign('nu_motor', $entidad->getNu_motor());        $xtpl->assign('nu_chasis', $entidad->getNu_chasis());		$xtpl->assign('nu_anio', $entidad->getNu_anio());      	                   }    	protected function parseSucursales(XTemplate $xtpl, $sucursal_actual ="") {        $sucursalManager = new SucursalManager();        $sucursales = $sucursalManager->getSucursales();        $usuarioKManager = new UsuarioKaizenManager();        $oUsuario = $usuarioKManager->getUsuarioPorId($_SESSION['cd_usuarioSession']);        $cd_selected = $oUsuario->getCd_sucursal();        foreach ($sucursales as $key => $sucursal) {            $xtpl->assign('ds_sucursal', $sucursal->getDs_nombre());            $xtpl->assign('cd_sucursal', FormatUtils::selected($sucursal->getCd_sucursal(), $cd_selected));            $xtpl->parse('main.option_sucursal');        }    }
	protected function parseCliente($xtpl, Cliente $oCliente){
		$xtpl_cliente = new XTemplate(APP_PATH."ventas/ajax/ajax_datoscliente.html");
		$xtpl_cliente->assign( 'ds_apynom', $oCliente->getDs_apynom());
		$xtpl_cliente->assign( 'ds_direccion', $oCliente->getDs_dircalle()." ".$oCliente->getDs_dirnro()." ".$oCliente->getDs_dirdepto()." ".$oCliente->getDs_dirpiso()  );
		$xtpl_cliente->assign( 'ds_telefono', $oCliente->getDs_teparticular());				$xtpl_cliente->parse ( 'main' );
		$texto = $xtpl_cliente->text('main');
		$xtpl->assign('datosCliente', $texto);
		$xtpl->parse("main.detalle_cliente");
	}



	protected function getEntidad(){
		$oServicio = null;
		if (isset ( $_GET ['id'] )) {
			$cd_servicio = $_GET ['id'];
			$manager = new ServicioManager();
			$oServicio = $manager->getServicioPorId( $cd_servicio );
		}
						return array("servicio" => $oServicio, "vehiculoservicio" => $oServicio->getVehiculoservicio() );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}