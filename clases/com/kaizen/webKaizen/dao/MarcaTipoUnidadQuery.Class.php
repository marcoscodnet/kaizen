<?php
class MarcaTipoUnidadQuery {

	function insertMarcaTipoUnidad(MarcaTipoUnidad $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$cd_tipounidad = $obj->getCd_tipounidad ();
		$sql = "INSERT INTO 'marca_tipo_unidad' ('cd_marca' ,'cd_tipo_unidad') VALUES ('$cd_marca' ,'$cd_tipounidad') ";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
	}

	function getTiposunidadesDeMarca(MarcaTipoUnidad $obj) {
		$db = DbManager::getConnection();
		$cd_marca = $obj->getCd_marca ();
		$sql = "SELECT TU.* FROM marca_tipo_unidad MTU";
		$sql = " LEFT JOIN tipo_unidad TU ON TU.cd_tipo_unidad = MTU.cd_marca_tipo_unidad ";
		$sql .= " WHERE MTU.cd_marca = $cd_marca";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException();
		$tiposunidades = ResultFactory::toCollection($db,$result,new TipounidadFactory());
		$db->sql_freeresult($result);
		return ($tiposunidades);
	}

	function modificarTiposunidadesDeMarca(Marca $obj, Array $tiposunidades) {
		//me conecto a la BD
		$db = DbManager::getConnection();
		//Borro todas las filas de esa marca
		$cd_marca = $obj->getCd_marca ();
		$sql = "DELETE  FROM marca_tipo_unidad WHERE cd_marca = $cd_marca";
		$exito = $db->sql_query ( $sql );
		if(!$exito)//hubo un error en la bbdd.
		throw new DBException();
		else {
			$i = 0;
			$limit = count ( $tiposunidades );
			while ( $i < $limit ) {
				$pf = $tiposunidades [$i];
				$cd_marca = $pf->getCd_marca ();
				$cd_tipounidad = $pf->getCd_tipounidad ();
				$sql = "INSERT INTO marca_tipo_unidad (cd_marca, cd_tipo_unidad) VALUES($cd_marca, $cd_tipounidad)";
				$exitoPF = $db->sql_query ( $sql );

				if (! $exitoPF) {
					throw new DBException();
				}
				$i ++;
			}
		}

		$db->sql_freeresult($result);
	}

	function insertarTiposunidadesDeMarca(Marca $obj, Array $tiposunidades) {
		//me conecto a la BD
		$db = DbManager::getConnection();
		$i = 0;
		$limit = count ( $tiposunidades );
		while ( $i < $limit ) {
			$pf = $tiposunidades [$i];
			$cd_marca = $obj->getCd_marca();
			$cd_tipounidad = $pf->getCd_tipounidad ();
			$sql = "INSERT INTO marca_tipo_unidad (cd_marca, cd_tipo_unidad) VALUES($cd_marca, $cd_tipounidad)";
			$exitoPF = $db->sql_query ( $sql );
			if (! $exitoPF) {
				throw new DBException();
			}
			$i ++;
		}
		$db->sql_freeresult($result);
		return true;
	}
}
?>