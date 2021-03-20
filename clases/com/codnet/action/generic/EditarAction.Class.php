<?php 

/**
 * Acciï¿½n para para editar una entidad.
 * 
 * @author bernardo
 * @since 21-04-2010
 * 
 */
abstract class EditarAction extends SecureAction{

	/**
	 * entidad a editar.
	 * @return unknown_type
	 */
	protected abstract function getEntidad();
	
	/**
	 * se edita la entidad.
	 * @param $oEntidad
	 * @return unknown_type
	 */
	protected abstract function editar($oEntidad);
	
	/**
	 * forward para el success de la ediciï¿½n.
	 * @return unknown_type
	 */
	protected abstract function getForwardSuccess();
	
	/**
	 * forward para cuando hay error.
	 * @return unknown_type
	 */
	protected abstract function getForwardError();
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#executeImpl()
	 */
	public function executeImpl(){
				
		$id_entidad = $this->getIdEntidad();
		$oEntidad = $this->getEntidad();
				
		//se inicia una transacción.
		DbManager::begin_tran();
		
		try{
			$this->editar( $oEntidad );
			$forward = $this->getForwardSuccess();
			//commit de la transacción.
			DbManager::save();
		}catch(GenericException $ex){
			$forward = $this->getForwardError();
			$this->setDs_forward_params( 'id='. $id_entidad .'&er=1'.'&msg=' .$ex->getMessage() . '&code=' . $ex->getCode() );
			//rollback de la transacción.
			DbManager::undo();
		}
		
		return $forward;
	}
	
	public function getIdEntidad(){
		return $_GET ['id'];
	}
	
}