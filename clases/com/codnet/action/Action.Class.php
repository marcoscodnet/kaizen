<?php 

/**
 * @author bernardo
 * @since 03-03-2010
 * 
 * Las acciones son disparadas por el actionController 
 * a partir de las peticiones (request).
 * Cada acci�n est� destinada a realizar una tarea
 * espec�fica en la aplicaci�n. Tambi�n decide el destino
 * posible de acuerdo al resultado obtenido (forward).
 * 
 */
abstract class Action{

	//par�metros utilizados para el forward.
	private $ds_forward_params=null;

		
	//M�todos Get 
	
	public function getDs_forward_params(){
		return $this->ds_forward_params;
	}
	
		
	//M�todos Set 
	
	public function setDs_forward_params($value){
		$this->ds_forward_params = $value;
	}
	
	//Funciones.
	
	/**
	 * Se ejecuta la acci�n.
	 * @param $cd_usuario c�digo de usuario.
	 * @return forward.
	 * @throws GenericException
	 */
	public abstract function execute($cd_usuario);
		
	
}