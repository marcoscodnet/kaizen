<?php 

/**
 * Acción para inicializar el contexto para editar
 * una obra.
 * 
 * @author Lucrecia
 * @since 08-04-2010
 * 
 */
abstract class EditarObraInitAction extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/obras/editarobra.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Obra();
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oObra = FormatUtils::ifEmpty($entidad, new Obra());
		//se muestra la obra.
		$this->parseObra( $oObra , $xtpl);
		$this->parseDistritos( $oObra->getDistrito()->getCd_referencia(), $xtpl );
		$this->parseCentrales( $oObra->getCentral()->getCd_referencia(), $xtpl );
		$this->parseMotivos( $oObra->getMotivo()->getCd_referencia(), $xtpl );
		$this->parseTiposObra( $oObra->getTipoObra()->getCd_referencia(), $xtpl );
		$this->parseSubtiposObra( $oObra->getSubtipoObra()->getCd_referencia(), $xtpl );
	}
		
	
	
	protected function parseObra(Obra $oObra, XTemplate $xtpl){
		//se muestra la obra.
		$xtpl->assign ( 'cd_obra', $oObra->getCd_obra());
		$xtpl->assign ( 'ds_titulo',  $oObra->getDs_titulo ()  );
		$xtpl->assign ( 'ds_domicilio',  $oObra->getDs_domicilio () );
		$xtpl->assign ( 'nu_tipoObra',  FormatUtils::formatEmpty( $oObra->getNu_tipoObra() )  );
		$xtpl->assign ( 'nu_subtipoObra',  FormatUtils::formatEmpty( $oObra->getNu_subtipoObra () )  );
		$xtpl->assign ( 'nu_siniestro',  FormatUtils::formatEmpty( $oObra->getNu_siniestro() ) );
		
		if( !FormatUtils::isEmpty( $oObra->getDt_fecha() ))
			$xtpl->assign ( 'dt_fecha',  FuncionesComunes::fechaMysqlaPHP ( $oObra->getDt_fecha() ) );
		
	}

	protected function parseDistritos($cd_selected='', XTemplate $xtpl){
		//recupera y parsea distritos.
		$manager = new DistritoManager();
		$distritos = $manager->getReferencias();		
		foreach($distritos as $key => $distrito) {
			$xtpl->assign ( 'ds_distrito', $distrito->getDs_referencia() );
			$xtpl->assign ( 'cd_distrito', FormatUtils::selected($distrito->getCd_referencia(), $cd_selected) );
			$xtpl->parse ( 'main.option_distrito' );
		}
			
	}
	
	protected function parseCentrales($cd_selected='', XTemplate $xtpl){
		//recupera y parsea centrales.
		$manager = new CentralManager();
		$centrales = $manager->getReferencias();		
		foreach($centrales as $key => $central) {
			$xtpl->assign ( 'ds_central', $central->getDs_referencia() );
			$xtpl->assign ( 'cd_central', FormatUtils::selected($central->getCd_referencia(), $cd_selected) );
			$xtpl->parse ( 'main.option_central' );
		}
	}		

	protected function parseMotivos($cd_selected='', XTemplate $xtpl){
		//recupera y parsea motivos.
		$manager = new MotivoManager();
		$motivos = $manager->getReferencias();		
		foreach($motivos as $key => $motivo) {
			$xtpl->assign ( 'ds_motivo', $motivo->getDs_referencia() );
			$xtpl->assign ( 'cd_motivo', FormatUtils::selected($motivo->getCd_referencia(), $cd_selected) );				
			$xtpl->parse ( 'main.option_motivo' );
		}
	}		

	protected function parseTiposObra($cd_selected='', XTemplate $xtpl){
		//recupera y parsea tipos de obra.
		$manager = new TipoObraManager();
		$tiposObra = $manager->getReferencias();		
		foreach($tiposObra as $key => $tipoObra) {
			$xtpl->assign ( 'ds_tipoObra', $tipoObra->getDs_referencia() );
			$cd_referencia = $tipoObra->getCd_referencia();
			$xtpl->assign ( 'cd_tipoObra', FormatUtils::selected($cd_referencia, $cd_selected) );				
			$xtpl->parse ( 'main.option_tipoObra' );
		}
	}
	
	protected function parseSubtiposObra($cd_selected='', XTemplate $xtpl){
		//recupera y parsea subtipos de obra.
		$manager = new SubtipoObraManager();
		$subtiposObra = $manager->getReferencias();		
		foreach($subtiposObra as $key => $subtipoObra) {
			$xtpl->assign ( 'ds_subtipoObra', $subtipoObra->getDs_referencia() );
			$xtpl->assign ( 'cd_subtipoObra', FormatUtils::selected($subtipoObra->getCd_referencia(), $cd_selected) );				
			$xtpl->parse ( 'main.option_subtipoObra' );
		}
	}
	
}