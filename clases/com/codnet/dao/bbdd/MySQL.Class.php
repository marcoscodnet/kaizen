<?php

//define("SQL_LAYER","mysql");

class MySQL implements IDatabase{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/dao/bbdd/IDatabase#connect($sqlserver, $sqluser, $sqlpassword, $database)
	 */
	function connect($sqlserver, $sqluser, $sqlpassword, $database)	{

		//conecta a la base.
		//selecciona el esquema en el server de la base.
		//retorna la conección.
		
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;
		
		$this->db_connect_id = mysqli_connect($this->server, $this->user, $this->password);
		
		if($this->db_connect_id)
		{
			if($database != "")
			{
				$this->dbname = $database;
				$dbselect = @mysqli_select_db($this->db_connect_id, $this->dbname);
				if(!$dbselect)
				{
					@mysqli_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}
			return $this->db_connect_id;
		}
		else
		{
			return false;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/dao/bbdd/IDatabase#sql_close()
	 */
	function sql_close()
	{
		if($this->db_connect_id)
		{
			/*if($this->query_result)
			{
				@mysql_free_result($this->query_result);
			}*/
			$result = @mysqli_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/dao/bbdd/IDatabase#sql_query($query)
	 */
	function sql_query($query)
	{
		// Remove any pre-existing queries
		unset($this->query_result);
		$this->num_queries++;
		$this->query_result = mysqli_query($this->db_connect_id, $query);
		if (LOG_SQL){
			//if (trim(strtoupper(substr($query,0,7)))!='SELECT'){
				$nombreFile=date('Ymd');
				$_Log = fopen(APP_PATH."logs/".$nombreFile.".log", "a+") or die("Operation Failed!");
				FuncionesComunes::_log($_SESSION['ds_usuario'].': '.$query,$_Log);
				fclose($_Log); 
			//}
		}
		return $this->query_result;
		/*	
		if($this->query_result)
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			return $this->query_result;
		}
		else
		{
			return ( $transaction == END_TRANSACTION ) ? true : false;
		}*/
	}

	//
	// Other query methods
	//
	function sql_numrows($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_num_rows($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_affectedrows()
	{
		if($this->db_connect_id)
		{
			$result = @mysqli_affected_rows($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_num_fields($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_field_name($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $query_id = 0)
	{  
	  /* TODO
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_field_type($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}*/
	}
	function sql_fetchrow($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$this->row[$query_id] = @mysqli_fetch_array($query_id);
			return $this->row[$query_id];
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrowset($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);
			while($this->rowset[$query_id] = @mysqli_fetch_array($query_id))
			{
				$result[] = $this->rowset[$query_id];
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if($rownum > -1)
			{
				$result = @mysqli_result($query_id, $rownum, $field);
			}
			else
			{
				if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))
				{
					if($this->sql_fetchrow())
					{
						$result = $this->row[$query_id][$field];
					}
				}
				else
				{
					if($this->rowset[$query_id])
					{
						$result = $this->rowset[$query_id][$field];
					}
					else if($this->row[$query_id])
					{
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_data_seek($query_id, $rownum);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_nextid(){
		if($this->db_connect_id)
		{
			$result = @mysqli_insert_id($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		@mysqli_free_result($query_id);
		/*
		if ( $query_id )
		{
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			@mysqli_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}*/
	}
	function sql_error($query_id = 0)
	{
		$result["message"] = @mysqli_error($this->db_connect_id);
		$result["code"] = @mysqli_errno($this->db_connect_id);

		return $result;
	}
	//agregadas, solo estan para mysql
	function sql_result($result, $indice){
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return $row[$indice];
	}
	
	//agregadas, solo estan para mysql
	function sql_fetchassoc($result){
		return mysqli_fetch_assoc($result);
	}

		
	/*
	 * iniciar una transacción.
	 */
	function begin_tran(){
		return mysqli_autocommit($this->db_connect_id, FALSE);	
	}
	
	/*
	 * comitear una transacción.
	 */
	function commit_tran(){
		//return mysqli_commit($this->db_connect_id);
		return mysqli_commit($this->db_connect_id);
	}

	/*
	 * rollback de una transacción.
	 */
	function rollback_tran(){
		return mysqli_rollback($this->db_connect_id);
	}
	
	/**
	 * retorna el link de conexión actual.
	 * @return unknown_type
	 */
	function db_connect_id(){
		return $this->db_connect_id;
	}	
	
} // class sql_db

?>