<?php 

/**
 * Acción para inicializar el contexto para editar
 * un modelo.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
abstract class EditarModeloInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/modelos/editarmodelo.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Modelo();
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oModelo = FormatUtils::ifEmpty($entidad, new Modelo());
		//se muestra la localidad.
		$this->parseModelo( $oModelo , $xtpl);
		$this->parseMarcas( $oModelo->getCd_marca(), $xtpl );
		//$this->parseModelos( $oModelo->getModelo()->getCd_marca(), $oModelo->getModelo()->getCd_modelo(), $xtpl );
	}
	
	
	protected function parseModelo(Modelo $oModelo, XTemplate $xtpl){
		//se muestra el localidad.
		$xtpl->assign ( 'cd_modelo', $oModelo->getCd_modelo());
		$xtpl->assign ( 'ds_modelo', stripslashes ( $oModelo->getDs_modelo () ) );
		$xtpl->assign ( 'cd_marca', stripslashes ( $oModelo->getCd_marca() ) );
	}

	protected function parseMarcas($cd_selected='', XTemplate $xtpl){
		//recupera y parsea marcas.
		$marcasManager = new MarcaManager();
		$criterio = new CriterioBusqueda();
		$marcas = $marcasManager->getMarcas($criterio);
		
		
		foreach($marcas as $key => $marca) {
			$xtpl->assign ( 'ds_marca', $marca->getDs_marca() );
			$xtpl->assign ( 'cd_marca', FormatUtils::selected($marca->getCd_marca(), $cd_selected)  );
			$xtpl->parse ( 'main.option_marca' );
		}
	}
	
	protected function parseModelos($cd_marca, $cd_selected='', XTemplate $xtpl){
		//recupera y parsea modelos.
		$localizacionManager = new LocalizacionManager();
		$cd_marca= FormatUtils::ifEmpty( $cd_marca, 0);
		$modelos = $localizacionManager->getModelosPorMarca($cd_marca);
		
		foreach($modelos as $key => $modelo) {
			$xtpl->assign ( 'ds_modelo', $modelo->getDs_modelo() );
			$xtpl->assign ( 'cd_modelo', FormatUtils::selected($modelo->getCd_modelo(), $cd_selected)  );
			$xtpl->parse ( 'main.option_modelo' );
		}
	}
	
}