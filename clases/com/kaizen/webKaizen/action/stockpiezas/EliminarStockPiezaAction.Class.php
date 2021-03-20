<?php

/**
 * Acci�n para eliminar stock pieza.
 *
 * @author Ma. Jes�s
 * @since 15-07-2011
 *
 */
class EliminarStockPiezaAction extends SecureAction{

	/**
	 * se elimina stock pieza.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){

		$cd_stockpieza = $_GET ['id'];

		//se elimina la pieza.
		$manager = new StockPiezaManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();

		try{

			$manager->eliminarStockPieza( $cd_stockpieza );
			$forward = 'eliminar_stockPieza_success';
			//commit de la transacci�n.
			DbManager::save();

		}catch(GenericException $ex){
			$forward = 'eliminar_stockPieza_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}

		return $forward;
	}

	public function getFuncion(){
		return "Baja stock pieza";
	}

}