<?php



/**

 * Acci�n para visualizar una pieza.

 *

 * @author Ma. Jes�s

 * @since 18-06-2011

 *

 */

class VerPiezaAction extends SecureOutputAction{



	/**

	 * consulta una pieza.

	 * @return forward.

	 */

	protected function getContenido(){



		$xtpl = new XTemplate ( APP_PATH . 'piezas/verpieza.html' );



		if (isset ( $_GET ['id'] )) {

			$cd_pieza = $_GET ['id'];



			$manager = new PiezaManager();



			try{

				$oPieza = $manager->getPiezaPorId ( $cd_pieza );

			}catch(GenericException $ex){

				$oPieza = new Pieza();

				//TODO ver si se muestra un mensaje de error.

			}



			//se muestra la pieza.



			$xtpl->assign ( 'cd_pieza', $oPieza->getCd_pieza());

			$xtpl->assign ( 'ds_codigo', $oPieza->getDs_codigo () );

			$xtpl->assign ( 'ds_descripcion', $oPieza->getDs_descripcion() );

			$xtpl->assign ( 'nu_stock_minimo', stripslashes ( $oPieza->getNu_stock_minimo() ) );

			$xtpl->assign ( 'nu_stock_actual', stripslashes ( $oPieza->getNu_stock_actual() ) );

			$xtpl->assign ( 'qt_costo', stripslashes ( $oPieza->getQt_costo () ) );

			$xtpl->assign ( 'qt_minimo', stripslashes ( $oPieza->getQt_minimo() ) );



			$sucursales="";

			$db = DbManager::getConnection();

			$sql = "SELECT DISTINCT(s.cd_sucursal),s.ds_nombre, sum( sp.nu_cantidad) as suma_sucursal FROM stockpieza sp, pieza p, sucursal s WHERE p.cd_pieza = " .$oPieza->getCd_pieza(). "

						AND s.cd_sucursal = sp.cd_sucursal AND sp.cd_pieza = p.cd_pieza GROUP BY sp.cd_sucursal,s.ds_nombre";

			$result = $db->sql_query ( $sql );

			while ($row=$db->sql_fetchassoc($result)) {

				$sucursales=$sucursales.$row['ds_nombre'] .": " .$row['suma_sucursal']."<br>";

			}

		$xtpl->assign ( 'totales_sucursales', $sucursales );

		$db->sql_freeresult($result);



		$xtpl->assign ( 'ds_observacion', $oPieza->getDs_observacion() );

		}



		$xtpl->assign ( 'titulo', 'Detalle de pieza' );

		$xtpl->parse ( 'main' );

		return $xtpl->text ( 'main' );

	}



	public function getFuncion(){

		return "Ver Pieza";

	}



	public function getTitulo(){

		return "Detalle de Pieza";

	}





}
