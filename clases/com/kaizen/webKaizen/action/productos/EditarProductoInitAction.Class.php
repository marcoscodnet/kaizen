<?php

/**
 * Acción para inicializar el contexto para editar
 * un producto.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
abstract class EditarProductoInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/productos/editarproducto.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Producto();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oProducto = FormatUtils::ifEmpty($entidad, new Producto());
		//se muestra el producto.
		$this->parseProducto( $oProducto , $xtpl);
		$this->parseTipounidades( $oProducto->getCd_tipounidad(), $xtpl);
		$this->parseMarca( $oProducto->getCd_marca(), $xtpl);
		$this->parseModelo( $oProducto->getCd_modelo(), $xtpl);
		$this->parseColor( $oProducto->getCd_color(), $xtpl );			$checekd ='';		if ($oProducto->getBl_discontinuo() == 1) {			$checekd = 'checked=checked';		}				$xtpl->assign('checked', $checekd);
	}


	protected function parseProducto(Producto $oProducto, XTemplate $xtpl){
		//se muestra el producto.
		$xtpl->assign ( 'cd_producto', $oProducto->getCd_producto());
		$xtpl->assign ( 'nu_monto_sugerido', stripslashes ( $oProducto->getNu_monto_sugerido() ) );
		$xtpl->assign ( 'nu_stock_minimo', stripslashes ( $oProducto->getNu_stock_minimo () ) );
	}

	protected function parseTipounidades($cd_selected='', XTemplate $xtpl){
		$tipounidadManager = new TipounidadManager();
		$criterio = new CriterioBusqueda();
		$tiposunidades = $tipounidadManager->getTiposunidades($criterio);

		foreach($tiposunidades as $key => $tipounidad) {
			$xtpl->assign ( 'ds_tipounidad', $tipounidad->getDs_tipounidad() );
			$xtpl->assign ( 'cd_tipounidad', FormatUtils::selected($tipounidad->getCd_tipounidad(), $cd_selected)  );
			$xtpl->parse ( 'main.option_tipounidad' );
		}
	}


	protected function parseMarca($cd_selected='', XTemplate $xtpl){
		$marcaManager = new MarcaManager();
		$criterio = new CriterioBusqueda();
		$marcas = $marcaManager->getMarcas($criterio);

		foreach($marcas as $key => $marca) {
			$xtpl->assign ( 'ds_marca', $marca->getDs_marca() );
			$xtpl->assign ( 'cd_marca', FormatUtils::selected($marca->getCd_marca(), $cd_selected));
			$xtpl->parse ( 'main.option_marca' );
		}
	}

	protected function parseModelo($cd_selected='', XTemplate $xtpl){
		$modeloManager = new ModeloManager();
		$criterio = new CriterioBusqueda();
		$modelos = $modeloManager->getModelos($criterio);

		foreach($modelos as $key => $modelo) {
			$xtpl->assign ( 'ds_modelo', $modelo->getDs_modelo() );
			$xtpl->assign ( 'cd_modelo', FormatUtils::selected($modelo->getCd_modelo(), $cd_selected));
			$xtpl->parse ( 'main.option_modelo' );
		}
	}

	protected function parseColor($cd_selected='', XTemplate $xtpl){
		//recupera y parsea países.
		$colorManager = new ColorManager();
		$criterio = new CriterioBusqueda();
		$colores = $colorManager->getColores($criterio);

		foreach($colores as $key => $color) {
			$xtpl->assign ( 'ds_color', $color->getDs_color() );
			$xtpl->assign ( 'cd_color', FormatUtils::selected($color->getCd_color(), $cd_selected)  );
			$xtpl->parse ( 'main.option_color' );
		}
	}
}