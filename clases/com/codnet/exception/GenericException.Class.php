<?php

/**
 * Excepci�n gen�rica.
 * 
 * @author bernardo
 * @since 14-03-2010
 */
class GenericException extends Exception{
	
	public function GenericException($msg=null, $cod=0){
		$error=1;
		if($msg==null)
			$msg = "No pudo realizarse la operaci�n";
		
		parent::__construct($msg, $cod);
	}
	
}
