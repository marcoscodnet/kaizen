<?php

/**
 * Realiza el include de las clases.
 * 
 * @author bernardo
 * @since 02-03-2010
 */
class ClassLoader{
	
	
	/*
	 * Mantener esta clase como singleton ya no tiene sentido.
	 * 
	 * Ahora las clases se cargan en un hashmap en sesión.
	 * 
	 */
	
	private static $instancia;
	private $classpath;
	private function __construct(){
		 
	}

	public static function getInstance(){
		if (  !self::$instancia instanceof self ) {
			self::$instancia = new self;
			
			//self::$instancia->setClasspath(self::$instancia->armarDirectorios(APP_PATH.CLASS_PATH));
			
			
		}
		
		return self::$instancia;
	}
	
	
	/**
	 * carga la clase (include_once).
	 * @param $ds_class_name nombre de la clase a cargar.
	 * @return null.
	 */
	static function loadClass($ds_class_name){
		if(!class_exists($ds_class_name)){
			$current = self::getInstance();
			$ds_file_name = $current->getClassFile($ds_class_name);
			//echo $ds_file_name;
			include_once $ds_file_name;
		}
	}
	
	/**
	 * obtiene la ubicación de la clase.
	 * @param $ds_class_name nombre de la clase a buscar.
	 * @return $filename url de la clase.
	 */
	public function getClassFile($ds_class_name){
		/*
		$classpath = $this->getClasspath();
		$count = count($classpath);
		$found = false;
		$ds_filename = null;
		for ($i = 0; ($i < $count)&& !$found; $i++) {			
		    $ds_filename = $classpath[$i] .'/'. $ds_class_name . '.Class.php';
		    $found = file_exists($ds_filename) ;		    	
		}*/
		
		if ( !isset($_SESSION ["hashClasses"]) ){
			$_SESSION ["hashClasses"] = $this->armarHash(APP_PATH.CLASS_PATH);			
		}

		$ds_file_name = $_SESSION ["hashClasses"][$ds_class_name . '.Class.php'];
			
		$found = !empty( $ds_file_name ) ;				
		
		
		//si no encuentra la clase, volvemos a generar el hashmap por si es una clase nueva.
		if(!$found){
			$_SESSION ["hashClasses"] = $this->armarHash(APP_PATH.CLASS_PATH);
			$ds_file_name = $_SESSION ["hashClasses"][$ds_class_name . '.Class.php'];
			$found = !empty( $ds_file_name ) ;
		}
		
		
		if(!$found)
			throw new ClassNotFoundException($ds_class_name);
		return $ds_file_name;
	}

	/*
	 * @deprecated
	 */
	public function armarDirectorios($dir){
		$directorios = array();
		// Open a known directory, and proceed to read its contents
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		            $dirNext = $dir.'/'.$file;
		            if($file!='.' && $file!='..' && is_dir($dirNext) &&(!strstr($file,'svn'))){
		            	array_push ( $directorios, $dirNext );
		            	$subdirectorios = $this->armarDirectorios($dirNext);
		            	$i = 0;
		            	$limit = count ( $subdirectorios );
						while ( $i < $limit ) {
							$subdir = $subdirectorios [$i];
							array_push ( $directorios, $subdir );
							$i++;
						}
		            }
		        }
		        closedir($dh);
		    }
		}
		return $directorios;
	}

	/*
	 * arma un hash donde la key es el nombre de una clase y el value es el path al archivo de la clase.
	 * 
	 * NombreClase -> Url ubicación física: Cliente -> /codnet/modelo/Cliente.Class.php
	 * 
	 */
	public function armarHash($dir){
		$hash = array();
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		            $dirNext = $dir.'/'.$file;
		            if($file!='.' && $file!='..' && (!strstr($file,'svn'))){
		            	
		            	if( is_dir($dirNext) ){
		            		
		            		$hash = array_merge ($hash,  $this->armarHash($dirNext) );
		            								
		            	}elseif(strstr($file,'.Class.php')){
				            //vamos armando el hash.
				            $hash[$file] = $dirNext ; 	
		            	}
		            }
		        }
		        closedir($dh);
		    }
		}
		return $hash;
	}
	
	
	private function setClasspath($value){
		$this->classpath = $value;
	}
	
	private function getClasspath(){
		return $this->classpath;
	}
	
}
