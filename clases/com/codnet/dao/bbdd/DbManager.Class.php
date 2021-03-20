<?php
/**
 * Administra las conexiones a la bbdd.
 *
 * @author bernardo
 * @since 11-03-2010
 *
 */
class DbManager {

	private static $instancia;
	private $database;

	private function __construct(){
				
	}

	public static function getInstance(){
		if (  !self::$instancia instanceof self ) {
			self::$instancia = new self;
		}
		return self::$instancia;
	}

	public static function connect(){
		$current = self::getInstance();
		$current->init( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	}

	public static function undo() {
		$current = self::getInstance();
		return $current->getDatabase()->rollback_tran();
	}

	public static function begin_tran() {
		$current = self::getInstance();
		return $current->getDatabase()->begin_tran();
	}

	public static function save() {
		$current = self::getInstance();
		return $current->getDatabase()->commit_tran();
	}

	public static function close() {
		$current = self::getInstance();
		return $current->getDatabase()->sql_close();
	}
	
	public static function getConnection() {
		$current = self::getInstance();
		return $current->getDatabase();
	}
	
	public function getDatabase() {
		//return DbManager::init( $dbhost, $dbuser, $dbpasswd, $dbname);
		return $this->database;
	}
	
	
	/**
	 * conecta a la base y retorna la instancia.
	 * @return unknown_type
	 */
	private function init($dbhost, $dbuser, $dbpasswd, $dbname) {
		//instanciamos la base por reflection.
		$oClass = new ReflectionClass(DB_CLASS);
		
		//$this->database = $oClass->newInstance($dbhost, $dbuser, $dbpasswd, $dbname, false );
		$this->database = $oClass->newInstance();
		$this->database->connect($dbhost, $dbuser, $dbpasswd, $dbname );
		//print_r($dbhost.' - '.$dbuser.' - '.$dbpasswd.' - '.$dbname );
		if (! $this->database->db_connect_id()) {
			throw new DBException ( "No se puede establecer la conexión con la base de datos" );
		}
	}

	static function message_die($error_type, $error_message) {
		throw new DBException ( $error_message );
	}


}

?>