<?php 

/**
 * Acci�n para eliminar un almac�n.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
class EliminarAlmacenAction extends SecureAction{

	/**
	 * se elimina un almac�n.
	 */
	public function executeImpl(){
		
		$cd_almacen = $_GET ['id'];
	
		//se elimina el almacen.
		$manager = new AlmacenManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarAlmacen( $cd_almacen );
			$forward = 'eliminar_almacen_success';
			//commit de la transacci�n.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_almacen_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}
		
		return $forward;
	}

	public function getFuncion(){
		return "Baja Almacen";
	}
	
}