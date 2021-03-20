<?php



/**

 * Acci�n listar productos.

 *

 * @author Lucrecia

 * @since 18-01-2011

 *

 */

class ListarProductosAction extends ListarAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getListarTableModel($items)

	 */

	protected function getListarTableModel( ItemCollection $items ){

		return new ProductoTableModel($items);

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getOpciones()

	 */

	protected function getOpciones(){

		$opciones[]= $this->buildOpcion('altaproducto', 'Agregar Producto', 'alta_producto_init');

		return $opciones;

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getFiltros()

	 */

	protected function getFiltros(){

		$filtros[]= $this->buildFiltro('ds_tipo_unidad', $this->tableModel->getColumnName(1));

		$filtros[]= $this->buildFiltro('ds_marca', $this->tableModel->getColumnName(2));

		$filtros[]= $this->buildFiltro('ds_modelo', $this->tableModel->getColumnName(3));

		$filtros[]= $this->buildFiltro('ds_color', $this->tableModel->getColumnName(4));

		return $filtros;

	}



	protected function getCriterioBusqueda(){

		//recuperamos los par�metros.

		$filtro = FormatUtils::getParam('filtro');

		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );





		$sub_stock = FormatUtils::getParam('sub_stock', null);

		$page = $this->getPagePaginacion();

		$orden = FormatUtils::getParam('orden','DESC');

		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );



		//obtenemos las entidades a mostrar.

		$criterio = new CriterioBusqueda();

		if($sub_stock == 1){

			$criterio->addGroupBy("cd_producto");

			$criterio->addFiltroHaving("nu_stock_minimo", "stock_actual", ">");

		}

		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);



		$criterio->addOrden($campoOrden, $orden);

		$criterio->setPage($page);

		$criterio->setRowPerPage(ROW_PER_PAGE);

		return $criterio;

	}



	protected function getFiltrosEspeciales(){

		$xtpl =  new XTemplate(APP_PATH .  'productos/criterio_productos.html');

		$sub_stock = FormatUtils::getParam('sub_stock', null);



		if($sub_stock ==1){

			$xtpl->assign('substock_checked', 'checked');

		}

		$xtpl->parse('main');

		return $xtpl->text('main');

	}



	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden ){

		$url = 'doAction?action='. $this->getUrlAccionListar() . '&orden=' . $orden . '&campoFiltro=' . $campoFiltro . '&filtro=' . $filtro. '&campoOrden=' . $campoOrden.'&sub_stock='.$_GET['sub_stock'];

		return $url;

	}



	protected function parseAcciones(XTemplate $xtpl, $item){



		$this->parseAccionesDefault( $xtpl, $item, $item->getCd_producto(), 'producto', 'producto' );

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()

	 */

	public function getFuncion(){

		return "Listar producto";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getEntidadManager()

	 */

	protected function getEntidadManager(){

		return new ProductoManager();

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCampoOrdenDefault()

	 */

	protected function getCampoOrdenDefault(){

		return 'ds_tipo_unidad';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getMsjError1()

	 */

	protected function getMsjError1(){

		return 'No se pudo eliminar el producto. Verifique que no existan datos relacionados';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()

	 */

	protected function getTitulo(){

		return 'Administraci�n de Productos';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getCartelEliminar($entidad)

	 */

	protected function getCartelEliminar($entidad){

		$xtpl = new XTemplate ( APP_PATH .'/productos/eliminarproducto.html' );

		$xtpl->assign ( 'cd_producto', $entidad->getCd_producto() );

		$xtpl->assign ( 'ds_tipounidad', $entidad->getDs_tipounidad() );

		$xtpl->assign ( 'ds_marca', $entidad->getDs_marca() );

		$xtpl->assign ( 'ds_modelo', $entidad->getDs_modelo() );

		$xtpl->assign ( 'ds_color', $entidad->getDs_color() );



		$xtpl->parse('main');

		return FormatUtils::quitarEnters( $xtpl->text('main') );

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionListar()

	 */

	protected function getUrlAccionListar(){

		return 'listar_productos';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarPdf()

	 */

	protected function getUrlAccionExportarPdf(){

		return 'pdf_productos';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getUrlAccionExportarExcel()

	 */

	protected function getUrlAccionExportarExcel(){

		return 'excel_productos';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/ListarAction#getForwardError()

	 */

	protected function getForwardError(){

		return 'listar_productos_error';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureOutputAction#getMenuActivo()

	 */

	protected function getMenuActivo(){

		return "Productos";

	}







}
