<?php
/**
 * Acción obtener una obra dada utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 13-04-2010
 *
 */
class GetObraAction extends SecureAjaxAction{

	private $label;
	//para validar si está cerrada.
	//si $validar_cerrada=true entonces no dejará obtener una obra que esté cerrada.
	private $validarCerrada;
	private $campoRequerido=false;
	
	function GetObraAction($value=null){
		if(!empty( $value ))
			$this->label = $value;
		else
			$this->label = '';	
	}
	
	public function setValidarCerrada($value){
		$this->validarCerrada=$value;
	}
	
	public function setCampoRequerido($value){
		$this->campoRequerido=$value;
	}
	
	/**
	 * se obtiene un tipo de producto seleccionado
	 * dentro de un combo.
	 */
	public function executeImpl(){

		if (isset ( $_GET ['cd_obra'] ))
			$cd_obra = $_GET ['cd_obra'];
		else
			$cd_obra = '';
			
		if (isset ( $_GET ['validarCerrada'] ))
			$this->validarCerrada = $_GET ['validarCerrada'];
		
		$xtpl = new XTemplate ( APP_PATH. 'obras/obra.html' );
		$xtpl->assign('WEB_PATH', WEB_PATH);					
		//recupera la obra por su código.
		if(!empty( $cd_obra )){
			$obraManager = new ObraManager();
			$oObra = $obraManager->getObraPorId( $cd_obra );
			
			if(!FormatUtils::isEmpty ( $oObra->getCd_obra() )){
				
				if($this->validarCerrada && $oObra->getBl_cerrada() ){
					
					$xtpl->assign( 'cd_obra', '' );
					$xtpl->assign( 'ds_obra', '' );
					$xtpl->assign( 'msj_error', 'La obra con C&oacute;digo <strong>' .  $cd_obra . '</strong> est&aacute; cerrada') ;
					
				}else{
					$xtpl->assign( 'cd_obra', $oObra->getCd_obra() );
					$xtpl->assign( 'ds_obra', htmlentities ( $oObra->getDs_tipoObraFormateada() . ' / ' . $oObra->getDs_subtipoObraFormateada() )) ;
					$xtpl->assign( 'msj_error', '') ;
				}
				
				
			}
		}
		
		$xtpl->assign( 'label', $this->label );
		
		if($this->campoRequerido)
			$xtpl->assign( 'cd_class', "fValidate['required']" );
		else
			$xtpl->assign( 'cd_class', "" );
			
		$xtpl->parse ( 'main' );
		
		return $xtpl->text('main');
	}
	
	public function getFuncion(){
		return null;
	}
	
}