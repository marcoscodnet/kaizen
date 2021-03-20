<?php 

/**
 * Acción para visualizar los trabajadores asignados a una obra.
 *  
 * @author Lucrecia
 * @since 08-04-2010
 * 
 */
class VerTrabajadoresObraAction extends SecureOutputAction{

	/**
	 * consulta una obra.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'obras/vertrabajadoresobra.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_obra = $_GET ['id'];
			
			$manager = new ObraManager();
			
			$oObra = $manager->getObraPorId ( $cd_obra );
			$this->parseObra( $oObra, $xtpl );
			
			$trabajadores = $this->getTrabajadores( $oObra );
			$this->parseTrabajadores( $trabajadores, $xtpl );
				
		}
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver Obra";
	}
	
	protected function getTitulo(){
		return "Trabajadores asignados a Obra";
	}
	
	private function parseObra(Obra $oObra, XTemplate $xtpl){
		//se muestra la obra.
		$xtpl->assign ( 'cd_obra', $oObra->getCd_obra());
		$xtpl->assign ( 'ds_tipoObra', stripslashes ( $oObra->getDs_tipoObraFormateada() ) );
		$xtpl->assign ( 'ds_subtipoObra', stripslashes ( $oObra->getDs_subtipoObraFormateada() ) );
	}

	protected function getTrabajadores( Obra $oObra=null){
		$trabajadores = null;		
		if ( $oObra!=null ) {
			//recuperamos la obra dado su identifidor.
			$manager = new ObraManager();
			$trabajadores = $manager->getTrabajadores( $oObra );
		}else 
			$trabajadores = new ItemCollection();
		
		return $trabajadores;
	}



	private function parseTrabajadores(ItemCollection $trabajadores, XTemplate $xtpl){
		//se muestran los trabajadores asignados a la obra.
		foreach ($trabajadores as $key => $oTrabajadorObra){
			
			if($oTrabajadorObra->getCd_tipoTrabajador()==CONTRATISTA ){
				$xtpl->assign('cd_contratista', $oTrabajadorObra->getCd_trabajadorObra());
				$xtpl->assign ( 'ds_nombre', stripslashes ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
				$xtpl->parse ('main.option_contratista');
			}else{
				$xtpl->assign('nu_numero', $oTrabajadorObra->getCd_trabajadorObra());
				$xtpl->assign ( 'ds_responsable', stripslashes ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
				$xtpl->parse ('main.option_cuadrilla');
				
			}
		}
		
	}
	
	
}