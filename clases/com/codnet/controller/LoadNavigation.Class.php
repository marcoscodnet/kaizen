<?php

/**
 * @author bernardo
 * @since 26-04-2010
 * 
 * Carga el mapeo de acciones y forwards desde un xml.
 * 
 * 
 */
class LoadNavigation{

	private static $instancia;
	
	private $acciones_default;
	private $acciones;
	private $forwards;

	private function __construct(){
		 $this->forwards = array();
		 $this->acciones = array();
		 $this->acciones_default = array();
	}

	public static function getInstance(){
		if (  !self::$instancia instanceof self ) {
			self::$instancia = new self;
			self::$instancia->load();
		}
		
		return self::$instancia;
	}
		
	/**
	 * carga desde un xml las acciones y los forwards para el controller.
	 * @return unknown_type
	 */
	public function load(){
		
		$xml = simplexml_load_file(APP_PATH .  'includes/navigation.xml');
		
		/* se cargan las acciones por default. */
		foreach ($xml->accion_default as $accion_default) {
			$accion_nueva = array();
			foreach ($accion_default->attributes() as $key=>$value) {
				$accion_nueva[$key] = $value . '';	
			}
			$this->acciones_default[] = $accion_nueva;
		}
		
		/* se cargan las acciones. */
		foreach ($xml->accion as $accion) {
			$accion_nueva = array();
			foreach ($accion->attributes() as $key=>$value) {
				$accion_nueva[$key] = $value . '';	
			}
			$this->acciones[] = $accion_nueva;
		}
		
		/* se cargan los forwards. */
		foreach ($xml->forward as $forward) {
			$forward_nuevo = array();
			foreach ($forward->attributes() as $key=>$value) {
				$forward_nuevo[$key] = $value . '';	
			}
			$this->forwards[] = $forward_nuevo;
		}
	
	}
	
	
	public function getAccionesDefault(){
		return $this->acciones_default;
	}	
	
	public function getAcciones(){
		return $this->acciones;
	}	
	
	public function getForwards(){
		return $this->forwards;
	}	
	
	public function getAccionPorNombre( $nombre ){

		foreach ($this->getAcciones() as $accion) {
			
			if( $accion['nombre'] == $nombre )
				return $accion;
			 
		}

		//si no está la buscamos en las acciones default.
		foreach ($this->getAccionesDefault() as $accionDefault) {
			$entidad = $accionDefault['entidad'];
			$plural = $accionDefault['plural'];

			//obtenemos las acciones implicadas.
			$acciones_default = $this->getAccionesDeAccionDefault($entidad, $plural );
			//vemos si corresponde a alguna de ellas.
			foreach( $acciones_default as $accion ){
				if($accion == $nombre){
					return $accionDefault;
				}
			}
		}
		
		return null;
	}
	
	/*
	 * retorna las acciones por default dada una entidad.
	 */
	public function getAccionesDeAccionDefault($ds_entidad, $ds_entidad_plural=null){
		if($ds_entidad_plural==null)
			$ds_entidad_plural = $ds_entidad;
			
		$ds_entidad_capital_letter = strtoupper( substr($ds_entidad,0,1) ) . substr($ds_entidad,1);
		$ds_entidad_plural_capital_letter = strtoupper( substr($ds_entidad_plural,0,1) ) . substr($ds_entidad_plural,1);
		
		//alta init
		$acciones[] = 'alta_'.$ds_entidad.'_init';
		//alta.
		$acciones[] = 'alta_'.$ds_entidad.'';
		//modificar init.
		$acciones[] = 'modificar_'.$ds_entidad.'_init';
		//modificar.
		$acciones[] = 'modificar_'.$ds_entidad.'';
		//listar.
		$acciones[] = 'listar_'.$ds_entidad_plural;
		//eliminar .
		$acciones[] = 'eliminar_'.$ds_entidad.'';
		//ver.
		$acciones[] = 'ver_'.$ds_entidad.'';		

		return $acciones;
	}
	
	
	
}