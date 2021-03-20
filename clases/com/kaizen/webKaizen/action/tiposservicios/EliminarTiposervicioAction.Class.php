<?php 

/**
 * Acción para eliminar un color.
 * 
 * @author Marcos
 * @since 15-05-2012
 * 
 */
class EliminarTiposervicioAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_tiposervicio = $_GET ['id'];
	
		$manager = new TiposervicioManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarTiposervicio( $cd_tiposervicio );
			$forward = 'eliminar_tiposervicio_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_tiposervicio_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}
	

	public function getFuncion(){
		return "Baja Tipo de servicio";
	}
	
}