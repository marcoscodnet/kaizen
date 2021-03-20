<?php

/**
 * Acci�n para autorizar un unidad.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class AutorizarUnidadAction extends SecureAction{

	/**
	 * se autoriza una unidad.
	 * @return boolean (true=exito).
	 */
	public function executeImpl(){

		$cd_unidad = $_GET ['id'];

		//se elimina el unidad.
		$manager = new UnidadManager();

		//se inicia una transacci�n.
		DbManager::begin_tran();

		try{
				
			$manager->autorizarUnidad( $cd_unidad );
			$forward = 'autorizar_unidad_success';
			//commit de la transacci�n.
			DbManager::save();
				
		}catch(GenericException $ex){
			$forward = 'autorizar_unidad_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}

		return $forward;
	}

	public function getFuncion(){
		return "Autorizar Unidad";
	}

}