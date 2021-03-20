<?php 

/**
 * Acci�n para eliminar un color.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarColorAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_color = $_GET ['id'];
	
		$manager = new ColorManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarColor( $cd_color );
			$forward = 'eliminar_color_success';
			//commit de la transacci�n.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_color_error';
			$msj = "No se puede borrar el color. Verifique que no haya productos con este color asignado.";
			$this->setDs_forward_params( 'er=1'.'&msg=' .$msj. '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}
		
		return $forward;
	}
	

	public function getFuncion(){
		return "Baja Color";
	}
	
}