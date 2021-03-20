<?php

/**
 * Acci�n para autorizar un unidad.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class DesautorizarUnidadAction extends SecureAction{

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

			$manager->desautorizarUnidad( $cd_unidad );
			$forward = 'desautorizar_unidad_success';
			//commit de la transacci�n.
			DbManager::save();

		}catch(GenericException $ex){
			$forward = 'desautorizar_unidad_error';
			$this->setDs_forward_params( 'er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode());
			//rollback de la transacci�n.
			DbManager::undo();
		}

		return $forward;
	}

	public function getFuncion(){
		return "Desautorizar Unidad";
	}

}