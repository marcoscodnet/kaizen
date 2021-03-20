<?php

/**
 * Acceso a datos para pedidos.
 *
 * @author Mar�a Jes�s
 * @since 23-08-2011
 *
 */
class PedidoQuery {

    static function insertPedido(Pedido $obj) {
        $db = DbManager::getConnection();

        $cd_pedido = $obj->getCd_pedido();
        //$cd_pieza = $obj->getCd_pieza();
        $cd_pieza = FormatUtils::ifEmpty($obj->getCd_pieza(), '0');
        $ds_pieza = $obj->getDs_pieza();
        $nu_cantidad = $obj->getNu_cantidad();
        $qt_minimo = $obj->getQt_minimo();
        $qt_sena = $obj->getQt_sena();
        $cd_estado = $obj->getCd_estado();
        $dt_pedido = $obj->getDt_pedido();
        $ds_observacion = $obj->getDs_observacion();

        $sql = "INSERT INTO pedido (cd_pieza, ds_pieza, nu_cantidad, qt_minimo, qt_sena, cd_estado, dt_pedido, ds_observacion)";
        $sql .= " VALUES ('$cd_pieza', '$ds_pieza', '$nu_cantidad', '$qt_minimo', '$qt_sena', '$cd_estado', '$dt_pedido', '$ds_observacion')";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        $id = PedidoQuery::insert_id($db);
        $obj->setCd_pedido($id);
    }

    static function insert_id($db) {
        $db = DbManager::getConnection();
        $sql = "SELECT MAX(`cd_pedido`) as id FROM pedido ";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException();
        $next = $db->sql_fetchassoc($result);
        $id = $next['id'];
        $db->sql_freeresult($result);
        return ($id );
    }

    static function getPedidos(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT P.cd_pedido, P.dt_pedido, P.ds_observacion as obs, P.ds_pieza, P.cd_estado, Pi.* FROM pedido P";
        $sql .= " LEFT JOIN pieza Pi ON Pi.cd_pieza = P.cd_pieza ";
        $sql .= " LEFT JOIN estadopedido EP ON P.cd_estado = EP.cd_estadopedido ";
        $sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$pedidos = ResultFactory::toCollection($db,$result,new PedidoFactory());
		$db->sql_freeresult($result);
		return $pedidos;
    }

    static function getCantPedidos(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql .= "SELECT count(*) as count FROM pedido P ";
        $sql .= " LEFT JOIN pieza Pi ON Pi.cd_pieza = P.cd_pieza ";
        $sql .= " LEFT JOIN estadopedido EP ON P.cd_estado = EP.cd_estadopedido ";

        $sql .= $criterio->buildFiltroSinPaginar();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc ( $result );
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return (( int ) $cant);
    }

    static function getPedido(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();

		$sql = "SELECT P.*, P.ds_observacion as obs, P.qt_minimo as qmin, Pi.* FROM pedido P";
        $sql .= " LEFT JOIN pieza Pi ON Pi.cd_pieza = P.cd_pieza ";
        $sql .= " LEFT JOIN estadopedido EP ON EP.cd_estadopedido = P.cd_estado ";

		$sql .= $criterio->buildFiltro();

		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$pedido = new Pedido();
		if ($db->sql_numrows () > 0) {
			$temp = $db->sql_fetchassoc ( $result );
			$factory = new PedidoFactory();
			$pedido = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $pedido;
    }

    static function modificarPedido(Pedido $obj) {
        $db = DbManager::getConnection();

        $cd_pedido = $obj->getCd_pedido();
        $cd_pieza = $obj->getCd_pieza();
        $ds_pieza = $obj->getDs_pieza();
        $nu_cantidad = $obj->getNu_cantidad();
        $qt_minimo = $obj->getQt_minimo();
        $qt_sena = $obj->getQt_sena();
        $cd_estado = $obj->getCd_estado();
        $dt_pedido = $obj->getDt_pedido();
        $ds_observacion = $obj->getDs_observacion();

        $sql = "UPDATE pedido SET cd_pieza = '$cd_pieza', ds_pieza = '$ds_pieza', cd_estado = '$cd_estado', nu_cantidad = '$nu_cantidad', qt_minimo = '$qt_minimo', ";
        $sql .= "qt_sena = '$qt_sena', dt_pedido = '$dt_pedido', ds_observacion = '$ds_observacion'";
        $sql .= " WHERE cd_pedido = " . $cd_pedido;
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

    static function eliminarPedido(Pedido $obj) {
        $db = DbManager::getConnection();
		$cd_pedido = $obj->getCd_pedido ();
		$sql = "DELETE FROM pedido WHERE cd_pedido = $cd_pedido";
		$result = $db->sql_query ( $sql );
		if(!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());
    }

}
?>
