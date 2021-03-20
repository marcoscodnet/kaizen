<?php

/**
 * Acci�n para eliminar una pieza.
 *
 * @author Ma. Jes�s
 * @since 18-06-2011
 *
 */
class EliminarPiezaAction extends SecureAction{

	/**
	 * se elimina una pieza.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){

		$cd_pieza = $_GET ['id'];

		//se elimina la pieza.
		$manager = new PiezaManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();

		try{

			$manager->eliminarPieza( $cd_pieza );
			$forward = 'eliminar_pieza_success';
			//commit de la transacci�n.
			DbManager::save();

		}catch(GenericException $ex){
			$forward = 'eliminar_pieza_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}

		return $forward;
	}

	public function getFuncion(){
		return "Baja pieza";
	}

}