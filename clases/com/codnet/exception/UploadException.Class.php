<?php

/**
 * Excepción para indicar no pude realizarse un upload.
 * 
 * @author bernardo
 * @since 10-03-2010
 */
class UploadException extends GenericException{
	
	public function UploadException(){
		$cod = 0;
		parent::__construct("No pudo realizarse el upload del archivo");
	}
}
