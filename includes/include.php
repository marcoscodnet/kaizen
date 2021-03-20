<?php
/*****************************************************************
* Los chequeos de si existe la funcion o está definida es porque
* se necesita para el menu y para los index, y sino se redefinen
* ****************************************************************/

if (! defined ( 'ROW_PER_PAGE' ))
	define('ROW_PER_PAGE', 15);

if (! defined ( 'APP_PATH' ))
	define ( 'APP_PATH', $_SERVER ['DOCUMENT_ROOT'] . '/kaizen/' );

if (! defined ( 'WEB_PATH' ))
	define ( 'WEB_PATH', 'http://' . $_SERVER ['HTTP_HOST'] . '/kaizen/' );


if (! defined ( 'CLASS_PATH' ))
	define ( 'CLASS_PATH', 'clases/com/' );

	
//incluimos el classLoader.
include_once APP_PATH . CLASS_PATH . 'codnet/utils/ClassLoader.Class.php';


include_once 'conf.php';
include_once 'constantes.php';

if (! function_exists ( '__autoload' )) {
	function __autoload($class_name) {
		if ($class_name != 'ClassLoader'){
			
			//el class loader se encarga de incluir la clase.
			try{
				ClassLoader::loadClass($class_name);
			}catch(ClassNotFoundException $e){
				//TODO hacer algo!!!					
			}
			
		}
	}
}

?>