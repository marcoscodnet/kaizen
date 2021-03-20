<?php 

/**
 * Acción para inicializar el contexto para asignar trabajadores
 * a una obra.
 * 
 * @author Lucrecia
 * @since 09-04-2010
 * 
 */
class AsignarTrabajadoresInitAction extends SecureOutputAction{

	/**
	 * inicializa el contexto para asignar trabajadores a
	 * una obra.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH. '/obras/asignartrabajadoresobra.html' );
		
		$oObra = $this->getObra ();
		$this->parseObra( $oObra, $xtpl );
		
		//se chequean los errores.
		if (isset ( $_GET ['msg'] )) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$mensaje =  "<script> mensajeErrorEliminar('".     $_GET ['msg']       . "'); </script>";
			$xtpl->assign ( 'msj', $mensaje );
			
			//volvemos a mostrar los trabajadores asignados.				
			$this->parseTrabajadoresSesion( $xtpl );
			
		}else{
			
			//inicializamos los trabajadores a cero.
			unset ( $_SESSION ['trabajadores_obra'] );

			$trabajadores = $this->getTrabajadores( $oObra );
			$this->parseTrabajadores( $trabajadores, $xtpl );
		}		
	

		
		
		$xtpl->parse ( 'main.msj' );
		
		$xtpl->assign ( 'titulo', 'Asignar Trabajadores a Obra' );
		

		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Asignar Trabajadores a Obra";
	}
	
	public function getTitulo(){
		return "Asignar Trabajador a Obra";
	}

	protected function getObra(){
		$oObra = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_obra = $_GET ['id'];			
			
			$manager = new ObraManager();
			$oObra = $manager->getObraPorId( $cd_obra );
		}else 
			$oObra = new Obra();
		
		return $oObra;
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
		$i=0;
		foreach ($trabajadores as $key => $oTrabajadorObra){
			
			if($oTrabajadorObra->getCd_tipoTrabajador()==CONTRATISTA ){
				$xtpl->assign('cd_contratista', $oTrabajadorObra->getCd_trabajadorObra());
				$xtpl->assign ( 'ds_nombre', stripslashes ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
				$xtpl->assign ( 'indice', stripslashes ( $i ) );
				$xtpl->parse ('main.option_contratista');
			}else{
				$xtpl->assign('nu_numero', $oTrabajadorObra->getNu_numero());
				$xtpl->assign ( 'ds_responsable', stripslashes ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
				$xtpl->assign ( 'indice', stripslashes ( $i ) );
				$xtpl->parse ('main.option_cuadrilla');
				
			}
			$_SESSION['trabajadores_obra'][] = serialize( $oTrabajadorObra );
			$i++;
		}
		
	}

	private function parseTrabajadoresSesion(XTemplate $xtpl){
		//se muestran los trabajadores que están en sesión.
		$count = count($_SESSION['trabajadores_obra']);
		for($i=0;$i<$count;$i++) {

			$oTrabajadorObra =   unserialize( $_SESSION['trabajadores_obra'][$i] );
			if($oTrabajadorObra->getCd_tipoTrabajador()==CONTRATISTA ){
				$xtpl->assign('cd_contratista', $oTrabajadorObra->getCd_trabajadorObra());
				$xtpl->assign ( 'ds_nombre', stripslashes ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
				$xtpl->assign ( 'indice', stripslashes ( $i ) );
				$xtpl->parse ('main.option_contratista');
			}else{
				$xtpl->assign('nu_numero', $oTrabajadorObra->getNu_numero());
				$xtpl->assign ( 'ds_responsable', stripslashes ( $oTrabajadorObra->getTrabajador()->getDs_nombre() ) );
				$xtpl->assign ( 'indice', stripslashes ( $i ) );
				$xtpl->parse ('main.option_cuadrilla');
				
			}
		}
		
	}

	
}