<?php 

/**
 * Acción para eliminar una sucursal.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarSucursalAction extends SecureAction{

	/**
	 * se elimina una sucursal.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_sucursal = $_GET ['id'];
	
		//se elimina la sucursal.
		$manager = new SucursalManager();

		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarSucursal( $cd_sucursal );
			$forward = 'eliminar_sucursal_success';
			//commit de la transacción.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_sucursal_error';
			$msj = "Error al intentar borrar las sucursal. Verifique que no haya unidades relacionadas";
			$this->setDs_forward_params( 'er=1'.'&msg=' .$msj . '&code=' . $ex->getCode());
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja Sucursal";
	}
	
}