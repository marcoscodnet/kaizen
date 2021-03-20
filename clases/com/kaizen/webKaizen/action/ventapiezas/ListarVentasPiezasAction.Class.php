<?php



/**

 * Acci�n listar Movimientos.

 *

 * @author Lucrecia

 * @since 18-01-2011

 *

 */

class ListarVentasPiezasAction extends ListarAction {



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)

	 */

	protected function getListarTableModel(ItemCollection $items) {

		unset($_SESSION['piezasavender']);

		return new VentaPiezaTableModel($items);

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()

	 */

	protected function getOpciones() {

		$opciones[] = $this->buildOpcion('altaVentaPieza', 'Registrar venta de Piezas', 'alta_ventaPieza_init');

		return $opciones;

	}













	protected function getCriterioBusqueda(){

		//recuperamos los par�metros.

		$filtro = FormatUtils::getParam('filtro');

		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );


		 $cd_cliente = FormatUtils::getParam('cd_cliente');

        $cd_usuario = FormatUtils::getParam('cd_usuario');



        $dt_desde = FormatUtils::getParam('dt_desde');

        $dt_hasta = FormatUtils::getParam('dt_hasta');

		$page = $this->getPagePaginacion();

		$orden = FormatUtils::getParam('orden','DESC');

		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );





		$criterio = new CriterioBusqueda();

		 if ($cd_usuario != "") {

            $criterio->addFiltro('VP.cd_usuario', $cd_usuario, "=");

        }





        if ($dt_desde != "") {

            $dt_desde = str_replace("/", "-", $dt_desde);

            $dt_desde = implode("/", array_reverse(explode("-", $dt_desde)));

            $criterio->addFiltro('VP.dt_ventapieza', "'$dt_desde'", ">=");

        }

        if ($dt_hasta != "") {

            $dt_hasta = str_replace("/", "-", $dt_hasta);

            $dt_hasta = implode("/", array_reverse(explode("-", $dt_hasta)));

            $criterio->addFiltro('VP.dt_ventapieza', "'$dt_hasta'", "<=");

        }



		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);



		$criterio->addOrden($campoOrden, $orden);
		$criterio->addGroupBy('VP.cd_ventapieza,S.ds_nombre,S.ds_domicilio,S.ds_telefono,S.ds_email,S.ds_comentario,S.cd_localidad');
		$criterio->setPage($page);

		$criterio->setRowPerPage(ROW_PER_PAGE);

		return $criterio;



	}

	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()

	 */

	protected function getFiltros() {

		//$filtros[] = $this->buildFiltro("ds_descripcion", $this->tableModel->getColumnName(1));

        $filtros[] = $this->buildFiltro("dt_ventapieza", $this->tableModel->getColumnName(0));
        $filtros[] = $this->buildFiltro("ds_apynomcliente", $this->tableModel->getColumnName(1));
        $filtros[] = $this->buildFiltro("nu_pedidoreparacion", $this->tableModel->getColumnName(2));
        $filtros[] = $this->buildFiltro("ds_codigo", $this->tableModel->getColumnName(7));


		return $filtros;

	}


 protected function getFiltrosEspeciales() {

        $xtpl = new XTemplate(APP_PATH . 'ventaspiezas/criterio_unidades.html');





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

	protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $remito=true, $autorizar = true, $eliminar = true, $modificar = true) {



		if (empty($lbl_entidad))

		$lbl_entidad = $nombre_entidad;



		if ($ver) {



			$href = 'doAction?action=ver_ventaPieza&id=' . $id;

			$this->parseAccion($xtpl, '', $href, 'img/search.gif', 'detalles de ' . $lbl_entidad);

		}

		if ($remito) {

			$href = 'doAction?action=pdf_detalle_ventapieza&id=' . $id;

			$this->parseAccion($xtpl, '', $href, 'img/pdf.png', 'detalles de ' . $lbl_entidad);

		}

		if($modificar){

			$href = 'doAction?action=modificar_ventaPieza_init&id=' . $id;

			$this->parseAccion( $xtpl, '', $href, 'img/edit.gif' , 'editar datos de ' . $lbl_entidad);

		}

		if($eliminar){

			$onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($lbl_entidad) . "', this,'doAction?action=eliminar_ventapieza&id=" . $id . "'); return false;" ;

			$this->parseAccion( $xtpl, $onclick, '', 'img/del.gif' , 'eliminar '  . $lbl_entidad);

		}

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#parseAcciones($xtpl, $item)

	 */

	protected function parseAcciones(XTemplate $xtpl, $item) {



		$this->parseAccionesDefault($xtpl, $item, $item->getCd_ventapieza(), 'Venta Pieza', 'Venta Pieza');

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()

	 */

	public function getFuncion() {

		return "Listar Venta Pieza";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()

	 */

	protected function getEntidadManager() {

		return new VentaPiezaManager();

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()

	 */

	protected function getCampoOrdenDefault() {

		return 'VP.cd_ventapieza';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()

	 */

	protected function getMsjError1() {

		return 'No se pudo eliminar la venta de pieza. Verifique que no existan datos relacionados';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()

	 */

	protected function getTitulo() {

		return 'Administraci&oacute;n de Ventas de Piezas';

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

		return 'listar_ventasPiezas';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()

	 */

	protected function getUrlAccionExportarPdf() {

		return 'pdf_ventaspiezas';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()

	 */

	protected function getUrlAccionExportarExcel() {

		return 'excel_ventaspiezas';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()

	 */

	protected function getForwardError() {

		return 'listar_ventaspiezas_error';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()

	 */

	protected function getMenuActivo() {

		return "Ventas Piezas";

	}



}
