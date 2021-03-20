<?php 

/**
 * Acción para visualizar un cliente.
 *  
 * @author Lucrecia
 * @since 18-01-2011
 * 
 */
class VerSucursalAction extends SecureOutputAction{

	/**
	 * consulta una sucursal.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'sucursales/versucursal.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_sucursal = $_GET ['id'];
			
			$manager = new SucursalManager();
			
			try{
				$oSucursal = $manager->getSucursalPorId ( $cd_sucursal );
			}catch(GenericException $ex){
				$oSucursal = new Sucursal();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra la sucursal
			$xtpl->assign ( 'cd_sucursal', $oSucursal->getCd_sucursal());
			$xtpl->assign ( 'ds_nombre', stripslashes ( $oSucursal->getDs_nombre () ) );
			$xtpl->assign ( 'ds_email', stripslashes ( $oSucursal->getDs_email () ) );
			$xtpl->assign ( 'ds_telefono', stripslashes ( $oSucursal->getDs_telefono () ) );
			$xtpl->assign ( 'ds_domicilio', stripslashes ( $oSucursal->getDs_domicilio () ) );
			$xtpl->assign ( 'ds_comentario', stripslashes ( $oSucursal->getDs_comentario () ) );
			$xtpl->assign ( 'ds_localidad', stripslashes ( $oSucursal->getDs_localidad () ) );
			$xtpl->assign ( 'ds_provincia', stripslashes ( $oSucursal->getDs_provincia() ) );
			$xtpl->assign ( 'ds_pais', stripslashes ( $oSucursal->getDs_pais() ) );
						
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de sucursal' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver Sucursal";
	}
	
	public function getTitulo(){
		return "Detalle de Sucursal";
	}
	
	
}