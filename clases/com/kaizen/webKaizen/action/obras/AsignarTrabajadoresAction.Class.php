<?php 

/**
 * Acción para asignar trabajadores a una obra.
 *
 * @author Lucrecia
 * @since 09-04-2010
 * 
 */
class AsignarTrabajadoresAction extends SecureAction{

	/**
	 * se asignan trabajadores a una obra.
	 * @return forward.
	 */
	public function executeImpl(){
		
		$oObra = $this->getObra();
		$trabajadores = $this->getTrabajadores();
		
		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			$manager = new ObraManager();
			$manager->asignarTrabajadores( $oObra, $trabajadores );
			$this->setDs_forward_params( 'id='. $oObra->getCd_obra() );
			$forward = 'asignar_trabajadores_obra_success';
			//commit de la transacción.
			DbManager::save();
		}catch(GenericException $ex){
			$forward = 'asignar_trabajadores_obra_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode() . '&id=' . $oObra->getCd_obra() );
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Asignar Trabajadores a Obra";
	}

	private function getObra(){
		$oObra = new Obra();
		$oObra->setCd_obra( addslashes ( $_POST ['cd_obra'] ) );
		return $oObra;
	}
	
	private function getTrabajadores(){
		//obtenemos los trabajadores de la sesión.
		$trabajadores = new ItemCollection();
		$count = count($_SESSION['trabajadores_obra']);
		for($i=0;$i<$count;$i++) {
	    	$oTrabajadorObra =   unserialize( $_SESSION['trabajadores_obra'][$i] );
			$trabajadores->addItem( $oTrabajadorObra );	    	
		}	
		return $trabajadores;
	}
	
}