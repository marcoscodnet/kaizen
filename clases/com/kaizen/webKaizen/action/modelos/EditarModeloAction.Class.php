<?php 

/**
 * Acción para editar una localidad.
 * 
 * @author Lucrecia
 * @since 22-04-2010
 * 
 */
abstract class EditarModeloAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oModelo = new Modelo();

		if (isset ( $_POST ['cd_modelo'] ))
			$oModelo->setCd_modelo (  $_POST ['cd_modelo']  );
		
		if (isset ( $_POST ['ds_modelo'] ))
			$oModelo->setDs_modelo (  $_POST ['ds_modelo']  );
		
		if (isset ( $_POST ['cd_marca'] ))
			$oModelo->setCd_marca (  $_POST ['cd_marca'] );
		
		return $oModelo;
	}
}