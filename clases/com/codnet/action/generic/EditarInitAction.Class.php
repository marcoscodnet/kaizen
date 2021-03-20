<?php 

/**
 * Acción para inicializar el contexto para editar
 * una entidad.
 * 
 * @author bernardo
 * @since 21-04-2010
 * 
 */
abstract class EditarInitAction extends SecureOutputAction{

	//instancia de la entidad a editar.
	protected $oEntidad;
	
	/**
	 * xtemplate para editar la entidad.
	 * @return unknown_type
	 */
	protected abstract function getXTemplate();
	
	/**
	 * acción a ejecutarse en el submit.
	 * @return unknown_type
	 */
	protected abstract function getAccionSubmit();
	
	/**
	 * entidad a editar.
	 * @return unknown_type
	 */
	protected abstract function getEntidad();

	/**
	 * parsea la entidad en el template para ser editada.
	 * @param unknown_type $entidad
	 * @param XTemplate $xtpl
	 * @return unknown_type
	 */
	protected abstract function parseEntidad($entidad, XTemplate $xtpl);
	
	/**
	 * muestra o no el código de la entidad.
	 * @return boolean
	 */
	protected abstract function getMostrarCodigo();
	
	
	/**
	 * inicializa el contexto para editar una entidad.
	 * @return forward.
	 */
	protected function getContenido(){

		$this->oEntidad = $this->getEntidad();
		
		$xtpl = new XTemplate("");

		$xtpl = $this->getXTemplate();
				
		
		$this->parseEntidad( $this->oEntidad , $xtpl);
		
		if($this->getMostrarCodigo()){
			
			$xtpl->assign ( 'display_codigo', 'block' );
		}else{

			$xtpl->assign ( 'display_codigo', 'none' );
		}
		
		//se chequean los errores.
		if (isset ( $_GET ['msg'] )) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$xtpl->assign ( 'msj', $_GET ['msg'] );
			
			//TODO acá podríamos levantar los elementos del post para
			//mostrar lo que ingresó el usuario.
		}			
		
		$xtpl->parse ( 'main.msj' );
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->assign ( 'submit', $this->getAccionSubmit() );
		
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
	
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	

	
}