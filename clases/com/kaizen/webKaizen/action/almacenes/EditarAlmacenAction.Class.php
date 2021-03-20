<?php 

/**
 * Acción para editar un almacén.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
abstract class EditarAlmacenAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oAlmacen = new Almacen();
		
		if (isset ( $_POST ['cd_almacen'] ))
			$oAlmacen->setCd_almacen ( $_POST ['cd_almacen']  );
		
		if (isset ( $_POST ['ds_nombre'] ))
			$oAlmacen->setDs_nombre (  $_POST ['ds_nombre'] ) ;
		
		if (isset ( $_POST ['ds_cuit'] ))
			$oAlmacen->setDs_cuit (  $_POST ['ds_cuit'] ) ;
		
		if (isset ( $_POST ['ds_email'] ))
			$oAlmacen->setDs_email (  $_POST ['ds_email'] ) ;
		
		if (isset ( $_POST ['ds_celular'] ))
			$oAlmacen->setDs_celular ( $_POST ['ds_celular'] ) ;
		
		if (isset ( $_POST ['ds_telefono'] ))
			$oAlmacen->setDs_telefono (  $_POST ['ds_telefono'] ) ;
		
		if (isset ( $_POST ['ds_contacto'] ))
			$oAlmacen->setDs_contacto (  $_POST ['ds_contacto'] ) ;
		
		if (isset ( $_POST ['ds_comentario'] ))
			$oAlmacen->setDs_comentario (  $_POST ['ds_comentario'] ) ;
		
		if (isset ( $_POST ['ds_domicilio'] ))
			$oAlmacen->setDs_domicilio (  $_POST ['ds_domicilio'] ) ;

		if (isset ( $_POST ['localidad'] ))
			$oAlmacen->setCd_localidad(  $_POST ['localidad'] ) ;
				
		return $oAlmacen;
	}
}