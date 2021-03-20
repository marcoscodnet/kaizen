<?php 

/**
 * Acción para visualizar una obra.
 *  
 * @author Lucrecia
 * @since 08-04-2010
 * 
 */
class VerObraAction extends SecureOutputAction{

	/**
	 * consulta una obra.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'obras/verobra.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_obra = $_GET ['id'];
			
			$manager = new ObraManager();
			
			$oObra = $manager->getObraPorId ( $cd_obra );
			$this->parseObra( $oObra, $xtpl );
				
		}
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver Obra";
	}
	
	protected function getTitulo(){
		return "Detalle de Obra";
	}
	
	private function parseObra(Obra $oObra, XTemplate $xtpl){
		//se muestra la obra.
		$xtpl->assign ( 'cd_obra', $oObra->getCd_obra());
		$xtpl->assign ( 'ds_titulo', stripslashes ( $oObra->getDs_titulo () ) );
		$xtpl->assign ( 'ds_domicilio', stripslashes ( $oObra->getDs_domicilio () ) );
		$xtpl->assign ( 'nu_tipoObra', stripslashes ( FormatUtils::formatEmpty( $oObra->getNu_tipoObra() ) ) );
		$xtpl->assign ( 'nu_subtipoObra', stripslashes ( FormatUtils::formatEmpty( $oObra->getNu_subtipoObra () ) ) );
		$xtpl->assign ( 'nu_siniestro', stripslashes ( FormatUtils::formatEmpty( $oObra->getNu_siniestro() ) ) );
		
		if( !FormatUtils::isEmpty( $oObra->getDt_fecha() ))
			$xtpl->assign ( 'dt_fecha',  FuncionesComunes::fechaMysqlaPHP ( $oObra->getDt_fecha() ) );

		$xtpl->assign ( 'ds_motivo', stripslashes ( $oObra->getDs_motivo () ) );
		$xtpl->assign ( 'ds_central', stripslashes ( $oObra->getDs_central () ) );
		$xtpl->assign ( 'ds_distrito', stripslashes ( $oObra->getDs_distrito () ) );
		$xtpl->assign ( 'ds_tipoObra', stripslashes ( $oObra->getDs_tipoObra () ) );
		$xtpl->assign ( 'ds_subtipoObra', stripslashes ( $oObra->getDs_subtipoObra () ) );
			
	}
	
	
}