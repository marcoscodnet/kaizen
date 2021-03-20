<?php 

/**
 * Acci�n para eliminar un color.
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class EliminarTipounidadAction extends SecureAction{

	/**
	 * se elimina un cliente.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){
		
		$cd_tipounidad = $_GET ['id'];
	
		$manager = new TipounidadManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();
		
		try{
			
			$manager->eliminarTipounidad( $cd_tipounidad );
			$forward = 'eliminar_tipounidad_success';
			//commit de la transacci�n.
			DbManager::save();
			
		}catch(GenericException $ex){
			$forward = 'eliminar_tipounidad_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}
		
		return $forward;
	}
	

	public function getFuncion(){
		return "Baja Tipo de unidad";
	}
	
}