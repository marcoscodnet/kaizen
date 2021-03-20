<?php 

/**
 * Acci�n para inicializar la vista.
 * Las acciones seguras con salida a pantalla extender�n
 * esta clase.
 * Cada subclase implementar� m�todos para devolver el contenido
 * a mostrar, el t�tulo y el layout a utilizar. Dicho layout deber�
 * implementar la interfaz SecureLayout la cual especifica m�todos
 * necesarios para mostrar en pantalla el contenido con un t�tulo y 
 * un men�.
 * 
 * @author bernardo
 * @since 07-04-2010
 * 
 */
abstract class SecureOutputAction extends SecureAction{

	/**
	 * inicializa la vista, el layout.
	 * @return none.
	 */
	public function executeImpl(){
		
		//armamos el layout.
		$layout = $this->getSecureLayout();
		$layout->setContenido( $this->getContenido() );
		
		$layout->setMenu( $this->getMenuHTML( $this->getMenuActivo() ) );
		
		$layout->setTitulo( $this->getTitulo() );
		
		echo $layout->showLayout();
		
		//para que no haga el forward.
		$forward = null;
				
		return $forward;
	}
	
	/**
	 * layout a utilizar para la salida.
	 * @return Layout
	 */
	protected function getSecureLayout(){
		//el layuout ser� definido en la constante DEFAULT_SECURE_LAYOUT
		
		//instanciamos el layout por reflection.
		$oClass = new ReflectionClass(DEFAULT_SECURE_LAYOUT);
		$oLayout = $oClass->newInstance();
		
		return $oLayout;
	}
	
	/*
	 * contenido a mostrar.
	 */
	protected abstract function getContenido();
	
	/*
	 * t�tulo de la pantalla.
	 */
	protected abstract function getTitulo();
	
	/**
	 * nombre del men� activo.
	 * @return men� activo
	 */
	protected function getMenuActivo(){
		//cada listado el men� activo.
	}
	
	
}