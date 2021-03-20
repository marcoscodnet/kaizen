<?php 

/**
 * Acción para editar un ipo de unidad.
 * 
 * @author Marcos
 * @since 15-05-2012
 * 
 */
abstract class EditarTiposervicioAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oTiposervicio = new Tiposervicio();

		if (isset ( $_POST ['cd_tiposervicio'] ))
			$oTiposervicio->setCd_tiposervicio (  $_POST ['cd_tiposervicio']  );
		
		if (isset ( $_POST ['ds_tiposervicio'] ))
			$oTiposervicio->setDs_tiposervicio (  $_POST ['ds_tiposervicio']  );
				
		return $oTiposervicio;
	}
}