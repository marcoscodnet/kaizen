<?php

/**
 * Representa un layout
 *  
 * @author bernardo
 * @since 07-04-2010
 */
abstract class Layout{

	//contenido del layout.
	private $contenido;
	//título del layout.
	private $titulo;
	//GenericExcpetion, para manejar mensajes por excepciones.
	private $exception;
	
	/**
	 * retorna el texto del layuot.
	 * @return unknown_type
	 */
	public abstract function show();
	
	
	public function getTitulo(){
		return $this->titulo;
	}
	
	public function setTitulo($value){
		$this->titulo = $value;
	}
	
	public function getContenido(){
		return $this->contenido;
	}
	
	public function setContenido($value){
		$this->contenido = $value;
	}
	
	public function setException(GenericException $exception){
		$this->exception = $exception;
	}
	
	public function getException(){
		return $this->exception;
	}
	
	public function getMensajeErrorFormateado(){
		$exception = $this->getException();
		if( !empty( $exception) ){	
			$msg  = '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">' ;
			$msg .= '	<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>';
			$msg .= $exception->getMessage();
			$msg .= '	</p>';
			$msg .= '</div>';
		}else $msg='';
		
		return $msg;		
	}	
}
