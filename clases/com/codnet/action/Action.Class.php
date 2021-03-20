<?php 

/**
 * @author bernardo
 * @since 03-03-2010
 * 
 * Las acciones son disparadas por el actionController 
 * a partir de las peticiones (request).
 * Cada acción está destinada a realizar una tarea
 * específica en la aplicación. También decide el destino
 * posible de acuerdo al resultado obtenido (forward).
 * 
 */
abstract class Action{

	//parámetros utilizados para el forward.
	private $ds_forward_params=null;

		
	//Métodos Get 
	
	public function getDs_forward_params(){
		return $this->ds_forward_params;
	}
	
		
	//Métodos Set 
	
	public function setDs_forward_params($value){
		$this->ds_forward_params = $value;
	}
	
	//Funciones.
	
	/**
	 * Se ejecuta la acción.
	 * @param $cd_usuario código de usuario.
	 * @return forward.
	 * @throws GenericException
	 */
	public abstract function execute($cd_usuario);
		
	
}