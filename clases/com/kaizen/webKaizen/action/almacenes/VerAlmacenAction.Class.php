<?php 

/**
 * Acción para visualizar un almacén.
 *  
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
class VerAlmacenAction extends SecureOutputAction{

	/**
	 * consulta un almacen.
	 * @return forward.
	 */
	protected function getContenido(){
			
		$xtpl = new XTemplate ( APP_PATH . 'almacenes/veralmacen.html' );
		
		if (isset ( $_GET ['id'] )) {
			$cd_almacen = $_GET ['id'];
			
			$manager = new AlmacenManager();
			
			try{
				$oAlmacen = $manager->getAlmacenPorId ( $cd_almacen );
			}catch(GenericException $ex){
				$oAlmacen = new Almacen();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el almacen.
			$xtpl->assign ( 'cd_almacen', $oAlmacen->getCd_almacen());
			$xtpl->assign ( 'ds_nombre', stripslashes ( htmlentities( $oAlmacen->getDs_nombre () ) ) );
			$xtpl->assign ( 'ds_email', stripslashes ( $oAlmacen->getDs_email () ) );
			$xtpl->assign ( 'ds_cuit', stripslashes ( $oAlmacen->getDs_cuit () ) );
			$xtpl->assign ( 'ds_telefono', stripslashes ( $oAlmacen->getDs_telefono () ) );
			$xtpl->assign ( 'ds_celular', stripslashes ( $oAlmacen->getDs_celular () ) );
			$xtpl->assign ( 'ds_domicilio', stripslashes ( htmlentities( $oAlmacen->getDs_domicilio () ) ) );
			$xtpl->assign ( 'ds_comentario', stripslashes ( htmlentities( $oAlmacen->getDs_comentario () ) ) );
			$xtpl->assign ( 'ds_contacto', stripslashes ( htmlentities( $oAlmacen->getDs_contacto () ) ) );
			$xtpl->assign ( 'ds_localidad', stripslashes ( htmlentities( $oAlmacen->getDs_localidad () ) ) );
			$xtpl->assign ( 'ds_provincia', stripslashes ( htmlentities( $oAlmacen->getDs_provincia() ) ) );
										
		}
		
		$xtpl->assign ( 'titulo', $this->getTitulo() );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}
	
	public function getFuncion(){
		return "Ver Almacen";
	}
	
	public function getTitulo(){
		return "Detalle de Almac&eacute;n";
	}
	
	
}