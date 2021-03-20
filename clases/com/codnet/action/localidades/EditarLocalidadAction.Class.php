<?php 

/**
 * Acción para editar una localidad.
 * 
 * @author bernardo
 * @since 22-04-2010
 * 
 */
abstract class EditarLocalidadAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oLocalidad = new Localidad();

		if (isset ( $_POST ['cd_localidad'] ))
			$oLocalidad->setCd_localidad (  $_POST ['cd_localidad']  );
		
		if (isset ( $_POST ['ds_localidad'] ))
			$oLocalidad->setDs_localidad (  $_POST ['ds_localidad']  );
		
		if (isset ( $_POST ['provincia'] ))
			$oLocalidad->setCd_provincia (  $_POST ['provincia'] );
		
		return $oLocalidad;
	}
}