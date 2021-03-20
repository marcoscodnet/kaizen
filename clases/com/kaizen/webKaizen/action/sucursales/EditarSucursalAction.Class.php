<?php 

/**
 * Acción para editar una sucursal.
 * 
 * @author Lucrecia
 * @since 22-04-2010
 * 
 */
abstract class EditarSucursalAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oSucursal = new Sucursal();

		if (isset ( $_POST ['cd_sucursal'] ))
			$oSucursal->setCd_sucursal (  $_POST ['cd_sucursal']  );
		
		if (isset ( $_POST ['ds_nombre'] ))
			$oSucursal->setDs_nombre (  $_POST ['ds_nombre']  );
		
		if (isset ( $_POST ['ds_email'] ))
			$oSucursal->setDs_email (  $_POST ['ds_email'] ) ;
		
		if (isset ( $_POST ['ds_telefono'] ))
			$oSucursal->setDs_telefono ( $_POST ['ds_telefono'] ) ;
		
		if (isset ( $_POST ['ds_comentario'] ))
			$oSucursal->setDs_comentario ( $_POST ['ds_comentario'] ) ;
		
		if (isset ( $_POST ['ds_domicilio'] ))
			$oSucursal->setDs_domicilio ( $_POST ['ds_domicilio'] ) ;
		
		if (isset ( $_POST ['localidad'] ))
			$oSucursal->setCd_localidad( $_POST ['localidad'] ) ;

		return $oSucursal;
	}
}