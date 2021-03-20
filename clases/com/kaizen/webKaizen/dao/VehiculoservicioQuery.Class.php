<?php

/**
 * Acceso a datos para vehiculoservicio.
 *
 * @author Marcos
 * @since 16-05-12
 *
 */
class VehiculoservicioQuery {

	static function insertVehiculoservicio(Vehiculoservicio $obj) {
		$db = DbManager::getConnection();

		
		$nu_motor = $obj->getNu_motor();
		$nu_chasis = $obj->getNu_chasis();
		
		
		$nu_anio = $obj->getNu_anio();
		$ds_modelo = $obj->getDs_modelo();
		$dt_venta = $obj->getDt_venta();

		$sql = "INSERT INTO vehiculo_servicio (nu_motor, nu_chasis, nu_anio, ds_modelo, dt_venta)";
		$sql .= " VALUES ('$nu_motor', '$nu_chasis', '$nu_anio', '$ds_modelo','$dt_venta')";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
		
		//seteamos el nuevo id.
		$cd = $db->sql_nextid();
        $obj->setCd_vehiculoservicio( $cd );
	}


	/*static function getVehiculoservicioes(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();

		$sql = "SELECT U.cd_vehiculoservicio as id, U.*, P.*, TU.*, MA.*, M.*,C.*, S.*, VU.cd_venta,A.*,  CONCAT(TU.ds_tipo_vehiculoservicio, ' ', MA.ds_marca, ' ', M.ds_modelo, ' ', C.ds_color) as ds_producto FROM vehiculoservicio U";
		$sql .= " LEFT JOIN producto P ON P.cd_producto = U.cd_producto ";
		$sql .= " LEFT JOIN tipo_vehiculoservicio TU ON P.cd_tipo_vehiculoservicio = TU.cd_tipo_vehiculoservicio ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color=P.cd_color ";
		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = U.cd_sucursal_actual ";
		$sql .= " LEFT JOIN venta_vehiculoservicio VU ON VU.cd_vehiculoservicio = U.cd_vehiculoservicio ";
		$sql .= " LEFT JOIN autorizacion A ON A.cd_vehiculoservicio = U.cd_vehiculoservicio ";
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);

		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$vehiculoservicioes = ResultFactory::toCollection($db, $result, new VehiculoservicioFactory());
		$db->sql_freeresult($result);

		return $vehiculoservicioes;
	}

	static function getCantVehiculoservicioes(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT count(*) as count FROM vehiculoservicio U ";
		$sql .= " LEFT JOIN producto P ON P.cd_producto = U.cd_producto ";
		$sql .= " LEFT JOIN tipo_vehiculoservicio TU ON P.cd_tipo_vehiculoservicio = TU.cd_tipo_vehiculoservicio ";
		$sql .= " LEFT JOIN marca MA ON MA.cd_marca = P.cd_marca ";
		$sql .= " LEFT JOIN modelo M ON M.cd_modelo=P.cd_modelo ";
		$sql .= " LEFT JOIN color C ON C.cd_color=P.cd_color ";
		$sql .= " LEFT JOIN sucursal S ON S.cd_sucursal = U.cd_sucursal_actual ";
		$sql .= " LEFT JOIN venta_vehiculoservicio VU ON VU.cd_vehiculoservicio = U.cd_vehiculoservicio ";
		$sql .= " LEFT JOIN autorizacion A ON A.cd_vehiculoservicio = U.cd_vehiculoservicio ";
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}*/

	static function eliminarVehiculoservicio(Vehiculoservicio $obj) {
		$db = DbManager::getConnection();
		$cd_vehiculoservicio = $obj->getCd_vehiculoservicio();
		$sql = "DELETE FROM vehiculo_servicio WHERE cd_vehiculo_servicio = $cd_vehiculoservicio";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}

	static function getVehiculoservicio(CriterioBusqueda $criterio) {
		$db = DbManager::getConnection();
		$sql = "SELECT U.* FROM vehiculo_servicio U";
		
		$sql .= $criterio->buildFiltro();
		
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());

		$vehiculoservicio = new Vehiculoservicio();
		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new VehiculoservicioFactory();
			$vehiculoservicio = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $vehiculoservicio;
	}


	

	static function modificarVehiculoservicio(Vehiculoservicio $obj) {
		$db = DbManager::getConnection();
		$cd_vehiculoservicio = $obj->getCd_vehiculoservicio();
		
		$nu_motor = $obj->getNu_motor();
		$nu_chasis = $obj->getNu_chasis();
		
		
		$nu_anio = $obj->getNu_anio();
		$ds_modelo = $obj->getDs_modelo();
		$dt_venta = $obj->getDt_venta();

		$sql = "UPDATE vehiculo_servicio SET nu_motor = '$nu_motor', nu_chasis = '$nu_chasis', ";
		$sql .= "nu_anio = '$nu_anio', ds_modelo = '$ds_modelo', dt_venta = '$dt_venta'";
		$sql .= " WHERE cd_vehiculo_servicio = " . $cd_vehiculoservicio;

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
		throw new DBException($db->sql_error());
	}



	

}
?>