<?php

/**
 * @author bernardo
 * @since 02-03-2010
 * 
 * Contiene el mapeo de las acciones.
 * Utilizada por el ActionController para:
 *  1- buscar las acciones a ejecutar.
 *  2- realizar los forwards.
 * 
 */
class ActionMapHelper{
	
	//array con el mapeo de las acciones. 
	private $action_map =  array(); //( [nombre_accion] = clase_accion )
	
	//array con el mapeo de los forwards.
	private $forward_map =  array(); // ( [descripcion] = url )
	
	
	//Método constructor
	
	public function ActionMapHelper(){

		$navegacion = LoadNavigation::getInstance();

		foreach ($navegacion->getAccionesDefault() as $accionDefault) {
			$this->initAccionesDefault($accionDefault['entidad'], $accionDefault['plural']);
		}
		
		foreach ($navegacion->getAcciones() as $accion) {
			$this->setAction($accion['nombre'], $accion['clase']);
		}
		
		foreach ($navegacion->getForwards() as $forward) {
			$this->setForward($forward['nombre'], $forward['url']);
		}


	}

	
	
	//Métodos Get
	
	function getAction($ds_action_name) {
		return $this->action_map[$ds_action_name];
	}
	
	function getForward($ds_key) {
		return $this->forward_map[$ds_key];
	}
	
	//Métodos Set

	function setAction($ds_action_name,$ds_action_class){
		$this->action_map[$ds_action_name]=$ds_action_class;		
	}	
	
	function setForward($ds_forward,$ds_url){
		$this->forward_map[$ds_forward]=$ds_url;
	}
	
	//Funciones
		
	
	/**
	 * setea las acciones Listar/Alta/Modificar/Baja/Ver para una entidad.
	 * 
	 * @param $ds_entidad nombre de la entidad.
	 * @param unknown_type $ds_entidad_plural nombre de la entidad en plural
	 * @return none
	 */
	protected function initAccionesDefault($ds_entidad, $ds_entidad_plural=null){
		if($ds_entidad_plural==null)
			$ds_entidad_plural = $ds_entidad;
			
		$ds_entidad_capital_letter = strtoupper( substr($ds_entidad,0,1) ) . substr($ds_entidad,1);
		$ds_entidad_plural_capital_letter = strtoupper( substr($ds_entidad_plural,0,1) ) . substr($ds_entidad_plural,1);
		
		//alta init
		$this->setAction('alta_'.$ds_entidad.'_init', 'Alta'.$ds_entidad_capital_letter.'InitAction');
				
		//alta.
		$this->setAction('alta_'.$ds_entidad.'', 'Alta'.$ds_entidad_capital_letter.'Action');
		$this->setForward('alta_'.$ds_entidad.'_error','doAction?action=alta_'.$ds_entidad.'_init');
		$this->setForward('alta_'.$ds_entidad.'_success','doAction?action=listar_'.$ds_entidad_plural);

		//modificar init.
		$this->setAction('modificar_'.$ds_entidad.'_init', 'Modificar'.$ds_entidad_capital_letter.'InitAction');
		
		//modificar.
		$this->setAction('modificar_'.$ds_entidad.'', 'Modificar'.$ds_entidad_capital_letter.'Action');
		$this->setForward('modificar_'.$ds_entidad.'_error','doAction?action=modificar_'.$ds_entidad.'_init');
		$this->setForward('modificar_'.$ds_entidad.'_success','doAction?action=listar_'.$ds_entidad_plural);
		
		//listar.
		$this->setAction('listar_'.$ds_entidad_plural, 'Listar'.$ds_entidad_plural_capital_letter.'Action');
		$this->setForward('listar_'.$ds_entidad_plural.'_error','doAction?action=error');
		
		//eliminar .
		$this->setAction('eliminar_'.$ds_entidad.'', 'Eliminar'.$ds_entidad_capital_letter.'Action');
		$this->setForward('eliminar_'.$ds_entidad.'_error','doAction?action=listar_'.$ds_entidad_plural);
		$this->setForward('eliminar_'.$ds_entidad.'_success','doAction?action=listar_'.$ds_entidad_plural);

		//ver.
		$this->setAction('ver_'.$ds_entidad.'', 'Ver'.$ds_entidad_capital_letter.'Action');		
		
	}
	
}